<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

use app\models\Role;
use app\models\RoleRight;
use app\models\Menu;
use yii\data\Pagination;
use yii\web\Response;

use common\components\zController;

use app\utils\Category;
/**
 * Site controller
 */
class RoleController extends zController
{
	public $enableCsrfValidation = false;
	
	public function actionAdd(){
		$request = Yii::$app->request;
		$get = $request->get();
		$id = $request->get('id');
		
		$role = new Role;
		
		if (!empty($id)){
			$role = Role::findOne($id);
		}
				
		return $this->render('add',[
			'role' => $role
		]);
	}
	
	public function actionSave(){
		if (Yii::$app->request->isAjax) {
			//$session = \Yii::$app->session;
			//$uid = $session->get('uid');
			
			$request = Yii::$app->request;
			
			$role_id = $request->post('role_id');
			$role_name = $request->post('role_name');
			$role_right = $request->post('role_right');
			
			if (!empty($role_id)){
				//先删除旧有权限
				RoleRight::deleteAll(['role_id' => $role_id]);
				
				//重新写入权限
				foreach($role_right as $k => $v){
					$roleRight = new RoleRight;
					$roleRight->role_id = $role_id;
					$roleRight->menu_id = $v;
					
					$roleRight->save();
				}
			}else{
				//写入角色表
				$role = new Role;
				$role->name = $role_name;
				$role->create_dt = time();
				$role->save();
				
				$role_id = Yii::$app->db->getLastInsertedID();

				//写入权限表
				foreach($role_right as $k => $v){
					$roleRight = new RoleRight;
					$roleRight->role_id = $role_id;
					$roleRight->menu_id = $v;
					
					$roleRight->save();
				}
			}
			
			$result = array(
			    'status' => 0,
			    'message'  => 'success',
		    );
	
		    Yii::$app->response->format=Response::FORMAT_JSON;
			return $result;
		}
	}
	
	public function actiongetMenuTree($role_id=null){
		$request = Yii::$app->request;
		$get = $request->get();
		$role_id = $request->get('id');
		
		if (!empty($role_id)){
			$connection = Yii::$app->getDb();
			$sql = 'select * from menu';
			$command = $connection->createCommand("select a.id,a.parent_id,a.menu_name as 'text',IF(ISNULL(b.menu_id),null,'true') AS 'checked',a.link_url from menu as a left join role_right as b on a.id=b.menu_id and b.role_id=$role_id order by a.id asc");
			$menus = $command->queryAll();
		}else{
			$menus = Menu::find()->select(['id','parent_id',"text"=>"menu_name",'link_url'])->asArray()->all();	
		}
		
		$result = Category::unlimitedForLayer($menus);
		
		Yii::$app->response->format=Response::FORMAT_JSON;
		return $result;		
	}
	
	public function actionList(){
		$roles = Role::find()->all();
		
		return $this->render('list',[
            'models' => $roles
        ]);	
	}
	
	public function actionDelete($id){
		Role::findOne($id)->delete();
		
		$this->redirect(['list']);
	}
}