<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

use app\models\User;
use app\models\Role;
use common\models\Category;
use common\models\Blog;
use yii\data\Pagination;
use common\models\es\BlogES;
use yii\elasticsearch\Query;

/**
 * Site controller
 */
class BlogController extends Controller
{
	public function actionList(){
		$this->layout='main'; 
		$request = Yii::$app->request;
		$page = (!empty($request->get('page'))) ? $request->get('page') : 1;
		
		$query = Blog::find()->joinWith('category')->orderBy('create_date desc');
		$countQuery = clone $query;
		$pages = new Pagination(['totalCount' => $countQuery->count()]);
		$blogs = $query->offset($pages->offset)->limit($pages->limit)->all();
		 
		return $this->render('list',[
            'models' => $blogs,
            'pages' => $pages
        ]);
	}
	
	public function actionAdd(){
		$request = Yii::$app->request;
		$get = $request->get();
		$id = $request->get('id');
		
		$categories = Category::find()->all();
		$blog = new Blog;
		
		if (!empty($id)){
			$blog = Blog::findOne($id);
		}
		
		return $this->render('add',[
			'blog' => $blog,
			'categories' => $categories
		]);
	}
	
	public function actionSave(){
		if (Yii::$app->request->isPost){
			$request = Yii::$app->request;
			
			$id = $request->post('id');
			
			$category_id = $request->post('category_id');
			$title = $request->post('title');
			$status = $request->post('status');
			$content = $request->post('content');
			
			if (empty($id)){
				$blog = new Blog;
			}else{
				$blog = Blog::findOne($id);	
			}
			
			$blog->category_id = $category_id;
			$blog->title = $title;
			$blog->content = $content;
			$blog->status = $status;
			$blog->comment_total = 0;
			$blog->ip_address = Yii::$app->getRequest()->getUserIP();
			$blog->create_date = time()*1000;
			$blog->save();
			
			$newestId = $blog->attributes['id'];
			
			$b = array(
				'id' => $newestId,
				'categoryId' => $category_id,
				'title' => $title,
				'content' => $content,
				'ipAddress' => Yii::$app->getRequest()->getUserIP(),
				'createDate' => time()*1000
			);
			
			$category = Category::findOne($category_id);
			
			Yii::$app->redis->hmset('skycentre:blog:list', $newestId, json_encode($b,JSON_FORCE_OBJECT));
			Yii::$app->redis->zadd('skycentre:blog:list:ids',time()*1000,$newestId);
			Yii::$app->redis->zadd('skycentre:blog:category:' . $category->category_name, $blog->create_date, $newestId);
			
			$blogEs = new BlogEs();
			$blogEs->setPrimaryKey($newestId);
			$blogEs->id = $newestId;
			$blogEs->categoryId = $category_id;
			$blogEs->categoryName = $category->category_name;
			$blogEs->title = $title;
			$blogEs->content = $content;
			$blogEs->ipAddress = Yii::$app->getRequest()->getUserIP();
			$blogEs->commentTotal = 1;
			$blogEs->status = 0;
			$blogEs->createDate = $blog->create_date;
			$blogEs->save();
			
			$this->redirect(['list']);
		}
	}
	
	public function actionDelete($id){
		$blog = Blog::findOne($id);
		$category = Category::findOne($blog->category_id);
		
		Blog::findOne($id)->delete();
		
		Yii::$app->redis->hdel('skycentre:blog:list',$id);
		Yii::$app->redis->zrem('skycentre:blog:list:ids',$id);
		Yii::$app->redis->zrem('skycentre:blog:category:' . $category->category_name,$id);
		
		$blogEs = BlogEs::get($id);
		$blogEs->delete();
		
		$this->redirect(['list']);
	}
}