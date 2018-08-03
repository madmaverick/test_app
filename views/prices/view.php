<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Prices */

$this->title = 'Просмотр цены';
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['goods/index']];
$this->params['breadcrumbs'][] = ['label' => $goods->name, 'url' => ['goods/view', 'id' => $goods->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prices-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить эту цену?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'goods_id',
            'price',
            'str_start_date',
            'str_end_date',
        ],
    ]) ?>

</div>
