<?php

namespace frontend\controllers;

use app\service\BlogService;
use app\service\ReplyService;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Blog;
use common\models\Category;
use common\models\Reply;
use yii\data\Pagination;
use yii\helpers\Url;
use app\utils\StringUtil;
use yii\web\Response;

class ReplyController extends Controller
{
	public $enableCsrfValidation = false;

    public function actionInsert()
    {
        $status = 1;
	    $message = "false";

	    if (Yii::$app->request->isAjax) {
		    $json = Yii::$app->request->post();

		    $replyService = new ReplyService();
		    $lastInsertId = $replyService->insert($json);
		    if (!empty($lastInsertId)){
			    $status = 0;
			    $message = "successed";
		    }
	    }

	    $result = array(
		    'status' => $status,
		    'message'  => $message,
	    );

	    Yii::$app->response->format=Response::FORMAT_JSON;
		return $result;
    }

}
