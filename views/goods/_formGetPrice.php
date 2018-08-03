<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 03.08.2018
 * Time: 16:54
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Goods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($getPriceForm, 'goods_id')->hiddenInput(['value'=> $model->id])->label(false) ?>

        <?= $form->field($getPriceForm, 'approach')->dropDownList([
            '1' => 'Метод 1',
            '2' => 'Метод 2',
        ]); ?>
        <div class="form-group">
            <?php
            echo '<label class="control-label">Укажите дату</label>';
            echo DatePicker::widget([
                'model' => $getPriceForm,
                'attribute' => 'date',
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'value' => '',
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd.mm.yyyy'
                ]
            ]);
            ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Узнать цену', ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

    <?php

    $js = <<<JS
 $('form').on('beforeSubmit', function(){
 var data = $(this).serialize();
 $.ajax({
 url: '/goods/price',
 type: 'POST',
 data: data,
 success: function(res){
 console.log(res);
 $('#received_price').show();
 $('#received_price .received_price').text(res);
 },
 error: function(){
 alert('Error!');
 }
 });
 return false;
 });
JS;

    $this->registerJs($js);
    ?>
</div>