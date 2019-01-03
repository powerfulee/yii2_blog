<?php
/**
 * Created by PhpStorm.
 * User: PeterLee
 * Date: 2/2/2018
 * Time: 17:24
 */
namespace app\utils;
use Yii;
use app\models\Menu;
use app\models\User;

Class MenuUtil{
	public static function getMenu($uid){
		$user = User::findOne($uid);
		$role_id = $user['role_id'];
		
		$connection = Yii::$app->getDb();
		$sql = 'select * from menu';
		$command = $connection->createCommand("select m.id,m.parent_id,m.menu_name as 'label',m.link_url as 'url' from role_right as r left join menu as m on r.menu_id=m.id where r.role_id=$role_id");
		$menus = $command->queryAll();
		
		$menuArray = Category::unlimitedForLayer2($menus);
		
		return $menuArray;
	}
}