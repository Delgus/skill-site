<?php

namespace app\modules\blog\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $category_id
 * @property int $status
 *
 *
 * @property $creator
 * @see Post::getCreator()
 *
 * @property $updater
 * @see Post::getUpdater()
 *
 * @property $statusName
 * @see Post::getStatusName()
 *
 * @property $statusList
 * @see Post::getStatusList()
 *
 * @property $category
 * @see Post::getCategory()
 */
class Post extends ActiveRecord
{
    const STATUS_NOT_ACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return 'post';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => TimestampBehavior::class,
            'author' => BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'text', 'category_id'], 'required'],
            [['title', 'description', 'text'], 'string'],
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'category_id'], 'integer'],
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'text' => 'Текст',
            'created_at' => 'Время создания',
            'created_by' => 'Кем создана',
            'updated_at' => 'Последнее изменение',
            'updated_by' => 'Кем изменена',
            'category_id' => 'Категория',
            'category' => 'Категория',
            'status' => 'Статус',
            'creator' => 'Кем создана',
            'updater' => 'Кем изменена',
            'statusName' => 'Статус',
            'category.name' => 'Категория'
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'updated_by']);
    }

    /**
     * @return mixed
     */
    public function getStatusName()
    {
        $list = $this->statusList;
        return $list[$this->status];
    }

    /**
     * @return array
     */
    public function getStatusList()
    {
        return [
            self::STATUS_NOT_ACTIVE => 'Не активна',
            self::STATUS_ACTIVE => 'Опубликована'
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(PostCategory::class, ['id' => 'category_id']);
    }
}
