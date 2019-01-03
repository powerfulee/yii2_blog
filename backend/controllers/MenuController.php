<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

use app\models\Menu;
use yii\data\Pagination;

use yii\helpers\Html;
use backend\assets\AppAsset;  

use common\components\zController;
use yii\filters\ContentNegotiator;

use yii\helpers\Json;
use app\utils\MenuUtil;
use app\utils\Category;

use yii\helpers\ArrayHelper;
use yii\web\Response;

class MenuController extends zController
{
	public $enableCsrfValidation = false;
	
	public function actionList(){
		return $this->render('list');
	}
	
	public function actiongetMenuList(){
		//combotree的需要，将menu_name取别名为text
		$menus = Menu::find()->select(["id","parent_id","text"=>"menu_name","link_url"])->asArray()->all();
		
 		Yii::$app->response->format=Response::FORMAT_JSON;
		return Category::unlimitedForLayer($menus);
	}
	
	public function actiongetMenuTree(){
		
		$menus = Menu::find()->all();
		
		$menusArray = array();
		foreach ($menus as $key => $one) {
			$menuArray = array(
				'id' => $one['id'],
				'_parentId' => $one['parent_id'],
				'menu_name' => $one['menu_name'],
				'link_url' => $one['link_url']
			);
			$menusArray[] = $menuArray;
		}
		
		//$menus = Menu::find()->select([id,"_parentId"=>"parent_id",menu_name,link_url])->asArray()->all();
			
		$result = array(
			'total' => count($menusArray),
			"rows" => $menusArray
		);
		
		Yii::$app->response->format=Response::FORMAT_JSON;
		return $result;
	}
	
	public function actionSave(){
		if (Yii::$app->request->isAjax) {
			$request = Yii::$app->request;
			
			$id = $request->post('id');
			$menu_name = $request->post('menu_name');
			$link_url = $request->post('link_url');
			$parent_id = $request->post('parent_id');
				
			if (empty($id)){
				$menu = new Menu;
			}else{
				$menu = Menu::findOne($id);
			}
			$menu->menu_name = $menu_name;
			$menu->link_url = $link_url;
			$menu->parent_id = $parent_id;
			
			$menu->save();
			
			$result = array(
			    'status' => 0,
			    'message'  => 'success',
		    );
	
		    Yii::$app->response->format=Response::FORMAT_JSON;
			return $result;
		}
	}
	
	public function actionDelete(){
		if (Yii::$app->request->isAjax) {
			$request = Yii::$app->request;
			
			$id = $request->post('id');
			
			Menu::findOne($id)->delete();
			
			$result = array(
			    'status' => 0,
			    'message'  => 'success',
		    );
	
		    Yii::$app->response->format=Response::FORMAT_JSON;
			return $result;	
		}
	}
	
	public function actiongetLeftMenu(){
		$menus = Menu::find()->select(['id','_parentId'=>'parent_id','menu_name','link_url'])->asArray()->all();
		
		$result = array(
			'total' => count($menus),
			"rows" => $menus
		);
		
		Yii::$app->response->format=Response::FORMAT_JSON;
		return $result;	
	}
}