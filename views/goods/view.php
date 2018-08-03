<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use kartik\date\DatePicker;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\Goods */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот товар?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'default_price',
        ],
    ]) ?>

</div>
<hr>
<div class="prices-index">

    <h2>Цены на товар "<?= Html::encode($this->title) ?>"</h2>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать цену', ['prices/create', 'goods_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'price',
            [
                'class' => 'app\components\grid\CombinedDataColumn',
                'labelTemplate' => '{0}  -  {1}',
                'valueTemplate' => '{0}  -  {1}',
                'labels' => [
                    'Начальная дата',
                    'Конечная дата',
                ],
                'attributes' => [
                    'str_start_date:html',
                    'str_end_date:html',
                ],
                'format' => 'raw',
                'filter' => DatePicker::widget([
                    'language' => Yii::$app->language,
                    'model' => $searchModel,
                    'attribute' => 'str_start_date',
                    'attribute2' => 'str_end_date',
                    'options' => ['placeholder' => ''],
                    'options2' => ['placeholder' => ''],
                    'type' => DatePicker::TYPE_RANGE,
                    'separator' => '<i class="glyphicon glyphicon-arrow-right"></i>',
                    'pluginOptions' => [
                        'format' => 'dd.mm.yyyy',
                        'autoclose' => true,
                        'todayHighlight' => true,
                        'clearBtn' => true,
                        'keepEmptyValues' => true,
                        'orientation' => 'top',
                    ]
                ]),
                'values' => [
                    function ($data) {
                        return Yii::$app->formatter->asDate($data->start_date, 'dd.MM.yyyy');
                    },
                    function ($data) {
                        return $data->end_date ? Yii::$app->formatter->asDate($data->end_date, 'dd.MM.yyyy') : '';
                    },
                ],
                'headerOptions' => [
                    'class' => 'text-center',
                ],
                'contentOptions' => [
                    'class' => 'text-center',
                ],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons'=>[
                    'view' => function ($url, $data) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/prices/view', 'id' => $data->id], [
                            'title' => Yii::t('yii', 'Просмотр'),
                        ]);
                    },
                    'update' => function ($url, $data) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/prices/update', 'id' => $data->id], [
                            'title' => Yii::t('yii', 'Редактировать'),
                        ]);
                    },
                    'delete' => function ($url, $data) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/prices/delete', 'id' => $data->id], [
                            'title' => Yii::t('yii', 'Удалить'),
                            'data' => [
                                'confirm' => 'Вы уверены, что хотите удалить эту цену?',
                                'method' => 'post',
                            ]
                        ]);
                    },
                ],
                'template'=>'{view} {update} {delete}',
            ],
        ],
    ]); ?>
</div>
<hr>
<div class="get-price">
    <h2>Узнать цену товара "<?= Html::encode($this->title) ?>" на определенную дату</h2>
    <?= $this->render('_formGetPrice', [
        'model' => $model,
        'getPriceForm' => $getPriceForm,
    ]) ?>
    <h2 id="received_price" style="display:none;">
        Цена товара "<?= Html::encode($this->title) ?>" =
        <span class="received_price" style="color:green;"></span>
    </h2>

</div>
<hr>
<div class="schedule-view">
    <h2>График изменения цены на товар "<?= Html::encode($this->title) ?>" </h2>
    <span>Метод 1: Приоритетнее цена с меньшим периодом действия</span>
    <?php
    $provider = new ArrayDataProvider([
        'allModels' => $schedulePrices1,
        'pagination' => [
            'pageSize' => 10,
        ],
    ]);

        echo GridView::widget([
            'dataProvider' => $provider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'date',
                    'label' => 'Дата',
                ],
                [
                    'attribute' => 'price',
                    'label' => 'Цена',
                ],
            ],
        ]);
    ?>
</div>
<hr>
<div class="schedule-view">
    <h2>График изменения цены на товар "<?= Html::encode($this->title) ?>" </h2>
    <span>Метод 2: Приоритетнее цена, установленная позднее</span>
    <?php
    $provider2 = new ArrayDataProvider([
        'allModels' => $schedulePrices2,
        'pagination' => [
            'pageSize' => 10,
        ],
    ]);

        echo GridView::widget([
            'dataProvider' => $provider2,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'date',
                    'label' => 'Дата',
                ],
                [
                    'attribute' => 'price',
                    'label' => 'Цена',
                ],
            ],
        ]);
    ?>
</div>
