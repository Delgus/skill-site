<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 05.06.2018
 * Time: 14:56
 */

namespace app\modules\blog\widgets\comments;

use yii\base\Widget;
use app\modules\blog\models\Comment;

class Comments extends Widget
{
    public $post_id;

    public function run()
    {
        $comments = Comment::find()->where(['post_id' => $this->post_id])->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('comment', compact('comments'));
    }
}