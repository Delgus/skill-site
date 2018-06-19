<?php

namespace app\modules\surver\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "test_category".
 *
 * @property int $id
 * @property string $name Название
 * @property string $description Краткое описание
 * @property int $created_at Время создания
 * @property int $created_by Создано
 * @property int $updated_at Последнее изменение
 * @property int $updated_by Изменено
 * @property int $status Статус
 *
 * @property $creator
 * @see TestCategory::getCreator()
 *
 * @property $updater
 * @see TestCategory::getUpdater()
 *
 * @property $statusName
 * @see TestCategory::getStatusName()
 *
 * @property $statusList
 * @see TestCategory::getStatusList()
 *
 * @property $list
 * @see TestCategory::getList()
 */
class TestCategory extends ActiveRecord
{
    const STATUS_NOT_ACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%test_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'status'], 'required'],
            [['description'], 'string'],
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Краткое описание',
            'created_at' => 'Время создания',
            'creator' => 'Кем создана',
            'updated_at' => 'Последнее изменение',
            'updater' => 'Кем изменена',
            'status' => 'Статус',
            'statusName' => 'Статус категории',
        ];
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
     * @return array
     */
    public function getList()
    {
        return ArrayHelper::map(self::find()->all(), 'name', 'name');
    }
}
