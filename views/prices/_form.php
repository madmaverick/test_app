<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Prices */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prices-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <div class="form-group">
        <?php

        //Date range
        echo '<label class="control-label">Период цены</label>';
        echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'str_start_date',
            'attribute2' => 'str_end_date',
            'options' => ['placeholder' => 'Дата начала периода'],
            'options2' => ['placeholder' => 'Дата конца периода'],
            'type' => DatePicker::TYPE_RANGE,
            'separator' => 'до',
            'form' => $form,
            'pluginOptions' => [
                'format' => 'dd.mm.yyyy',
                'autoclose' => true,
                'todayHighlight' => true,
                'clearBtn' => true,
                'keepEmptyValues' => true,
                'language' => Yii::$app->language,
                'orientation' => 'bottom',
            ]
        ]);
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
