<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PricesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Prices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prices-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать цену', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'goods_id',
            'price',
            [
                'class' => 'app\components\grid\CombinedDataColumn',
                'labelTemplate' => '{0}  -  {1}',
                'valueTemplate' => '{0}  -  {1}',
                'labels' => [
                    'start date',
                    'end date',
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
                    'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
                    'pluginOptions' => [
                        'format' => 'dd.mm.yyyy',
                        'autoclose' => true,
                        'todayHighlight' => true,
                        'clearBtn' => true,
                        'keepEmptyValues' => true,
                        'orientation' => 'bottom',
                    ]
                ]),
                'values' => [
                    function ($data) {
                        return Yii::$app->formatter->asDate($data->start_date, 'dd.MM.yyyy');
                    },
                    function ($data) {
                        return Yii::$app->formatter->asDate($data->end_date, 'dd.MM.yyyy');
                    },
                ],
                'headerOptions' => [
                    'class' => 'text-center',
                ],
                'contentOptions' => [
                    'class' => 'text-center',
                ],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
