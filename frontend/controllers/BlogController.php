<?php
namespace frontend\controllers;

use app\service\BlogService;
use app\service\ReplyService;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Blog;
use common\models\Category;
use common\models\Reply;
use yii\data\Pagination;
use yii\helpers\Url;
use app\utils\StringUtil;
use common\models\es\BlogES;
use yii\elasticsearch\Query;
use yii\helpers\ArrayHelper;

//use app\utils\Client;

class BlogController extends Controller
{
	public $enableCsrfValidation = false;

	public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList()
    {
    	//$client = new Client();
		//$client->connect();
		
	    $request = Yii::$app->request;

	    $page = (!empty($request->get('page'))) ? $request->get('page') : 1;

	    $blogService = new BlogService();
	    $result = $blogService->getList($page);

	    $pages = new Pagination(['totalCount' => $result['total']]);

        return $this->render('list', [
            'models' => $result['blogs'],
            'pages' => $pages,
        ]);
    }

    public function actionListyear($year)
    {
        $beginDate = strtotime($year . "-01-01");
        $endDate = strtotime($year . "-12-31");
        $query = Blog::find()->where(['between', 'create_date', $beginDate * 1000, $endDate * 1000])->andWhere(['status' => 0])->orderBy('create_date desc');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $blogs = $query->offset($pages->offset)->limit($pages->limit)->all();

        $blogsArray = array();
        foreach ($blogs as $key => $one) {
            $content = StringUtil::getFirstPicByContent($one['content']);

            $blogArray = array(
                'id' => $one['id'],
                'title' => $one['title'],
                'content' => $content,
                'create_date' => $one['create_date']
            );
            $blogsArray[] = $blogArray;
        }

        return $this->render('list', [
            'models' => $blogsArray,
            'pages' => $pages
        ]);
    }

    public function actionDetail($id)
    {
        $blogService = new BlogService();
        $blog = $blogService->getDetail($id);

        $replyService = new ReplyService();
        $replies = $replyService->getList($id);

        return $this->render('detail', [
            'blog' => $blog,
            'replies' => $replies
        ]);
    }
    
    public function actionSearch(){
	    if (Yii::$app->request->isPost){
		    $keyword = Yii::$app->getRequest()->post('keyword');

            $result = BlogES::find()->query(["match" => ["content" => $keyword]])
                ->orderBy(['createDate' => ['order' => 'desc']])
                ->highlight([
                    'pre_tags' => ["<font color='#ff0000'>"],
                    'post_tags' => ["</font>"],
                    'fields' => ['content'=>new \stdClass()]
                ])
                ->all();

            $blogs = array();
            foreach($result as $key => $value){
                $blog = array(
                    'id' => $value['id'],
                    'title' => $value['title'],
                    'content' => $value->highlight['content'][0],
                    'create_date' => $value['createDate']
                );
                $blogs[] = $blog;
            }

	    }

        $pages = new Pagination(['totalCount' => count($result)]);

        return $this->render('list', [
            'models' => $blogs,
            'pages' => $pages
        ]);
    }
    

}
