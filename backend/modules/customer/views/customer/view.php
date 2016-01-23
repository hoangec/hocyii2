<?php
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\widgets\SwitchInput;
//use kartik\form\ActiveField;

use yii\helpers\Html;
use yii\helpers\url;
use yii\helpers\Json;

//use yii\widgets\DetailView;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model backend\modules\customer\models\Customer */

$this->title = $model->customer_name;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Detail View';

?>



<div class="customer-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
<!-- 
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p> -->

    <?php /* DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'customer_code',
            'customer_name',
            'gender:boolean',
            'customer_type:boolean',
            'birthday',
            'phone_number',
            'email:email',
            'address',
            'remarks',
            'created_at',
            'updated_at',
        ],
    ]) */?>
    <?php 
    $attributes = [
        [
            'columns'=>
            [
                ['attribute' => 'customer_name','valueColOptions'=>['style'=>'width:30%']],
                [
                    'attribute' => 'customer_code',
                    'format' => 'raw',
                    'value'=> $model->getCustomerCodeFormatted(),
                    'valueColOptions'=>['style'=>'width:30%']
                ],
            ]
        ],
        [
            'columns' =>
            [
                [
                    'attribute' => 'gender',
                    'type'=>DetailView::INPUT_RADIO_LIST,
                    'items' => $model->getCustomerGenderList(),
                    'value' => $model->getGenderName(),   
                    'valueColOptions'=>['style'=>'width:30%']           
                ],
                [
                    'attribute' => 'customer_type',
                    'type' => DetailView::INPUT_DROPDOWN_LIST,
                    'items' => $model->getCustomerTypeList(),
                    'value' => $model->getCustomerTypeName(),                    
                    'valueColOptions'=>['style'=>'width:30%']
                ],
            ]
        ],
        [
            'attribute' => 'birthday',
            'format' =>['date'],
            'type'=>DetailView::INPUT_WIDGET,
            'widgetOptions' => [
                'class'=>DateControl::classname(),
                'type'=>DateControl::FORMAT_DATE,
            ],
            'valueColOptions'=>['style'=>'width:30%']
        ],
        [
            'attribute' => 'phone_number',
            'format' => 'raw',
            'value'=> $model->getPhoneNumberListFormatted(),
            'valueColOptions'=>['style'=>'width:30%'],                    
            //'type' => DetailView::INPUT_WIDGET,                    
            'fieldConfig' => [
                'hintType' => 1,    
                'hintSettings' => [
                        'showIcon' => false,
                        'title' => '<i class="glyphicon glyphicon-info-sign"></i> Note'
                    ]
            ],
        ],
        [
            'columns'=>
            [
                [
                    'attribute' => 'email',
                    'format' =>'email',                                    
                    'valueColOptions'=>['style'=>'width:30%']
                ],
                ['attribute' => 'address','valueColOptions'=>['style'=>'width:30%']],
            ]
        ],
        [
            'attribute' => 'tax_no',                                                    
            'format' =>'raw',
            'value'=>$model->getTaxNumberFormatted(),
            'inputWidth' => '37%',            
        ],
        [
            'attribute' => 'bank_account',
            //'valueColOptions'=>['style'=>'width:30%']
            'format' => 'raw',
            'value'=> $model->getBankAccountListFormatted(),
        ],
        [
            'columns'=>
            [
                [
                    'attribute' => 'last_order',                                                    
                    'format' =>'date',
                    'type'=>DetailView::INPUT_DATE,
                    'valueColOptions'=>['style'=>'width:30%'],
                    'displayOnly' => true,
                ],
                ['attribute' => 'debit','format'=>'currency','valueColOptions'=>['style'=>'width:30%'],'displayOnly'=>true],
            ]
        ],
        [
            'attribute' => 'disable_status',
            'type'=>DetailView::INPUT_SWITCH,
            'format' => 'raw',
            'value'=> $model->disable_status ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>',
            'widgetOptions' => [
                'pluginOptions' => [
                    'onText' => 'Yes',
                    'offText' => 'No',
                ]
            ],

        ],
        ['attribute' => 'remarks','type'=>DetailView::INPUT_TEXTAREA,'valueColOptions'=>['style'=>'width:100%']],
    ];
    ?>    
    <?php
        // create disable customer button on header with button1 option in Detailview Widgets
        $btnDisableCustomer = Html::button('<i class="fa fa-stop-circle"></i>',
            [
                'id' => "cus-disable-btn",
                'class'=>'kv-action-btn',
                'data-toggle'=>"tooltip", 
                'title'=> yii::t('backend\modules\customer','Disable'),
            ]);
    ?>
    <?= DetailView::widget([
            'model' => $model,
            'fadeDelay' => 200,
            'condensed'=>true,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
           'panel'=>[
                'heading'=>yii::t('backend\modules\customer','Customer: #') . $model->customer_code,
               'type'=>DetailView::TYPE_PRIMARY,
            ],            
            'formClass' =>'kartik\widgets\ActiveForm',
            'buttons1' => '{update}'.$btnDisableCustomer,
            'attributes'=>$attributes,            
            'deleteOptions'=>[ // your ajax delete parameters
                'url' => ['delete'],
                'params' => 
                [
                    'id' => $model->id, 
                    'custom_param' => true,                      
                ],
                //'ajaxSettings'=>['success'=>$js]  
            ],
        ])
    ?>

</div>

<div class="row">    
    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-usd"></i></span>
            <div class="info-box-content">
              <span class="info-box-text"><?= Yii::t('backend\modules\customer','Revenues')?></span>
              <span class="info-box-number"><?=$extraInfor['revenues']?></span>
            </div><!-- /.info-box-content -->
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-exchange"></i></span>
            <div class="info-box-content">
              <span class="info-box-text"><?= Yii::t('backend\modules\customer','Transctions count')?></span>
              <span class="info-box-number"><?= $extraInfor['transactionCount']?></span>
            </div><!-- /.info-box-content -->
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box ">
            <span class="info-box-icon bg-red"><i class="fa fa-exclamation-triangle"></i></span>
            <div class="info-box-content">
              <span class="info-box-text"><?= Yii::t('backend\modules\customer','Debit')?></span>
              <span class="info-box-number"><?= $extraInfor['debit'] ?></span>
            </div><!-- /.info-box-content -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary box-solid">
            <div class="box-header with-border ">
              <h3 class="box-title"><?=yii::t('backend\modules\customer','Invoices history')?></h3>
            </div><!-- /.box-header -->
            <?= 
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns'=>[
                        'id',
                        [
                            'attribute'=>'invoice_number',
                            'format'=>'raw',
                            'value' => function($searchModel){
                                return $searchModel->getInvoiceLink();
                            }
                        ],
                        'invoice_time',
                        'subtotal',
                        'total_price',
                        [
                            'attribute' => 'customerName',
                        ],
                        [
                            'attribute' => 'customerAddress',
                        ],
                        [
                            'attribute' => 'customerPhone',
                        ],
                        [
                            'attribute' => 'customerTaxNumber',
                        ],
                        [
                            'attribute' => 'customerBankAccount',
                        ],
                    ],
                    'options' => [
                        'class' => 'box-body'
                    ],
                ]);
            ?>
            <div class= "box-footer clearfix">
                <?= \yii\widgets\LinkPager::widget([
                    'pagination' => $dataProvider->pagination,
                    'options' => ['class' =>'pagination pagination-sm no-margin pull-right']
                ]); ?>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
   /* $('#btn-customer-delete').click(function(e){
        e.preventDefault();
        var \$test = \$(this);
        console.log(\$test.attr('params'));
        $.post(
            \$test.attr("href"),
            {id:$model->id,'custom_param':true}
        ).done(function(result){
            if(result.success){

            }
        });
    });*/
    //Register ajax event after success to append process hide whrn ajax delete success
    $( document ).ajaxSuccess(function( event, request, settings ) {
      console.log(request);
      console.log(event);
    });
    $('#cus-disable-btn').click(function(e){
        console.log('da click');
    });
JS;
$this->registerJs($script);
?>
