<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use Faker;
use app\modules\surver\models\TestCategory;
use app\modules\surver\models\Test;
use app\modules\surver\models\TestAnswer;
use app\modules\surver\models\TestQuestion;
use Stichoza\GoogleTranslate\TranslateClient;

/**
 * Генератор тестов
 * Class HelloController
 * @package app\commands
 */
class GenerateController extends Controller
{
    /**
     * Создание таблицы с информацией о странах
     * @return int
     * @throws \yii\db\Exception
     */
    public function actionCountriesCreate()
    {
        \Yii::$app->db->createCommand("create table countries (
                                            id int (10) AUTO_INCREMENT,
                                            obj text NOT NULL,PRIMARY KEY (id)); ")->execute();
        $json = file_get_contents('https://restcountries.eu/rest/v2/all');
        $data = json_decode($json);
        foreach ($data as $country) {
            \Yii::$app->db->createCommand()->insert('countries', ['obj' => json_encode($country)])->execute();
        }


        return ExitCode::OK;
    }

    /**
     * Автозаполнение тестами - города и флаги
     * @return int
     * @throws \yii\db\Exception
     */
    public function actionCountriesFlag()
    {

        $data = \Yii::$app->db->createCommand("SELECT * FROM countries;")->queryAll();
        $category = TestCategory::findOne(['name' => 'Страны']);

        $tr = new TranslateClient('en', 'ru');
        $names = [];
        foreach ($data as $one) {
            $object = json_decode($one['obj']);
            $names [$tr->translate($object->name)] = $object->flag;
        }


        $i = 0;
        $number = 0;

        foreach ($names as $name => $flag) {

            if ($i == 0 || $i % 10 == 0) {
                $test = new Test();
                $test->name = "Страны и флаги " . ++$number;
                $test->description = "Страны и флаги";
                $test->created_by = 1;
                $test->updated_by = 1;
                $test->status = 1;
                $test->category_id = $category->id;
                $test->detachBehavior('author');
                $test->save();
            }
            $i++;
            $test_question = new TestQuestion();
            $test_question->name = 'Флаг - ' . $name;
            $test_question->description = '<p>Флаг какой страны изображен на картинке?</p><p><img src ="' . $flag . '" width="300px"></p>';
            $test_question->created_by = 1;
            $test_question->updated_by = 1;
            $test_question->test_id = $test->id;
            $test_question->detachBehavior('author');
            $test_question->points = 1;
            $test_question->type = 1;
            $test_question->save();

            $right_answer = new TestAnswer();
            $right_answer->name = $name;
            $right_answer->test_question_id = $test_question->id;
            $right_answer->result = 1;
            $right_answer->save();

            $arr = $names;
            unset($arr[$name]);
            $rand_answer_keys = array_rand($arr, 3);

            foreach ($rand_answer_keys as $one) {
                $right_answer = new TestAnswer();
                $right_answer->name = $one;
                $right_answer->test_question_id = $test_question->id;
                $right_answer->result = 0;
                $right_answer->save();
            }


        }


        return ExitCode::OK;
    }

    /**
     * Автозаполнение тестами - города и столицы
     * @throws \yii\db\Exception
     */
    public function actionCountriesCapital()
    {
        $data = \Yii::$app->db->createCommand("SELECT * FROM countries;")->queryAll();
        $category = TestCategory::findOne(['name' => 'Страны']);

        $tr = new TranslateClient('en', 'ru');
        $names = [];
        foreach ($data as $one) {
            $object = json_decode($one['obj']);
            $names [$tr->translate($object->name)] = $tr->translate($object->capital);
        }


        $i = 0;
        $number = 0;
        foreach ($names as $name => $capital) {

            if ($i == 0 || $i % 10 == 0) {
                $test = new Test();
                $test->name = "Страны и столицы " . ++$number;
                $test->description = "Страны и столицы";
                $test->created_by = 1;
                $test->updated_by = 1;
                $test->status = 1;
                $test->category_id = $category->id;
                $test->detachBehavior('author');
                $test->save();
            }
            $i++;
            $test_question = new TestQuestion();
            $test_question->name = 'Столица - ' . $name;
            $test_question->description = "<p>Столицей какой страны является $capital ?</p>";
            $test_question->created_by = 1;
            $test_question->updated_by = 1;
            $test_question->test_id = $test->id;
            $test_question->detachBehavior('author');
            $test_question->points = 1;
            $test_question->type = 1;
            $test_question->save();

            $right_answer = new TestAnswer();
            $right_answer->name = $name;
            $right_answer->test_question_id = $test_question->id;
            $right_answer->result = 1;
            $right_answer->save();

            $arr = $names;
            unset($arr[$name]);
            $rand_answer_keys = array_rand($arr, 3);

            foreach ($rand_answer_keys as $one) {
                $right_answer = new TestAnswer();
                $right_answer->name = $one;
                $right_answer->test_question_id = $test_question->id;
                $right_answer->result = 0;
                $right_answer->save();
            }
        }
        return ExitCode::OK;
    }

    /**
     * Удаление таблицы с информацией о странах
     * @return int
     * @throws \yii\db\Exception
     */
    public function actionCountriesDelete()
    {
        \Yii::$app->db->createCommand("drop table countries ")->execute();
        return ExitCode::OK;
    }

    /**
     * Fake tests
     */
    public function actionIndex()
    {
        $faker = Faker\Factory::create('ru_RU');
        for ($ic = 0; $ic < 5; $ic++) {

            $category = new TestCategory();
            $category->name = $faker->company;
            $category->description = $faker->realText();
            $category->created_by = '1';
            $category->updated_by = '1';
            $category->status = $faker->numberBetween(0, 1);
            $category->detachBehavior('author');
            $category->save();

            for ($it = 0; $it < 15; $it++) {

                $test = new Test();
                $test->name = $faker->company;
                $test->description = $faker->realText();
                $test->created_by = '1';
                $test->updated_by = '1';
                $test->status = $faker->numberBetween(0, 1);
                $test->category_id = $category->id;
                $test->detachBehavior('author');
                $test->save();

                for ($iq = 0; $iq < 15; $iq++) {
                    $test_question = new TestQuestion();
                    $test_question->name = $faker->company;
                    $test_question->description = $faker->realText();
                    $test_question->created_by = '1';
                    $test_question->updated_by = '1';
                    $test_question->test_id = $test->id;
                    $test_question->detachBehavior('author');
                    $test_question->points = 1;
                    $test_question->type = $faker->numberBetween(0, 1);
                    $test_question->save();

                    for ($ia = 0; $ia < 4; $ia++) {
                        $test_answer = new TestAnswer();
                        $test_answer->name = $faker->company;
                        $test_answer->test_question_id = $test_question->id;
                        $test_answer->result = $faker->numberBetween(0, 1);
                        $test_answer->save();
                    }
                }
            }
        }
        return ExitCode::OK;
    }

}
