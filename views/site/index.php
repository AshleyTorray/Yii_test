<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;
/** @var yii\web\View $this */

$this->title = 'My Yii Application';
$asset = AppAsset::register($this);
$imageAsset = $asset->baseUrl .'/img/';
$testBoxUrl = Url::to(['box/index']);
$testProductUrl  = Url::to(['product/index']);
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Congratulations!</h1>

        <p class="lead">Here are Box-Product manage system</p>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-8 mb-3">
                <h2>Form for adding and editing a box, box list</h2>

                <p>1. Box form fields(app/box/_form.php)</p>
                <table class= "table">
                    <tr>
                        <td>
                            Weight
                        </td>
                        <td>
                            Width 
                        </td>
                        <td>
                            Length 
                        </td>
                        <td>
                            Height
                        </td>
                        <td>
                            Referance
                        </td>
                        <td>
                            status
                        </td>
                    </tr>
                    <tr>
                        <td>
                        kg (number accurate to hundredths)
                        </td>
                        <td>
                        cm (number accurate to hundredths)
                        </td>
                        <td>
                        cm (number accurate to hundredths)
                        </td>
                        <td>
                        cm (number accurate to hundredths)
                        </td>
                        <td>
                            *required field
                        </td>
                        <td>
                            cannot set when add the box
                            Expected
                            At warehouse
                            Prepared
                            Shipped
                        </td>
                    </tr>
                </table>
                <P>
                    2. List(table) of Boxes (app/box/index.php)
                </P>
                <table class= "table">
                    <tr>
                        <td>
                            checkbox field
                        </td>
                        <td>
                            BoxID 
                        </td>
                        <td>
                            Date
                        </td>
                        <td>
                            Weight
                        </td>
                        <td>
                            Status
                        </td>
                        <td>
                            Actions
                        </td>
                    </tr>
                    <tr>
                        <td>
                        for selecting boxes
                        </td>
                        <td>
                        
                        </td>
                        <td>
                        date and time of creation
                        </td>
                        <td>
                        weight editing form
                        </td>
                        <td>
                        status change form with validation: can only be changed to Expected and At warehouse to change the status to At warehouse , you need to fill in Weight and you need to Shipped qty and received qty in all products were the same
                        </td>
                        <td>
                        buttons: product card, editing and deleting
                        </td>
                    </tr>
                </table>
                <p>
                    3. Box list filtering
                </p>
                <table class="table">
                    <tr>
                        <td>
                            Date from
                        </td>
                        <td>
                            Date to
                        </td>
                        <td>
                            Search
                        </td>
                        <td>
                            Status
                        </td>
                    </tr>
                    <tr>
                        <td>
                            calendar selecting
                        </td>
                        <td>
                            calendar selecting
                        </td>
                        <td>
                            By id and referance of Box, title and SKU of Product
                        </td>
                        <td>
                            When select the Status
                        </td>
                    </tr>
                </table>
                <p>
                    4. Sorting by id, date, weight and status
                </p>
                <p>
                    5. Report button to export the current list of boxes to excel (columns ID, Date , Weight , Status )
                </p>
                <p>
                    6. Marking boxes (with color or icon) that are Shipped qty and received qty of products do not match
                </p>
                <p>
                    7. Event: Calculating the Weight of a box if its status is not yet Prepared and saving it in the database
                </p>
                <p> 8. Calculating the total amount of products in a box and saving it in the database</p>

                <p><a class="btn btn-outline-primary" href="<?= $testBoxUrl?>">Test adding box &raquo;</a></p>
            </div>
            <div class = "col-lg-4 mb-3">
                <?=  Html::img($imageAsset.'1.png',  ['class' => 'img-circle', 'size' => '120'])?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 mb-3">
                <h2>Box Card</h2>
                <p>1. Form for adding, editing and deleting products</p>
                <p> Products form fields: </p>
                <table class= "table">
                    <tr>
                        <td>
                            Tile
                        </td>
                        <td>
                            SKU 
                        </td>
                        <td>
                            Shipped Qty 
                        </td>
                        <td>
                            Received Qty
                        </td>
                        <td>
                            Price
                        </td>
                    </tr>
                    <tr>
                        <td>
                            * required field
                        </td>
                        <td>
                            * required field, unique field
                        </td>
                        <td>
                            reuqired field, ineger
                        </td>
                        <td>
                            has Match Button(shippedQty  = ReceivedQty)
                        </td>
                        <td>
                            number accurate to hundredths
                        </td>
                    </tr>
                </table>
                <p>2. Total number of items in the box</p>
                <p>3. Form for changing the status of a box with validation </p>
                <p> * status can only be changed to Prepared and Shipped , you can change the status only if products have been added</p>
                <p>4. Checking the box to see if it contains Shipped products qty and received qty do not match, and saving the check result in the database</p>

                <p><a class="btn btn-outline-primary" href="<?= $testProductUrl?>">Test box Card & Product creating &raquo;</a></p>
            </div>
            <div class = "col-lg-4 mb-3">
                <?=  Html::img($imageAsset.'1.png',  ['class' => 'img-circle', 'size' => '120'])?>
            </div>
        </div>
    </div>
</div>
