<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\modules\user\models\Posts */

$this->title = '集团公司评级' ;
$this->params['breadcrumbs'][] = ['label' => '客户', 'url' => ''];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-grid">

    <div class="table-responsive">
        <form action="" method="post" id="w0">
            <input type="hidden" name="_csrf" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="4">集团公司</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-center" width="10%">序号</td>
                <td class="text-center" width="20%">公司名称</td>
                <td>级别</td>
                <td>最后修改人／时间</td>
            </tr>
            <?php if(!empty($company)) {
                foreach ($company as $k=>$v){
                    ?>
                    <tr>
                        <td class="text-center"><?= $k+1 ?></td>
                        <td class="text-center"><?= $v->name ?></td>
                        <td>
                            <input type="hidden" name="<?= 'company'.$k.'[id]' ?>" value="<?= $v->id ?>">
                            <label><input type="radio" <?php
                                if(isset($groupRate[$v->id])){
                                    echo $groupRate[$v->id] == 4 ? 'checked' : '';
                                }
                                ?> name="<?= 'company'.$k.'[grade]' ?>" value="4"> D级
                            </label>
                            <label><input type="radio" <?php
                                if(isset($groupRate[$v->id])){
                                    echo $groupRate[$v->id] == 3 ? 'checked' : '';
                                }
                                ?> name="<?= 'company'.$k.'[grade]' ?>" value="3"> C级
                            </label>
                            <label><input type="radio" <?php
                                if(isset($groupRate[$v->id])){
                                    echo $groupRate[$v->id] == 2 ? 'checked' : '';
                                }
                                ?> name="<?= 'company'.$k.'[grade]' ?>" value="2"> B级
                            </label>
                            <label><input type="radio" <?php
                                if(isset($groupRate[$v->id])){
                                    echo $groupRate[$v->id] == 1 ? 'checked' : '';
                                }
                                ?> name="<?= 'company'.$k.'[grade]' ?>" value="1"> A级
                            </label>
                        </td>
                        <td><?= $v['updater']['account'] ?>／<?= $v->update_time ?></td>
                    </tr>
            <?php
                }
            }
            ?>

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
