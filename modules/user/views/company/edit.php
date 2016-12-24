<?php
//use yii\helpers\Url;

$this->title = '编辑公司';
$this->params['breadcrumbs'][] = $this->title;

$editData = [
    'name' => isset($oneCompany['name']) ? $oneCompany['name'] : '',
    'superior_company_name' => isset($oneCompany['superior_company_name']) ? $oneCompany['superior_company_name'] : '',
    'level' => isset($oneCompany['level']) ? $oneCompany['level'] : ''
];
$this->registerJsFile('@web/js/user/company.edit.js',['depends' => 'app\assets\GlobalAsset']);
?>
<form action="" method="post" id="ajax-form" class="form-horizontal m-t">
    <input class="need-submit-element" name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
    <input class="need-submit-element" name="primary_key" type="hidden" id="primary_key" value="<?= $editData['name'] ?>">
    <input type="hidden" id="source_superior" value="<?= $editData['superior_company_name'] ?>">
    <div class="form-group">
        <label class="col-sm-3 control-label"><span style="color:red">*</span>公司名称：</label>
        <div class="col-sm-9">
            <input maxlength="20" data-name-check="" data-msg-check="" required="" aria-required="true" type="text" value="<?= $editData['name'] ?>" name="name" class="form-control need-submit-element" placeholder="请输入文本">
            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 限20个字</span>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group">
        <label class="col-sm-3 control-label">上级公司：</label>
        <div class="col-sm-9">
            <select title="" class="form-control need-submit-element" name="superior_company_name">
                <?php
                    if(!empty($companyList)){
                        foreach ($companyList as $v){
                            echo '<option' .($v['name'] == $editData['superior_company_name'] ? ' selected="selected"' : '').  ' data-level="'.$v['level'].'" value="'.$v['name'].'">'.$v['name'].'</option>';
                        }
                    }else{
                        echo '<option data-level="0" value="无">无</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group">
        <label class="col-sm-3 control-label">层级：</label>
        <div class="col-sm-9">
            <p id="show-level" class="form-control-static"><span id="superior-level"><?= --$editData['level'] ?></span>级</p>
            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 上级公司层级</span>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            <button class="btn btn-primary" type="submit">提交</button>
        </div>
    </div>
</form>

