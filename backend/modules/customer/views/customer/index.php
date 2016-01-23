<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\customer\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="box">
           <div class="box-header with-border" style="height:50px;">
                <h3 class="box-title"><?=Html::encode($this->title)?></h3>
                 <div class="box-tools" >
                    <div class="input-group" style="width: 150px; margin">                      
                      <div class="input-group-btn">
                        <?= Html::button('<i class="fa fa-plus"></i> ' . Yii::t('backend/modules/customer',' New'),['value'=>Url::to(['customer/create']),'class' => 'btn btn-md btn-primary','id'=>'modal-customer-add'])?>
                     
                        <button class="btn btn-md btn-success" style="margin-left:5px;"><i class="fa fa-file-excel-o"></i> <?= Yii::t('backend/modules/customer',' Export excel')?></button>
                      </div>
                    </div>
                </div>
           </div><!-- /.box-header -->
            <?php Pjax::begin(['id'=>'customer-grid']);?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'emptyCell'=>'-',
                'columns' => [
                  /*  ['class' => 'yii\grid\SerialColumn'],*/
                    ['class' =>'yii\grid\CheckBoxColumn'],
                    [
                        'attribute' => 'customer_code',
                        'format'=>'raw',
                        'value' => function($model){
                            return $model->getCustomerCodeLink();
                        }
                    ],
                    [
                        'attribute' => 'customer_name',
                        'format'=>'raw',
                        'value' => function($model){
                            return $model->getCustomerNameLink();
                        }
                    ],
                    [
                        'attribute' => 'customer_type',
                        'format' => 'html',
                        'filter' => Html::activeDropDownList($searchModel,'customer_type',$searchModel->getCustomerTypeList(),['class'=>'form-control','prompt' => 'Select Category']),
                        'value' => function($model){
                            return $model->getCustomerTypeName();
                        }
                    ],
                    'phone_number',
                    'address',
                    'last_order:date',
                    [
                        'attribute' => 'debit',
                        'format' => 'currency'
                    ],            
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' =>'{delete}',
                        'header' =>'Actions',
                        'contentOptions'  => ['style' =>'text-align:center' ]
                    ],
                ],
                'options' => [
                    'class' => 'box-body'
                ],
                'tableOptions' => ['class' => 'table table-hover table-bordered'],
                'rowOptions' => function($model){
                    if($model->debit > 0 ){
                        return ['class' => 'danger'];
                    }
                },
                'layout' => $this->render('_search', ['model' => $searchModel]) . '{summary} {items}',
               /* 'pager' => [
                    'options' => ['class' => 'pagination pagination-sm no-margin pull-right'],
                ],  */ 

            ]); ?>
            <div class= "box-footer clearfix">
                <?= \yii\widgets\LinkPager::widget([
                    'pagination' => $dataProvider->pagination,
                    'options' => ['class' =>'pagination pagination-sm no-margin pull-right']
                ]); ?>
            </div>
            <?php Pjax::end(); ?>            
        </div><!-- /.box-->        
    </div>
</div>
<?php
    Modal::begin([
        'header' => '<h3>'. Yii::t('backend/modules/customer','Add new customer').'</h3>',
        'id' => 'modal',
        'size' => 'modal-md',
        'options' => ['class' => 'modal'],       
    ]);

    echo '<div id="modal-content"></div>';    
    Modal::end();    
?>
