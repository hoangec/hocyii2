<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
use kartik\widgets\Alert;
use kartik\datecontrol\DateControl;
/* @var $this yii\web\View */
/* @var $model backend\modules\customer\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>
<div id="customer-create-form-message"></div>
<?php $test= Alert::widget(['delay'=>false, 'body'=>'message','options'=>['id'=>'customer-create-alert'], 'type'=>Alert::TYPE_WARNING]);?>
<div class="customer-form">

    <?php 
        $form = ActiveForm::begin([
            'validationUrl' => URL::to(['customer/checkcustomeruniquecode']),
            'options' => [
                'id' => 'create-customer-form'
            ]
        ]);
    ?>
    <div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true])?>
    </div>
    <div class="col-md-6"> 
        <?= $form->field($model, 'customer_code',[
          'enableAjaxValidation' => true,         
        ])->textInput(['maxlength' => true,'placeholder' => yii::t('backend\modules\customer','Leave empty lines in generated code')]) ?>
    </div>
    <div class="col-md-6">
      <?php 
        $genderName = ['0' => yii::t('backend\modules\customer','Female'),'1'=>yii::t('backend\modules\customer','Male')];
        $model->gender = 0;
      ?>    
      <?= $form->field($model, 'gender')->radioList($genderName, [
            'inline' => 'true',         
            
        ]); ?>
    </div>    
    <div class="col-md-6">
      <?= $form->field($model, 'customer_type')->dropDownList($model->getCustomerTypeList()) ?>      
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'birthday')->widget(
             DateControl::classname(),
             [
               'type'=>DateControl::FORMAT_DATE,
               'ajaxConversion'=>false,
               'options' => [
                'pluginOptions' => [
                'autoclose' => true
               ]
             ]
        ]) ?> 
  </div>
  <div class="col-md-6">
    <?= $form->field($model, 'phone_number',['addon' => ['prepend'=>['content'=>'<i class="glyphicon glyphicon-phone"></i>']]])->textInput(['maxlength' => true]) ?>
  </div>
  <div class="col-md-6">
    <?=$form->field($model, 'email', ['addon' => ['prepend' => ['content'=>'@']]]);?>
  </div>
  <div class="col-md-6">
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
  </div>
  <div class="col-md-12">
   <?= $form->field($model, 'remarks')->textArea() ?>
  </div>
  </div>
  <div class="modal-footer">
      <div class="form-group">
        <?= Html::submitButton(yii::t('backend\modules\customer','Save'), ['id'=>'btnCusFormSaveAndCont','class' => 'btn btn-primary']) ?>        
    </div>
  </div>
<?php ActiveForm::end(); ?>
</div>


<?php 
$message = yii::t('backend\modules\customer','Success create customer with ID: ');
$script = <<< JS
    //$('#customer-create-alert').hide();
    $('form#create-customer-form').on('beforeSubmit',function(e){
        var \$form = $(this);
        $.post(
             \$form.attr("action"),
             \$form.serialize()
         ).done(function(result){
             if(result.status == 1){       
                 $(\$form).trigger('reset');
                $('#customer-create-form-message').html('<div class="alert alert-success">' + '$message' + result.message +'</div>').fadeTo(2000, 500).slideUp(500, function(){
                     $("#customer-create-alert").fadeOut(500);
                 });
                 $.pjax.reload({container:'#customer-grid'});
             }else{
                 $('#customer-create-form-message').html('<div class="alert alert-danger">' + '$message' + result.message +'</div>').fadeTo(2000, 500).slideUp(500, function(){
                     $("#customer-create-alert").fadeOut(500);
                 });
             }
         }).fail(function(){
             
         });


        return false;
    });
JS;
$this->registerJs($script);
?>