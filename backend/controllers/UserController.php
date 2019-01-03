<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

use app\models\User;
use app\models\Role;
use yii\data\Pagination;

/**
 * Site controller
 */
class UserController extends Controller
{
	public function actionList(){
		$query = User::find()->joinWith('roles');
		$countQuery = clone $query;
		$pages = new Pagination(['totalCount' => $countQuery->count()]);
		$users = $query->offset($pages->offset)->limit($pages->limit)->all();
		
		return $this->render('list',[
            'models' => $users
        ]);
	}
	
	public function actionAdd($id = null){
		$roles = Role::find()->all();
		$user = new User;
		
		if (!empty($id)){
			$user = User::findOne($id);
		}
		return $this->render('add',[
			'roles' => $roles,
			'user' => $user
		]);
	}
	
	public function actionSave(){
		if (Yii::$app->request->isPost){
			$request = Yii::$app->request;
			
			$id = $request->post('id');
			$role_id = $request->post('role');
			$username = $request->post('username');
			$password = $request->post('password');
			$email = $request->post('email');
			
			if (empty($id)){
				$user = new User;
			}else{
				$user = User::findOne($id);	
			}
			$user->role_id = $role_id;
			$user->username = $username;
			//$user->password = $password;
			$user->password_hash = Yii::$app->security->generatePasswordHash($password);
			$user->auth_key = Yii::$app->security->generateRandomString();
			$user->email = $email;
			$user->status = 10;
			$user->created_at = time();
			$user->updated_at = time();
			
			$user->save();
			
			$this->redirect(['list']);
		}	
	}
	
	public function actionDelete($id){
		User::findOne($id)->delete();
		
		$this->redirect(['list']);
	}
	
	public function actionLogin($user){
		
	}
}