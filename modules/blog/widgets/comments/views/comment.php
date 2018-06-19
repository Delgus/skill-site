<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 05.06.2018
 * Time: 12:00
 */

?>
<?php foreach ($comments as  $comment): ?>
    <div>
        <pre>
        <p><?= $comment->getUsername($comment->created_by) ?>  <?=\Yii::$app->formatter->asDatetime($comment->created_at)?></p>
        <p><?= $comment->text ?></p>
        </pre>
    </div>
<?php endforeach; ?>