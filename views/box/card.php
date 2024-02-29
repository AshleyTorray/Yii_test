<?php
// views/box/card.php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/** @var \app\models\Box $model */
/** @var \yii\data\ActiveDataProvider $productsProvider */

$this->title = Html::encode($boxModel->reference);
?>
<div class="container">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h1><?= $this->title ?></h1>
            <p>No: <?= $boxModel->id?><br>Reference: <?= Html::encode($boxModel->reference) ?></p>
        </div>
        <!-- Back Button -->
        <div class="col-sm-6 text-end">
            <?= Html::a('Back', Url::to(['index']), ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>

    <div class="row mb-3">
        <span>Total Quantity: <?= Html::encode($totalProduct) ?></span>
    </div>

    <!-- Status Radio Buttons -->
    <div class="row mb-3">
        <label>Status:</label><br>
        <?php
        $statuses = ['Prepared', 'At warehouse', 'Shipped', 'Received'];
        foreach ($statuses as $status) {
            echo Html::radio('status', false, [
                'value' => $status,
                'label' => $status,
                'uncheck' => null
            ]);
        }
        ?>
    </div>

    <!-- Products List -->
    <?= ListView::widget([
        'dataProvider' => $productsProvider,
        'layout' => "{items}\n{pager}", // Wrap items in a row
        'options' => ['class' => 'row row-cols-1 row-cols-md-3 g-4'], // Set the row options here
        'itemOptions' => [
            'tag' => 'div', 
            'class' => 'col' // This is where you specify the column class
        ],
        'itemView' => function ($productModel, $key, $index, $widget) {
            $isComplete = $productModel->shippedQty == $productModel->receivedQty;
            return '<div class="col">' . // Each item will take up 4 columns out of 12, fitting 3 in a row
                    '<div class="card border-success mb-4 h-100 shadow p-3 mb-5 bg-body-tertiary rounded">' .
                        '<div class="card-body">' .
                            '<h5 class="card-title">' . Html::encode($productModel->title) . '</h5>' .
                            '<p class="card-text">' .
                                'Shipped Quantity: ' . Html::encode($productModel->shippedQty) . '<br>' .
                                'Received Quantity: ' . Html::encode($productModel->receivedQty) .
                            '</p>' .
                            ($isComplete ? '<span class="badge bg-success">Matched</span>' : '<span class="badge bg-danger">Unmatched</span>') .
                        '</div>' .
                    '</div>' .
                '</div>';
        },
        'emptyText' => '<div class="col-12"><div class="alert alert-info" role="alert">No products found.</div></div>',
    ]);
    ?>

</div>

