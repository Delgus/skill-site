<?php

use yii\helpers\Html;
use app\modules\surver\models\TestCategory;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\surver\models\search\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Тесты';
?>


<div class="surver-default-index">
    <p>
        <?php echo Html::a('Все категории', ['index'], ['class' => 'btn btn-lg btn-primary']) . '&nbsp;&nbsp;';
        $categories = ArrayHelper::map(TestCategory::find()->all(), 'name', 'name');
        foreach ($categories as $cat) {
            echo Html::a($cat, ['index?TestSearch[category]=' . $cat], ['class' => 'btn btn-lg btn-primary']) . '&nbsp;&nbsp;';
        } ?>
    </p>
    <div class="col-md-8">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
            'summary' => ''
        ]);
        ?>
    </div>
    <div class="col-md-4">
        <h3>Топ-10 участников</h3>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Участник</th>
                <th scope="col">Результат</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($top10 as $i => $one): ?>
                <tr>
                    <th scope="row"><?= $i + 1 ?></th>
                    <td><?= $one->getUsername($one->user_id) ?></td>
                    <td><?= $one->test_result ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
