<?php

namespace app\modules\surver\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\modules\surver\components\Model;

/**
 * This is the model class for table "test".
 *
 * @property int $id
 * @property string $name Название
 * @property string $description Краткое описание
 * @property int $created_at Время создания
 * @property int $created_by Создано
 * @property int $updated_at Последнее изменение
 * @property int $updated_by Изменено
 * @property int $status Статус
 * @property int $category_id Категория
 *
 * @property $questions
 * @see Test::getQuestions()
 *
 * @property $creator
 * @see Test::getCreator()
 *
 * @property $updater
 * @see Test::getUpdater()
 *
 * @property $statusName
 * @see Test::getStatusName()
 *
 * @property $statusList
 * @see Test::getStatusList()
 *
 * @property $category
 * @see Test::getCategory()
 *
 */
class Test extends ActiveRecord
{
    const STATUS_NOT_ACTIVE = 0;
    const STATUS_ACTIVE = 1;
    private $_questions;
    private $_delete_questions;
    private $_answers;
    private $_delete_answers;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'status', 'category_id'], 'required'],
            [['description'], 'string'],
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'category_id'], 'integer'],
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
            'description' => 'Краткое описание',
            'created_at' => 'Время создания',
            'creator' => 'Кем создано',
            'updated_at' => 'Последнее изменение',
            'updater' => 'Кем изменено',
            'status' => 'Статус',
            'statusName' => 'Статус теста',
            'category' => 'Категория',
            'category_id' => 'Категория',
            'category.name' => 'Категория'
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
    public function getQuestions()
    {
        return $this->hasMany(TestQuestion::class, ['test_id' => 'id']);
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
            self::STATUS_NOT_ACTIVE => 'Не активен',
            self::STATUS_ACTIVE => 'Опубликован'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(TestCategory::class, ['id' => 'category_id']);
    }

    /**
     * @return bool
     */
    public function chainDelete(){
        if (!empty($this->_delete_answers)) {
            foreach ($this->_delete_answers as $arrayId) {
                if (!empty($arrayId)) {
                    if(TestAnswer::deleteAll(['id' => $arrayId])){
                    return false;
                    }
                }
            }
        }
        if (!empty($this->_delete_questions)) {
            if(TestQuestion::deleteAll(['id' => $this->_delete_questions])){
                return false;
            }
        }
        return true;
    }

    /**
     * @param bool $runValidation
     * @return bool
     */
    public function chainSave($runValidation = false)
    {
        if(!$this->save($runValidation)){
            return false;
        }
        $answers = $this->_answers;
        foreach ($this->_questions as $i => $question) {
            $question->test_id = $this->id;
            if(!$question->save($runValidation)){
                return false;
            }
            foreach ($answers[$i] as $answer) {
                $answer->test_question_id = $question->id;
                if(!$answer->save($runValidation)){
                    return false;
                };
            }
        }
        return true;
    }

    /**
     * @param $post
     * @return bool
     */
    public function chainLoad($post)
    {
        $loadMain = $this->load($post);
     
        if(isset($post['TestQuestion'])){
            $questions = $this->questions ?:[new TestQuestion];
            $deleteIDs = [];
            $loadQuestions = Model::multiLoad($questions,$deleteIDs, $post['TestQuestion']);
            $this->_questions = $questions;
            $this->_delete_questions = $deleteIDs;
        }


        if(isset($post['TestAnswer'])){
            $answers = [];
            $deleteIDs = [];
            $loadAnswers = true;
            foreach ($this->_questions as $i => $question) {
            $delIDforOne = [];
            $answers[$i] = $question->answers ?:[new TestAnswer];
            $loadAnswers = $loadAnswers && Model::multiLoad($answers[$i],$delIDforOne,$post['TestAnswer'][$i]);
            $deleteIDs[$i] = $delIDforOne;
            }
            $this->_answers = $answers;
            $this->_delete_answers = $deleteIDs;
        }
        return $loadMain && $loadQuestions && $loadAnswers;
    }

    /**
     * @return bool
     */
    public function chainValidate()
    {
        $validMain = $this->validate();
        $validQuestions = Model::validateMultiple($this->_questions);
        $validAnswers = true;
        foreach ($this->_answers as $answers) {
            $validAnswers = $validAnswers && Model::validateMultiple($answers);
        }
        return $validMain && $validQuestions && $validAnswers;
    }
}
