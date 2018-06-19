<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\Comment;
use app\modules\blog\models\Post;
use Yii;
use yii\web\Controller;
use app\modules\blog\models\PostSearch;

/**
 * Default controller for the `blog` module
 */
class DefaultController extends Controller
{
    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,true);

        return $this->render('index', compact('searchModel', 'dataProvider'));
    }


    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $comment = new Comment();
        $comment->post_id = $id;
        if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
            return $this->refresh();
        }
        $model = Post::findOne($id);
        return $this->render('view', compact('model', 'comment'));
    }

}
