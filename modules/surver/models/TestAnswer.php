<?php

namespace app\modules\surver\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "test_answer".
 *
 * @property int $id
 * @property string $name Ответ
 * @property int $test_question_id Тест
 * @property int $result Результат
 *
 * @property $question
 * @see TestAnswer::getQuestion()
 */
class TestAnswer extends ActiveRecord
{
	

     
    public static function tableName()
    {
        return 'test_answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'result'], 'required'],
            [['test_question_id', 'result'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['test_question_id'],'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Ответ',
            'test_question_id' => 'Вопрос',
            'result' => 'Результат'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(TestQuestion::class, ['id' => 'test_question_id']);
    }

    
}
