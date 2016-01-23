<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\customer\models\CustomerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-search">

  <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'form-inline'],
    ]); ?> 

<!--     <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'customer_code') ?>

    <?= $form->field($model, 'customer_name') ?>

    <?= $form->field($model, 'gender')->checkbox() ?>

    <?= $form->field($model, 'customer_type')->checkbox() ?>

    <?php // echo $form->field($model, 'birthday') ?>

    <?php // echo $form->field($model, 'phone_number') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?> -->
    <div class="form-group row" style="width:100%">
        <div class="col-md-6">        
            <input value="<?php echo $model->specialQuery_input ;?>" id = "customersearch-customer_name" name="CustomerSearch[specialQuery_input]" style="width:100%" type="text" class="form-control" placeholder="<?= Yii::t('backend/modules/customer','Customer code OR Customer name OR Customer phone number') ?>">
        </div>
        <div class="col-md-2">
            <select class="form-control" style="width:100%" name="CustomerSearch[specialQuery_options]">            
              <option value="1" <?= $model->specialQuery_options == 1 ? 'selected' : '' ?> ><?= Yii::t('backend/modules/customer','All') ?></option>
              <option value="2" <?= $model->specialQuery_options == 2 ? 'selected' : '' ?> ><?= Yii::t('backend/modules/customer','Debit') ?></option>
              <option value="3" <?= $model->specialQuery_options == 3 ? 'selected' : '' ?>><?= Yii::t('backend/modules/customer','Wholesale') ?></option>
              <option value="4" <?= $model->specialQuery_options == 4 ? 'selected' : '' ?>><?= Yii::t('backend/modules/customer','Retail') ?></option>          
            </select>
        </div>
        <div class ="col-md-4">
            <?= Html::submitButton(Yii::t('backend/modules/customer','Search'), ['class' => 'btn btn-primary']) ?>   
            <?= Html::resetButton( Yii::t('backend/modules/customer','Reset'), ['class' => 'btn btn-default']) ?> 
        </div>        
    </div>      
   
<!--     <div class="form-group">      
      
        
    </div> -->

<?php ActiveForm::end(); ?> 

</div>
