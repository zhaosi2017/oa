/**
 * Created by apple on 2017/1/13.
 */
var purchase_price = [];
var execute_price = [];

$("#add_money").click(function(){
    var money_value = $("#money_list").val();
    if($.inArray(money_value, purchase_price)<0){
        purchase_price = purchase_price.concat(money_value);

        var money_name = $("#money_list option:selected").text();
        var tr_purchase_html = '<tr><td>'+ money_name +'</td>' +
            '<td><input class="form-control" type="text" name="ProductPurchasePrice['+money_value+'][a_grade_price]"></td>'+
            '<td><input class="form-control" type="text" name="ProductPurchasePrice['+money_value+'][b_grade_price]"></td>'+
            '<td><input class="form-control" type="text" name="ProductPurchasePrice['+money_value+'][c_grade_price]"></td>'+
            '<td><input class="form-control" type="text" name="ProductPurchasePrice['+money_value+'][d_grade_price]"></td>'+
            '<td><a class="del-tr">删除</a></td></tr>';
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
        var tr_company_html = '<tr><td>'+ company_name +'</td>' +
            '<td><input class="form-control" type="text" name="ProductExecutePrice['+company_value+'][price]"></td>' +
            '<td><a class="del-tr">删除</a></td></tr>';
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