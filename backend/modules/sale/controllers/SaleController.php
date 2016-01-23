<?php

namespace backend\modules\sale\controllers;

use yii\web\Controller;
use yii\helpers\JSON;
use backend\modules\item\models\Item;
use backend\modules\item\models\ItemSearch;

class SaleController extends Controller
{
    public function actionIndex()
    {
    	//echo '<pre>' . print_r($this) . '</pre>';
    	$itemSeacrhModel = new ItemSearch();
    	$dataProvider = $itemSeacrhModel->search('');
    	$itemList = $dataProvider->getModels();
    	$jsonItemList = [];
    	foreach($itemList as $item){
    		$jsonItemList[] = [
    			'value'=>$item->product_name,
    			'price'=>$item->price,
    			'product_id'=>$item->id,
    		];
    	}
        return $this->render('index',[
        	'itemSeacrhModel'=> $itemSeacrhModel,
        	'dataProvider' => $dataProvider,
        	'itemList' => $jsonItemList,
        ]);
    }


    public function afterAction(){
    	
    }
}
