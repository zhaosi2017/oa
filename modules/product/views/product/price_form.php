<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\product\models\Product */
/* @var $form yii\widgets\ActiveForm */

$this->title = ' 编辑产品: ' . $model->name;
$actionId = Yii::$app->requestedAction->id;
//var_dump($company);
?>
<div class="product-price">
    <p class="btn-group hidden-xs">
        <?= Html::a('基本信息', ['update?id=' . $model->id], ['class' => $actionId=='update' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
        <?= Html::a('产品价格', ['price?id=' . $model->id], ['class' => $actionId=='price' ? 'btn btn-outline btn-default' : 'btn btn-primary']) ?>
    </p>

    <div class="table-responsive">
        <form action="" method="post" id="w0">
            <input type="hidden" name="_csrf" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
            <input type="hidden" name="product-id" id="product_id" value="<?= $model->id ?>">

            <table class="table table-bordered text-center" id="purchase_price">
                <thead>
                <tr>
                    <th colspan="6">购买价格</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="8">
                        <a class="btn btn-link pull-right" id="add_money">新增货币</a>
                        <div class="form-inline form-group pull-right no-borders">
                            <label for="money_list"></label>
                            <select class="form-control" name="money" id="money_list">
                                <option value="">请选择货币</option>
                                <?php
                                    $moneyList = \app\modules\system\models\Money::findAll(['status'=>0,'enable'=>0]);
                                    $money_column = [];
                                    foreach ($moneyList as $item){
                                        $money_column[$item->id] = $item->name;
                                        echo '<option value="'.$item->id.'">'.$item->name.'</option>';
                                    }
                                ?>
                            </select>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td>货币\级别价格</td>
                    <td>A级价格</td>
                    <td>B级价格</td>
                    <td>C级价格</td>
                    <td>D级价格</td>
                    <td>操作</td>
                </tr>

                <?php
                    $purchase_price = [] + \app\modules\product\models\ProductPurchasePrice::find()->where(['product_id'=>$model->id])->indexBy('money_id')->all();
                    foreach ($purchase_price as $money_id => $price){
                        echo '<tr><td>'.$money_column[$money_id].'</td>'
                            .'<td><input class="form-control" type="text" name="ProductPurchasePrice['.$money_id.'][a_grade_price]" value="'.$price['a_grade_price'].'"></td>'
                            .'<td><input class="form-control" type="text" name="ProductPurchasePrice['.$money_id.'][b_grade_price]" value="'.$price['b_grade_price'].'"></td>'
                            .'<td><input class="form-control" type="text" name="ProductPurchasePrice['.$money_id.'][c_grade_price]" value="'.$price['c_grade_price'].'"></td>'
                            .'<td><input class="form-control" type="text" name="ProductPurchasePrice['.$money_id.'][d_grade_price]" value="'.$price['d_grade_price'].'"></td>'
                            .'<td><a class="del-tr">删除</a></td></tr>';
                    }
                ?>
                <!--<tr>
                    <td>欢乐豆</td>
                    <td><input class="form-control" type="text" id="" name="ProductPurchasePrice[]"></td>
                    <td><input class="form-control" type="text" id="" name="ProductPurchasePrice[]"></td>
                    <td><input class="form-control" type="text" id="" name="ProductPurchasePrice[]"></td>
                    <td><input class="form-control" type="text" id="" name="ProductPurchasePrice[]"></td>
                    <td>删除</td>
                </tr>-->

                </tbody>
            </table>

            <table class="table table-bordered text-center" id="execute_price">
                <thead>
                <tr>
                    <th colspan="5">执行价格</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="5">
                        <a class="btn btn-link pull-right" id="add_company">新增公司</a>
                        <div class="form-inline form-group no-borders pull-right">
                            <label for="company_list"></label>
                            <select class="form-control" name="company" id="company_list">
                                <option value="">请选择公司</option>
                                <?php
                                    $company_column = [];
                                    if(!empty($company)){
                                        foreach ($company as $item){
                                            $company_column[$item['id']] = $item['name'];
                                            echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="form-inline form-group no-borders pull-right">
                            <label for="preset_currency"></label>
                            <select class="form-control" name="preset-currency" id="preset_currency">
                                <option value="">选择预置货币</option>
                                <?php
                                    foreach ($moneyList as $item){
                                        if($item->name == '欢乐豆'){
                                            echo '<option selected="selected" value="'.$item->id.'">'.$item->name.'</option>';
                                        }else{
                                            echo '<option value="'.$item->id.'">'.$item->name.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td>执行公司</td>
                    <td id="preset-label">欢乐豆</td>
                    <td>操作</td>
                </tr>

                <?php
                $execute_price = [] + \app\modules\product\models\ProductExecutePrice::find()->where(['product_id'=>$model->id])->indexBy('company_id')->all();
                foreach ($execute_price as $company_id => $price){
                    echo '<tr><td>'.$company_column[$company_id].'</td>'
                        .'<td><input class="form-control" type="text" name="ProductExecutePrice['.$company_id.'][price]" value="'.$price['price'].'"></td>'
                        .'<td><a class="del-tr">删除</a></td></tr>';
                }
                ?>
                <!--
                <tr>
                    <td>A公司</td>
                    <td><input class="form-control" type="text" name="Price[]"></td>
                    <td>删除</td>
                </tr>
                -->
                </tbody>
            </table>

            <div class="form-group">
                <div class="col-sm-offset-9">
                    <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
$this->registerJs('
var purchase_price = [];
var execute_price = [];

$("#add_money").click(function(){
    var money_value = $("#money_list").val();
    if($.inArray(money_value, purchase_price)<0){
        purchase_price = purchase_price.concat(money_value);

        var money_name = $("#money_list option:selected").text();
        var tr_purchase_html = \'<tr><td>\'+ money_name +\'</td>\' +
            \'<td><input class="form-control" type="text" name="ProductPurchasePrice[\'+money_value+\'][a_grade_price]"></td>\'+
            \'<td><input class="form-control" type="text" name="ProductPurchasePrice[\'+money_value+\'][b_grade_price]"></td>\'+
            \'<td><input class="form-control" type="text" name="ProductPurchasePrice[\'+money_value+\'][c_grade_price]"></td>\'+
            \'<td><input class="form-control" type="text" name="ProductPurchasePrice[\'+money_value+\'][d_grade_price]"></td>\'+
            \'<td><a class="del-tr">删除</a></td></tr>\';
        if(money_value){
            $("#purchase_price").append(tr_purchase_html);
        }
    }
    $(".del-tr").click(function(){
        $(this).parent().parent().remove();
    });
});

$("#add_company").click(function(){
    var company_value = $("#company_list").val();
    if($.inArray(company_value, execute_price)<0){
        execute_price = execute_price.concat(company_value);

        var company_name = $("#company_list option:selected").text();
        var tr_company_html = \'<tr><td>\'+ company_name +\'</td>\' +
            \'<td><input class="form-control" type="text" name="ProductExecutePrice[\'+company_value+\'][price]"></td>\' +
            \'<td><a class="del-tr">删除</a></td></tr>\';
        if(company_value){
            $("#execute_price").append(tr_company_html);
        }
    }
    $(".del-tr").click(function(){
        $(this).parent().parent().remove();
    });
});

$("#preset_currency").bind("change",function(){
    var preset_label = $("#preset_currency option:selected").text();
    if($(this).val()){
        $("#preset-label").html(preset_label);
    }
});
$(".del-tr").click(function(){
        $(this).parent().parent().remove();
    });
    
');

?>