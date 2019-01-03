<?php
namespace common\models;

use Yii;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string $content
 * @property int $comment_total
 * @property string $ip_address
 * @property int $status
 * @property string $create_date
 */
class Blog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'comment_total', 'status', 'create_date'], 'integer'],
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 50],
            [['ip_address'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'title' => 'Title',
            'content' => 'Content',
            'comment_total' => 'Comment Total',
            'ip_address' => 'Ip Address',
            'status' => 'Status',
            'create_date' => 'Create Date',
        ];
    }
    
    public function getCategory()
    {
    	return $this->hasOne(Category::className(),['id' => 'category_id']);
    }
}
