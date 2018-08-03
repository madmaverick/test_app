<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Prices */

$this->title = 'Создать цену';
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['goods/index']];
$this->params['breadcrumbs'][] = ['label' => $goods->name, 'url' => ['goods/view', 'id' => $goods->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prices-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
