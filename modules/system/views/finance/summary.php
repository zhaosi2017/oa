<?php
/* @var $this yii\web\View */
/* @var $model */
/* @var $money */

use yii\widgets\Pjax;

$identity = (Object) Yii::$app->user->identity;
$this->title = '公司账目中心';
$this->params['breadcrumbs'][] = ['label'=>'系统','url'=>''];
$this->params['breadcrumbs'][] = $this->title;
$count_money = count($money);
$count_company = count($model);
?>
<div class="summary-index">
    <?php Pjax::begin(); ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="<?= $count_money * 3 + 2 ?>">账目列表</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php
                $tr = '';
                for($i=-2; $i<$count_company; ++$i){
                    $tr .= '<tr>';
                    for($j=-2; $j<$count_money; ++$j){
                        if($i==-2 && $j==-2){
                            $tr .= '<td rowspan="2">序号</td>';
                        }elseif($i==-2 && $j==-1){
                            $tr .= '<td rowspan="2">公司名称</td>';
                        }elseif($i==-2){
                            $tr .= '<td colspan="3">'.$money[$j]['name'].'</td>';
                        }elseif($i==-1 && $j<0){
                            $tr .= '';
                        }elseif($i==-1 && $j>=0){
                            $tr .= '<td>总收入</td><td>总支出</td><td style="background-color:#F5F5F6">合计</td>';
                        }elseif($j==-2){
                            $tr .= '<td>'.($i+1).'</td>';
                        }elseif($j==-1){
                            $tr .= '<td>'.$model[$i]['name'].'</td>';
                        }else{
                            $data = $model[$i]['statistic'];
                            if(!empty($data)){
                                !isset($data['un_collection'][$money[$j]['id']]) && $data['un_collection'][$money[$j]['id']]=0;
                                !isset($data['collection'][$money[$j]['id']]) && $data['collection'][$money[$j]['id']]=0;
                                !isset($data['un_pay'][$money[$j]['id']]) && $data['un_pay'][$money[$j]['id']]=0;
                                !isset($data['pay'][$money[$j]['id']]) && $data['pay'][$money[$j]['id']]=0;
                                !isset($data['statement'][$money[$j]['id']]) && $data['statement'][$money[$j]['id']]=['gross'=>0,'spending'=>0];

                                $gross = $data['collection'][$money[$j]['id']] + $data['un_pay'][$money[$j]['id']] + $data['statement'][$money[$j]['id']]['gross'];
                                $spending = $data['pay'][$money[$j]['id']] + $data['un_collection'][$money[$j]['id']] + $data['statement'][$money[$j]['id']]['spending'];
                                $total = $gross-$spending;

                                $gross = number_format($gross,2);
                                $spending = number_format($spending,2);
                                $total = number_format($total,2);

                                $tr .= '<td>'.$gross.'</td><td>'.$spending.'</td><td style="background-color:#F5F5F6">'.$total.'</td>';
                            }else{
                                $tr .= '<td></td><td></td><td style="background-color:#F5F5F6"></td>';
                            }
                        }
                    }
                    $tr .= '</tr>';
                }
                echo $tr;
            ?>

        </tbody>
    </table>
    <?php Pjax::end(); ?>
</div>
