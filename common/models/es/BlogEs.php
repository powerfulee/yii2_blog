<?php
/**
 * Created by PhpStorm.
 * User: PeterLee
 * Date: 2/8/2018
 * Time: 10:29
 */
namespace common\models\es;

use Yii;
use yii\base\Model;

use yii\elasticsearch\ActiveRecord;

class BlogES extends ActiveRecord{
	public static function index(){
		return "blog_index";
	}

	public static function type(){
		return "blog_info";
	}

	public function attributes() {
    	return ['id', 'categoryId', 'categoryName', 'title', 'content', 'ipAddress', 'commentTotal', 'status', 'createDate'];
  	}
}
?>