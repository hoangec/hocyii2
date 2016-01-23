<?php

namespace backend\modules\invoice\controllers;

use yii\web\Controller;
use backend\modules\invoice\models\Invoice;
class DefaultController extends Controller
{
    public function actionIndex()
    {
        //return $this->render('index');
        $model = Invoice::findOne(1);

        echo 'fdsaf';
        echo "<pre>";
        print_r(Invoice::className());
        echo "</pre>";
    }
}
