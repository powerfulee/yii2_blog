<?php
/**
 * Created by PhpStorm.
 * User: kf
 * Date: 2018/2/3
 * Time: 11:34
 */

namespace app\service;

use Yii;
use app\models\Reply;

class ReplyService
{
    public function getList($blogId)
    {
        if (Yii::$app->redis->exists('skycentre:blog:reply:') . $blogId) {
            $keys = Yii::$app->redis->hkeys('skycentre:blog:reply:' . $blogId);
            $replies = array();
            foreach ($keys as $key => $item) {
                $source = Yii::$app->redis->hget('skycentre:blog:reply:' . $blogId, $item);
                $json = json_decode($source, JSON_FORCE_OBJECT);

                $reply = array(
                    'id' => $json['id'],
                    'blog_id' => $json['blogId'],
                    'author' => $json['author'],
                    'ip_address' => $json['ipAddress'],
                    'create_date' => $json['createDate'],
                    'content' => $json['content']
                );
                $replies[] = $reply;
            }
        } else {
            $replies = Reply::find()->where(['blog_id' => $blogId])->orderBy('create_date desc')->all();
        }

        return $replies;
    }

	public function insert($inReply){
		$reply = new Reply;
		$reply->blog_id = $inReply['blog_id'];
		$reply->author = $inReply['author'];
		$reply->content = $inReply['content'];
		$reply->ip_address = Yii::$app->getRequest()->getUserIP();
		//$reply->ip_address = CHttpRequest::getUserHostAddress();
		$reply->create_date = time()*1000;

		$reply->save();
		$lastInsertId = Yii::$app->db->getLastInsertID();

		$r = array(
			'id' => $reply['id'],
			'blogId' => $reply['blog_id'],
			'author' => $reply['author'],
			'content' => $reply['content'],
			'ipAddress' => $reply['ip_address'],
			'createDate' => $reply['create_date']
		);

		Yii::$app->redis->hmset('skycentre:blog:reply:' . $inReply['blog_id'], $lastInsertId, json_encode($r,JSON_FORCE_OBJECT));

		return $lastInsertId;
	}
}