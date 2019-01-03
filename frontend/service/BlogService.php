<?php
/**
 * Created by PhpStorm.
 * User: kf
 * Date: 2018/2/3
 * Time: 11:07
 */
namespace app\service;

use Yii;
use common\models\Blog;
use app\utils\StringUtil;
use app\config\config;
use yii\data\Pagination;

Class BlogService
{
	public function getList($page){
		$limit = config::$limit;

		$redis = Yii::$app->redis;

		if ($redis->exists('skycentre:blog:list:ids') && $redis->exists('skycentre:blog:list')){
			$rows = $redis->zrevrange('skycentre:blog:list:ids',($page - 1) * $limit,$page * $limit - 1);
			$total = $redis->zcard('skycentre:blog:list:ids');

			array_unshift($rows,'skycentre:blog:list');
			$records = $redis->executeCommand('hmGet',$rows);

			$blogsArray = array();
			foreach($records as $key => $item){
				$json = json_decode($item,JSON_FORCE_OBJECT);

				$content = StringUtil::getFirstPicByContent($json['content']);

				$blogArray = array(
					'id' => $json['id'],
					'title' => $json['title'],
					'content' => $content,
					'create_date' => $json['createDate']
				);
				$blogsArray[] = $blogArray;
			}
		}else{
			$query = Blog::find()->where(['status' => 0])->orderBy('create_date desc');
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
			$total = $countQuery->count();
		}
		$result = array(
			"blogs" => $blogsArray,
			'total' => $total
		);

		return $result;
	}

    public function getDetail($id){
        $source = Yii::$app->redis->hget('skycentre:blog:list',$id);
        if (!empty($source)) {
            $json = json_decode($source, JSON_FORCE_OBJECT);

            $blog = array(
                'id' => $json['id'],
                'category_id' => $json['categoryId'],
                'category_name' => $json['categoryName'],
                'title' => $json['title'],
                'content' => $json['content'],
                'create_date' => $json['createDate']
            );
        }else{
            $b = Blog::find()->where(['id' => $id])->one();
            $category = $b->category;

            $categoryArray = array("category_name" => $category['category_name']);
            $blog = array_merge( $b->attributes,$categoryArray );
        }
        return $blog;
    }
}