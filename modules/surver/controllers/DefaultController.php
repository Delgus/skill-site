<?php

namespace app\modules\surver\controllers;

use Yii;
use yii\web\{Controller,NotFoundHttpException};
use app\modules\surver\models\{Test,TestResult};
use app\modules\surver\models\search\TestSearch;


/**
 * Default controller for the `surver` module
 * Class DefaultController
 * @package app\modules\surver\controllers
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, true);

        $top10 = TestResult::top10(Yii::$app->request->queryParams);

        return $this->render('index', compact('searchModel', 'dataProvider','top10'));
    }

    /**
     * Превью тестового задания
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPreview($id)
    {

        return $this->render('preview', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionGo($id)
    {
        /** @var TestResult $model */
        $model = new TestResult();
        $model->fill($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(['result', 'id' => $model->id]);
        }
        return $this->render('go', compact('model'));
    }

    /**
     * Вывод результата
     * @param $id
     * @return string
     */
    public function actionResult($id)
    {

        $result = TestResult::findOne($id);
        return $this->render('result', [
            'model' => $result,
        ]);
    }

    /**
     * @param $id
     * @return Test|null|static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {

        /** @var Test $model */
        if (($model = Test::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
