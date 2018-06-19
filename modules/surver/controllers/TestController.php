<?php

namespace app\modules\surver\controllers;

use Yii;
use app\modules\surver\models\Test;
use app\modules\surver\models\TestQuestion;
use app\modules\surver\models\TestAnswer;
use app\modules\surver\models\search\TestSearch;
use yii\helpers\ArrayHelper;
use app\modules\surver\components\Model;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * TestController implements the CRUD actions for Test model.
 * Class TestController
 * @package app\modules\surver\controllers
 */
class TestController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Test models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', compact('searchModel', 'dataProvider'));
    }

    /**
     * Displays a single Test model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */

    public function actionCreate()
    {
        $post = Yii::$app->request->post();
        $test = new Test;
        $questions = [new TestQuestion];
        $answers = [[new TestAnswer]];
        if ($test->chainLoad($post) && $test->chainValidate()) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                        $flag = false;
                        if($test->chainSave()){
                            $flag = true;
                        };

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $test->id]);
                    } else {

                        $transaction->rollBack();
                    }

                } catch (Exception $e) {

                    $transaction->rollBack();

                }

        }

        return $this->render('create', [
            'test' => $test,
            'questions' => (empty($questions)) ? [new TestQuestion] : $questions,
            'answers' => (empty($answers)) ? [[new TestAnswer]] : $answers,
        ]);

    }

 /**

     * Updates an existing Person model.

     * If update is successful, the browser will be redirected to the 'view' page.

     * @param integer $id

     * @return mixed

     */

    public function actionUpdate($id)

    {
        $post = Yii::$app->request->post();
        $test = $this->findModel($id);
        $questions = $test->questions;

        $answers = [];

        if (!empty($questions)) {
            foreach ($questions as $iq => $question) {
                $temp = $question->answers;
                $answers[$iq] = $temp;
            }
        }
        if ($test->chainLoad($post) && $test->chainValidate()) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                        $flag = false;
                        if($test->chainDelete()){
                            $flag = true;
                        }
                        if($test->chainSave()){
                            $flag = true;
                        };

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $test->id]);
                    } else {

                        $transaction->rollBack();
                    }

                } catch (Exception $e) {

                    $transaction->rollBack();

                }

        }

        


        return $this->render('update', [

            'test' => $test,

            'questions' => (empty($questions)) ? [new TestQuestion] : $questions,

            'answers' => (empty($answers)) ? [[new TestAnswer]] : $answers

        ]);

    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Test model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Test the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Test::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
