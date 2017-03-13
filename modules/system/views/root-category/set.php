<?php
/* @var $this yii\web\View */
/* @var $model */
use yii\widgets\ActiveForm;

$this->title = '根分类设置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="root-category-set">

    <div class="root-category-form">

        <?php $form = ActiveForm::begin([
            'options'=>['class'=>'form-horizontal m-t'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-sm-9\">{input}\n<span class=\"help-block m-b-none\">{error}</span></div>",
                'labelOptions' => ['class' => 'col-sm-3 control-label'],
            ],
        ]) ?>

        <?php
        $identify = (Object) Yii::$app->user->identity;
        ?>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="subordinate_company">所属公司</label>
            <div class="col-sm-9">
                <input class="form-control" id="subordinate_company" type="text" readonly="readonly" value="<?=
                \app\modules\user\models\Company::findOne($identify->company_id)->getAttribute('name');
                ?>">
            </div>
        </div>

        <?= $form->field($model, 'company_id')->hiddenInput(['value'=>$identify->company_id])->label(false) ?>

        <?= $form->field($model, 'name')->textInput() ?>

        <?= $form->field($model, 'visible')->checkboxList(
            [
                8 => '直属上级',
                4 => '直属下级',
                2 => '集团内旁枝',
                1 => '集团外公司',
            ]
        ) ?>

        <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3">
                <?= \yii\helpers\Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
