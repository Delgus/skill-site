<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 05.06.2018
 * Time: 11:58
 */

namespace app\modules\surver\widgets\top;


use app\modules\surver\models\TestResult;
use yii\base\Widget;

class TopWidget extends Widget
{
    public $test_id;

    public function run()
    {


        $results = TestResult::find()->where(['test_id' => $this->test_id])->orderBy(['test_result' => SORT_DESC])->all();

        return $this->render('top', compact('results'));
    }
}