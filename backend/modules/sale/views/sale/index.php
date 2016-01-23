
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\Typeahead;
use kartik\widgets\TouchSpin;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\customer\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-9">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Bordered Table</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-8">
                        <?php /*echo '<pre>' . print_r($itemSeacrhModel) . '</pre>' */ ?>
                        <?= $this->render('@app/modules/item/views/item/_search',['model'=>$itemSeacrhModel,'itemList'=>$itemList]); ?>

                    </div>
                    <div class="col-md-4"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="pull-left header"><i class="fa fa-th"></i> Invoices</li>
                                <li class="active">
                                    <a href="#tab_1" data-toggle="tab" aria-expended="true">#1</a>
                                </li>
                                 <li>
                                    <a href="#tab_2" data-toggle="tab" aria-expended="true">#2</a>
                                </li>

                                <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-minus"></i></a></li>
                                <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-plus"></i></a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <table id="sale-item-list-1" class="table table-bordered table-responsive">
                                        <tbody>
                                            <tr>
                                              <th >#</th>
                                              <th>Product Name</th>
                                              <th>Quantity</th>
                                              <th>Price</th>
                                              <th>Discount</th>
                                              <th >Thanh tien</th>
                                              <th>Action</th>
                                            </tr>                         
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane " id="tab_2">
                                   <table id="sale-item-list-2" class="table table-bordered table-responsive">
                                       <tbody>
                                           <tr>
                                             <th >#</th>
                                             <th>Product Name</th>
                                             <th>Quantity</th>
                                             <th>Price</th>
                                             <th>Discount</th>
                                             <th >Thanh tien</th>
                                             <th>Action</th>
                                           </tr>                         
                                       </tbody>
                                   </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
            </div>
        </div>
    </div>
    <div class="col-md-3">
       <div class="box box-success direct-chat direct-chat-success">
           <div class="box-header with-border">
             <h3 class="box-title">Direct Chat</h3>
             <div class="box-tools pull-right">
               <span data-toggle="tooltip" title="" class="badge bg-green" data-original-title="3 New Messages">3</span>
               <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
               <button class="btn btn-box-tool" data-toggle="tooltip" title="" data-widget="chat-pane-toggle" data-original-title="Contacts"><i class="fa fa-comments"></i></button>
               <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
             </div>
           </div><!-- /.box-header -->
           <div class="box-body">
            <?= TouchSpin::widget([
                'name' => 't6',
                'pluginOptions' => ['verticalbuttons' => true]
            ]);?>
           </div> <!-- /.box-body-->           
           <div class="box-footer">
            
           </div><!-- /.box-footer-->           
        </div>
        <div class="box box-success direct-chat direct-chat-success">
            <div class="box-header with-border">
              <h3 class="box-title"Hoa don</h3>
              <div class="box-tools pull-right">
                <span data-toggle="tooltip" title="" class="badge bg-green" data-original-title="3 New Messages">3</span>
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-toggle="tooltip" title="" data-widget="chat-pane-toggle" data-original-title="Contacts"><i class="fa fa-comments"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div><!-- /.box-header -->
            <div class="box-body">
            </div> <!-- /.box-body-->           
            <div class="box-footer">
                <input type="button" class="btn btn-primary" id="btnCheckout" name="Thanh toan" value="Thanh toan">
            </div><!-- /.box-footer-->           
         </div> 
    </div>
</div>
