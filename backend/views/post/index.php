<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\StringHelper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создание статьи', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            [
                'attribute' => 'text',
                'value' => function ($model) {
                    return StringHelper::truncate($model->text, 100);
                }
            ],
            'catName',
            [
                'attribute' => 'tags',
                'value' => function ($model) {
                    $allTags = '';
                    foreach ($model->getPostTags()->all() as $post) {
                        $allTags .= $post->getTag()->one()->name . ', ';
                    }
                    $allTags = substr($allTags, 0, -2);
                    return $allTags;
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
