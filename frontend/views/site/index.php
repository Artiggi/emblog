<?php

/* @var $this yii\web\View */
use yii\widgets\ListView;

$this->title = 'Elitmaster test task blog';
?>

<div class="col-md-8">

<?php
echo ListView::widget([
    'dataProvider' => $listDataProvider,
    'itemView' => '_list',
    'summary'=>false,
]);
?>
</div>
<div class="col-md-2"></div>
<div class="col-md-2">
    <h3>Категории</h3>
<?php
echo ListView::widget([
    'dataProvider' => $catDataProvider,
    'itemView' => '_cat',
    'summary'=>false,
]);
?>
</div>
