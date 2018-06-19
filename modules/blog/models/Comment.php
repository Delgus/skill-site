<?php

namespace app\modules\blog\models;

use app\modules\user\models\User;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $text
 * @property int $created_at
 * @property int $created_by
 * @property int $post_id
 */
class Comment extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'post_id'], 'required'],
            [['id', 'created_at', 'created_by', 'post_id'], 'integer'],
            [['text'], 'string'],
            [['created_at', 'created_by'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Текст',
            'created_at' => 'Создано',
            'created_by' => 'Кем создано',
            'post_id' => 'Пост',
        ];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUsername($id)
    {
        /** @var  $userClass User */
        $userClass = Yii::$app->user->identityClass;
        $user = $userClass::findOne($id);
        return $user->username;
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($insert) {
            $this->created_at = time();
            $this->created_by = Yii::$app->user->id;
        }

        return true;
    }
}
