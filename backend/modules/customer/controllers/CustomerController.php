<?php

namespace backend\modules\customer\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
//use yii\web\InvalidCallException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\Json;
use kartik\widgets\ActiveForm;

use backend\modules\invoice\models\Invoice;
use backend\modules\invoice\models\InvoiceSearch;
use backend\modules\customer\models\Customer;
use backend\modules\customer\models\CustomerSearch;
use yii\web\Response;
/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','view','create','update','delete','checkcustomeruniquecode'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);     

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);

        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(['InvoiceSearch'=>['customer_id'=>$id]]);
        $extraInfor = [
            'revenues' => Invoice::getRevenuesFormInvoiceList($dataProvider->getModels()),
            'transactionCount' => $dataProvider->getTotalCount(),
            'debit' => $model->getDebitCurrency(),
        ];
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          Yii::$app->session->setFlash('kv-detail-success', yii::t('backend/modules/customer','Saved record successfully'));
            // Multiple alerts can be set like below
           // Yii::$app->session->setFlash('kv-detail-warning', 'A last warning for completing all data.');
           // Yii::$app->session->setFlash('kv-detail-info', '<b>Note:</b> You can proceed by clicking <a href="#">this link</a>.');
            return $this->redirect(['view', 'id'=>$model->id]);
        } else {
            return $this->render('view', [
                'model'=>$model,
                'dataProvider' => $dataProvider,
                'searchModel'=>$searchModel,
                'extraInfor' => $extraInfor,
            ]);
        }
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Customer();
        if ($model->load(Yii::$app->request->post())) {  

            if($model->save()){                
                //return $this->redirect(['view', 'id' => $model->id]); 
                Yii::$app->response->format = Response::FORMAT_JSON;
                $result = ['status'=>"1",'message'=>$model->id];
                return $result;
            }else{
                Yii::$app->response->format = Response::FORMAT_JSON;
                $result = ['status'=>"0",'message'=>'error'];
                return $result;
            }
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } elseif(Yii::$app->request->isAjax){
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
    *Check customer code is unique // use with Active form and field ajax validation
    */
    public function actionCheckcustomeruniquecode(){      
        if (Yii::$app->request->isAjax) {
            $model = new Customer();
            if($model->load(Yii::$app->request->post())){
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }                    
        }else{
            throw new NotFoundHttpException();
        }

    }



    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
       $post = Yii::$app->request->post();
       if (Yii::$app->request->isAjax && isset($post['custom_param'])) {
           $id = $post['id'];
           $model = $this->findModel($id);
           $customer_code = $model->customer_code;
           if (true) {
               echo Json::encode([
                   'success' => true,
                   'messages' => [
                       'kv-detail-info' => Yii::t('backend\modules\customer','Customer code') .' # ' . $customer_code . yii::t('backend\modules\customer',' was successfully deleted '). '<a href="' . 
                           Url::to(['/customer']) . '" class="btn btn-sm btn-info">' .
                           '<i class="glyphicon glyphicon-hand-right"></i>' . Yii::t('backend\modules\customer',' Click here</a> to proceed.')
                   ]
               ]);
           } else {
               echo Json::encode([
                   'success' => false,
                   'messages' => [
                       'kv-detail-error' => 'Cannot delete the book # ' . $id . '.'
                   ]
               ]);
           }
           return;
       }
       //throw new InvalidCallException("You are not allowed to do this operation. Contact the administrator.");       
       return 'safd';
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
