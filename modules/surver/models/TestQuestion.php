<?php

namespace app\modules\surver\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;


/**
 * This is the model class for table "test_question".
 *
 * @property int $id
 * @property string $name Название
 * @property string $description Тело вопроса
 * @property int $created_at Время создания
 * @property int $created_by Создано
 * @property int $updated_at Последнее изменение
 * @property int $updated_by Изменено
 * @property int $test_id Тест
 * @property int $type
 * @property int $points
 *
 * @property $creator
 * @see TestQuestion::getCreator()
 *
 * @property $updater
 * @see TestQuestion::getUpdater()
 *
 * @property $test
 * @see TestQuestion::getTest()
 *
 * @property $answers
 * @see TestQuestion::getAnswers()
 *
 * @property $types
 * @see TestQuestion::getTypes()
 */
class TestQuestion extends ActiveRecord
{
    const TYPE_CHECKBOX = 0;
    const TYPE_RADIOLIST = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'type', 'points'], 'required'],
            [['description'], 'string'],
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'test_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['test_id'], 'safe']
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
            'description' => 'Тело вопроса',
            'created_at' => 'Время создания',
            'creator' => 'Кем создано',
            'updated_at' => 'Последнее изменение',
            'updater' => 'Кем изменено',
            'test' => 'Тест',
            'test.name' => 'Тест',
            'test_id' => 'Тест',
            'type' => 'Тип вопроса',
            'typeName' => 'Тип вопроса',
            'points' => 'Баллы'
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
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::class, ['id' => 'test_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(TestAnswer::class, ['test_question_id' => 'id']);
    }

    /**
     * Типы вопросов
     * @return array
     */
    public function getTypes()
    {
        return [
            self::TYPE_CHECKBOX => 'Множественный выбор',
            self::TYPE_RADIOLIST => 'Одиночный выбор'
        ];
    }

    /**
     * Название типа вопроса
     * @return mixed
     */
    public function getTypeName()
    {
        $types = $this->types;
        return $types[$this->type];
    }
}
