<?php

namespace app\modules\surver\models;

use app\modules\user\models\User;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%test_result}}".
 *
 * @property int $id
 * @property int $user_id Пользователь
 * @property int $test_id Тест
 * @property string $test_result Результат
 * @property int $time_start Старт
 * @property int $time_finish Финиш
 * @property string $answers
 */
class TestResult extends ActiveRecord
{
    /** Название теста
     * @var $test_name
     */
    public $test_name;
    /** Вопросы
     * @var $test_name
     */
    public $questions;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%test_result}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'test_id', 'answers'], 'required'],
            [['test_result'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'test_id' => 'Тест',
            'test_result' => 'Результат',
            'answers' => 'Ответы'
        ];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUsername($id)
    {
        /** @var User $userClass */
        $userClass = Yii::$app->user->identityClass;
        $user = $userClass::findOne($id);
        return $user->username;
    }

    /**
     * @param $id
     * @return $this
     */
    public function fill($id)
    {
        $test = Test::findOne($id);
        $this->user_id = Yii::$app->user->id;
        $this->test_id = $id;
        $this->test_name = $test->name;
        $this->questions = [];
        foreach ($test->questions as $i => $question) {
            $questionResult = $question->description;
            $answersForResult = [];
            foreach ($question->answers as $answer) {
                $answersForResult[$answer->id] = $answer->name;
            }
            $this->questions[] = [
                'question' => $questionResult,
                'type' => $question->type,
                'points' => $question->points,
                'answers' => $answersForResult
            ];
        }
        return $this;
    }

    /**
     * @param $params
     * @return array
     */
    public static function top10($params)
    {
        if ($params["TestSearch"]['category']) {
            $category_id = TestCategory::find()
                ->select('id')
                ->where(['name' => $params["TestSearch"]['category']])
                ->scalar();
            $tests = Test::find()
                ->select('id')
                ->where(['category_id' => $category_id])
                ->asArray()->all();
            $test_ids = ArrayHelper::getColumn($tests, 'id');
            return self::top10query()->where(['in', 'test_id', $test_ids])->all();
        }
        return self::top10query()->all();
    }

    /**
     * @return Query
     */
    public static function top10query()
    {
        return self::find()
            ->select(['user_id', 'SUM(test_result) as test_result'])
            ->groupBy('user_id')
            ->limit(10);
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
        $saveData = ['test_name' => $this->test_name, 'questions' => []];
        $points = 0;
        foreach ($this->questions as $i => $one) {

            $saveData['questions'][$i]['name'] = $one['question'];
            $mark = $this->answers[$i] ?? [];
            $tempId = [];
            if (is_array($mark)) {
                foreach ($mark as $oneMark) {
                    $tempId[] = $oneMark;
                }
            } else {
                $tempId[] = $mark;
            }
            //формирование ответов для сохранения
            $answers = $this->questions[$i]['answers'];
            $tempPoints = 0;
            $flag = false;
            foreach ($answers as $id => $answer) {
                $checkbox = ($one['type'] == TestQuestion::TYPE_CHECKBOX);

                $saveData['questions'][$i]['answers'][$id]['text'] = $answer;
                $answer = TestAnswer::findOne($id);
                if (array_search($id, $tempId) === false) {
                    $saveData['questions'][$i]['answers'][$id]['mark'] = false;
                    if ($checkbox && $answer->result) {
                        $flag = true;
                    }
                } else {
                    $saveData['questions'][$i]['answers'][$id]['mark'] = true;
                    if ($answer->result) {
                        $tempPoints = $one['points'];
                    };
                    if ($checkbox && !$answer->result) {
                        $flag = true;
                    }
                }

                $saveData['questions'][$i]['answers'][$id]['result'] = $answer->result;
            }
            if (!$flag) {
                $points += $tempPoints;
            }

        }
        $this->test_result = $points;
        $this->answers = json_encode($saveData);
        return true;

    }


}
