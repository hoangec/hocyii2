<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Typeahead;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model backend\modules\item\ItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?php 
        $name = "tes";
        $description = "desc";
        $template = '<div><p class="repo-language"><b>{{value}}</b></p>' .
        '<p class="repo-name">{{price}}</p></div>' ;
    ?>    
    <?= $form->field($model, 'id')->widget(Typeahead::classname(),[
        'options' => ['placeholder' => 'Filter as you type ...'],
        'pluginOptions' => ['highlight'=>true],
        'dataset' => [
           [
                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                'local' => $itemList,
                'display' => 'value',   
                'templates' => 
                [
                    'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                ]             
           ],
           [
                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('price')",
                'local' => $itemList,
                'display' => 'price',        
                'templates' => 
                 [
                   'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                 ]             
           ],           
        ],
        'pluginEvents'=>[
             "typeahead:select" => "onItemAutoComplateSelected",
        ],
    ])->label(false); ?>

    <?php ActiveForm::end(); ?>

</div>
