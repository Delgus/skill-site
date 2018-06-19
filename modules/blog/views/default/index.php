<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
use app\modules\blog\models\PostCategory;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\surver\models\search\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Блог';
?>


<div class="blog-default-index">
    <p>
        <?php echo Html::a('Все категории', ['index'], ['class' => 'btn btn-lg btn-primary']) . '&nbsp;&nbsp;';
        $categories = ArrayHelper::map(PostCategory::find()->all(), 'name', 'name');
        foreach ($categories as $cat) {
            echo Html::a($cat, ['index?PostSearch[category]=' . $cat], ['class' => 'btn btn-lg btn-primary']) . '&nbsp;&nbsp;';
        } ?>
    </p>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
        'summary' => ''
    ]);
    ?>
</div>