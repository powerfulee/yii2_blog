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
use yii\data\Pagination;

/**
 * Site controller
 */
class CategoryController extends Controller
{
	public function actionList(){
		$categories = Category::find()->all();
		
		return $this->render('list',[
            'models' => $categories
        ]);
	}
	
	public function actionAdd(){
		$request = Yii::$app->request;
		$get = $request->get();
		$id = $request->get('id');
		
		$category = new Category;
		
		if (!empty($id)){
			$category = Category::findOne($id);
		}
				
		return $this->render('add',[
			'category' => $category
		]);
	}
	
	public function actionSave(){
		if (Yii::$app->request->isPost){
			$request = Yii::$app->request;
			
			$id = $request->post('id');
			$category_name = $request->post('category_name');
			$status = $request->post('status');
			
			if (empty($id)){
				$category = new Category;
			}else{
				$category = Category::findOne($id);	
			}
			
			$category->category_name = $category_name;
			$category->status = $status;
			$category->create_date = time();
			$category->save();
			
			$this->redirect(['list']);
		}
	}
	
	public function actionDelete($id){
		Category::findOne($id)->delete();
		
		$this->redirect(['list']);	
	}
}