<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 05.06.2018
 * Time: 12:00
 */



?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Участник</th>
        <th scope="col">Результат</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($results as $i => $result): ?>
        <tr>
            <th scope="row"><?= $i + 1 ?></th>
            <td><?= $result->getUsername($result->user_id) ?></td>
            <td><?= $result->test_result ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>