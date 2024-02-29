<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SKU')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shippedQty')->textInput(['type' => 'number', 'step' => '1']) ?>

    <button class="btn btn-info" id="matchQtyButton">Match</button>
    <?= $form->field($model, 'receivedQty')->textInput(['type' => 'number', 'step' => '1']) ?>

    <?= $form->field($model, 'price')->textInput(['type' => 'number', 'step' => '0.01']) ?>

    <?= $form->field($model, 'box_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
document.getElementById('matchQtyButton').addEventListener('click', function() {
    const shippedQtyInput = document.getElementById('product-shippedqty');
    document.getElementById('product-receivedqty').value = shippedQtyInput.value;
});
</script>