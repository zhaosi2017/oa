<?php

/* @var $this yii\web\View */
/* @var $model */
/* @var $company */

$this->title = '集团公司级别表' ;
$this->params['breadcrumbs'][] = ['label'=>'系统','url'=>''];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-grid">

    <div class="table-responsive">
        <table class="table table-bordered">
            <?php
                if(!empty($company)){
                    $cols = count($company);
            ?>
            <thead>
            <tr>
                <th colspan="<?= $cols+1 ?>">集团公司级别表</th>
            </tr>
            </thead>
            <tbody>
            <?php
                    $rate = [1=>'A',2=>'B',3=>'C',4=>'D'];
                    $row = '';
                    for ($i=0; $i<=$cols; ++$i){
                        $row.='<tr class="text-center">';
                        for($j=0; $j<=$cols; ++$j){
                            if($i==$j && $i==0 && $j==0){
                                $row .= '<td></td>';
                            }elseif($i==0){
                                $row .= '<td>'.$company[$j-1]['name'].'</td>';
                            }elseif($j==0){
                                $row .= '<td>'.$company[$i-1]['name'].'</td>';
                            }else{
                                $key = $company[$i-1]['id'].'-'.$company[$j-1]['id'];
                                if(array_key_exists($key, $model)){
                                    $grade = $model[$key];
                                    $row .= '<td>'.$rate[$grade].'</td>';
                                }else{
                                    $row .= '<td>-</td>';
                                }
                            }
                        }
                        $row .= '</tr>';
                    }
                    echo $row;
                }
            ?>
            </tbody>
        </table>
    </div>


</div>
