<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reply".
 *
 * @property integer $id
 * @property integer $blog_id
 * @property string $author
 * @property string $content
 * @property string $ip_address
 * @property string $create_date
 */
class Reply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_id', 'author', 'content', 'ip_address'], 'required'],
            [['blog_id', 'create_date'], 'integer'],
            [['content'], 'string'],
            [['author'], 'string', 'max' => 30],
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
            'blog_id' => 'Blog ID',
            'author' => 'Author',
            'content' => 'Content',
            'ip_address' => 'Ip Address',
            'create_date' => 'Create Date',
        ];
    }
}
