<?php
use yii\helpers\Html;
?>

    <li>
        <?= Html::a($model->name, ['site/index'],
            [
            'data-method' => 'POST',
            'data-params' => [
                'cat' => $model->id,
            ],
            ]
        ) ?>
    </li>



