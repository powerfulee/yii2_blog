<?php
/**
 * Created by PhpStorm.
 * User: PeterLee
 * Date: 1/23/2018
 * Time: 17:51
 */
namespace frontend\controllers;

use app\utils\StringUtil;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Blog;
use yii\data\Pagination;
use yii\helpers\Url;

class CategoryController extends Controller
{
	public function actionIndex()
	{
		return $this->render('index');
	}

	public function actionList($id)
	{
		$query = Blog::find()->where(['status' => 0])->andWhere(['category_id' => $id])->orderBy('create_date desc');
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
		return $this->render('/blog/list',[
			'models' => $blogsArray,
			'pages' => $pages,
		]);
	}
}