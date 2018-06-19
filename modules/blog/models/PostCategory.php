<?php

namespace app\modules\blog\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "post_category".
 *
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property string $description
 *
 *
 * @property $creator
 * @see TestCategory::getCreator()
 *
 * @property $updater
 * @see TestCategory::getUpdater()
 *
 *
 * @property $list
 * @see PostCategory::getList()
 */
class PostCategory extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_category';
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
            [['name', 'description'], 'required'],
            [['id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
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
            'created_at' => 'Время создания',
            'created_by' => 'Кем создана',
            'updated_at' => 'Последнее изменение',
            'updated_by' => 'Кем изменена',
            'description' => 'Описание',
            'creator' => 'Кем создана',
            'updater' => 'Кем изменена',

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
     * @return array
     */
    public function getList()
    {
        return ArrayHelper::map(self::find()->all(), 'name', 'name');
    }
}
