<?php

use app\models\Box;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\jui\DatePicker;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\BoxSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Boxes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="container-fluid">
        <div class="float-start">
            <?= Html::a('Create Box', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="float-end">
            <?= Html::a('Report',  ['export'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>
    <br>
    <br>

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => CheckboxColumn::className()],
            [
                'attribute' => 'id',
                'headerOptions' => ['style' => 'width:10%;'], 
                'contentOptions' => ['style' => 'width:10%; text-align:center;'], 
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width:15%; text-align:center;'],
                'value' => 'created_at',
                'filter' => \yii\jui\DatePicker::widget([
                    'model'=>$searchModel,
                    'attribute'=>'date_from',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control', 'placeholder' => 'From Date']
                ]) . \yii\jui\DatePicker::widget([
                    'model'=>$searchModel,
                    'attribute'=>'date_to',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control', 'placeholder' => 'To Date']
                ]),
            ],
            [
                'attribute' => 'weight',
                'headerOptions' => ['style' => 'width:10%;'],
                'contentOptions' => ['style' => 'width:10%; text-align:center;'], 
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'headerOptions' => ['style' => 'width:25%;'],
                'contentOptions' => ['style' => 'width:25%; text-align:center; background-color: gray;'], 
                'value' => function ($model) {
                    return Html::activeDropDownList($model, 'status', Box::getStatusOptions(), [
                        'class' => 'form-control',
                        'prompt' => 'Change Status',
                        'data-id' => $model->id,
                        'disabled' => !in_array($model->status, ['Expected', 'At warehouse']),
                        'onchange' => new \yii\web\JsExpression("
                            // Check if additional conditions such as weight are met before submitting
                            $.ajax({
                                url: '" . Url::to(['box/update-status']) . "',
                                type: 'POST',
                                data: { id: $(this).data('id'), status: $(this).val() },
                                success: function(response) { q
                                    // Handle response here if needed
                                }
                            });
                        "),
                    ]);
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    Box::getStatusOptions(),    
                    ['class'=>'form-control','prompt' => 'Select Status']
                ),
            ],

            [
                'class' => ActionColumn::className(),
                'headerOptions' => ['style' => 'width:40%;'],
                'contentOptions' => ['style' => 'width:40%; text-align:center;'], 
                'template' => '{product-card} {update} {delete}',
                'buttons' => [
                    'product-card' => function ($url, $model, $key) {
                        return Html::a('Product Card', ['box/card', 'id' => $model->id], 
                            ['class' => 'btn btn-primary btn-xs', 'style' => 'margin-right: 5%;']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('Edit', $url,
                            ['title' => Yii::t('app', 'Update'), 'class' => 'btn btn-info btn-xs', 'style' => 'margin-right: 5%;']);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Delete', ['box/delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-xs',
                            'style' => 'margin-right: 5%;',
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post', // This ensures the request is sent as POST
                        ]);
                    },
                ],
            ],
        ],
        'rowOptions' => function ($flag, $key, $index, $grid) {
            if (!$flag) {
                return ['style' => 'background-color: yellow;'];
            }
            return [];
        },
    ]); ?>

    <div class="modal fade" id="box-card-modal" tabindex="-1" role="dialog" aria-labelledby="boxCardModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <!-- Content will be loaded here -->
        </div>
    </div>
    </div>


</div>
<script>
    $('#box-card-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var boxId = button.attr('href'); // Extract href from button, which contains the URL to the card

        var modal = $(this);
        modal.find('.modal-content').load(boxId);

        event.preventDefault(); // Prevent default action of opening new page
    });
</script>
