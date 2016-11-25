<?php
use yii\helpers\Html;
?>


<h2><?= Html::encode($model->title) ?></h2>
<div class="row">
    <?= Html::encode($model->text) ?>
</div>
<div class="row bg-info">
<?php
    if ($model->catName){
        echo 'Категория: ' .Html::encode($model->catName);
    }
    else {
        echo 'Данная статья не имеет категории';
    }
?>
</div>
<div class="row bg-info">

    <?php
    $allTags = '';
    foreach ($model->getPostTags()->all() as $post) {
    $allTags .= $post->getTag()->one()->name . ', ';
    }
    if ($allTags){
        echo 'Теги: ' . substr($allTags, 0, -2);
    }
    else {
        echo 'Теги у данной статьи отстутсвуют';
    }
    ?>
</div>
