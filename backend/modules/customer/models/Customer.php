<?php

namespace backend\modules\customer\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\modules\invoice\models\Invoice;
/**
 * This is the model class for table "customers".
 *
 * @property string $id
 * @property string $customer_code
 * @property string $customer_name
 * @property boolean $gender
 * @property boolean $customer_type
 * @property string $birthday
 * @property string $phone_number
 * @property string $email
 * @property string $address
 * @property string $remarks
 * @property string $disable_status
 * @property string $last_order
 * @property string $debit
 * @property string $tax_no
 * @property string $bank_account
 * @property string $created_at
 * @property string $updated_at
 */
class Customer extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customers';
    }
      /**
     * @inheritdoc
     */
    public function behaviors(){
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                 'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['customer_name', 'required'],
            ['customer_code','unique'],
            [['gender','customer_type'], 'boolean'],   
            [['phone_number','disable_status','tax_no','bank_account', 'created_at', 'updated_at'], 'safe'],  
            ['birthday','date','format'=> 'php:Y-m-d'],
            ['email','filter','filter' =>'trim'],
            ['email','email'],
            //['phone_number','number'],
            [['customer_code', 'customer_name', 'address', 'remarks'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_code' =>  Yii::t('backend/modules/customer','Customer code'),
            'customer_name' =>  Yii::t('backend/modules/customer','Customer name'),
            'gender' => Yii::t('backend/modules/customer','Gender'),
            'customer_type' => Yii::t('backend/modules/customer','Customer type'),
            'birthday' => Yii::t('backend/modules/customer','Birtday'),
            'phone_number' => Yii::t('backend/modules/customer','Phone number'),
            'email' => Yii::t('backend/modules/customer','Email'),
            'address' => Yii::t('backend/modules/customer','Address'),
            'remarks' => Yii::t('backend/modules/customer','Remarks'),
            'last_order' => Yii::t('backend/modules/customer','Last order'),
            'debit' => Yii::t('backend/modules/customer','Debit'),
            'tax_no' => Yii::t('backend/modules/customer','Tax No'),
            'bank_account' => Yii::t('backend/modules/customer','Bank Account'),
            'created_at' => 'Create At',
            'updated_at' => 'Update At',            
            'customerCodeLink' => 'Customer Code',
            'customerNameLink' => 'Customer Name',
            'customerTypeName' => 'Customer Type',
            'disable_status' => Yii::t('backend/modules/customer','Disable ?'),
        ];
    }

    /*
    * @inheritdoc
    */
    public function attributeHints(){
        return [
            'phone_number' => Yii::t('backend/modules/customer','Phone numer seperated by commas'),
            'bank_account' => Yii::t('backend/modules/customer','Bank account seperated by commas'),
        ];
    }
    /**
    * Get the the links on customer code, used for girdview in UI
    */
    public function getCustomerCodeLink(){
        $url = URL::to(['customer/view','id' => $this->id]);
        $options = [];
        return Html::a($this->customer_code,$url,$options);
    }

    /**
    * Get the the links on customer name, used for girdview in UI
    */
    public function getCustomerNameLink(){
        $url = URL::to(['customer/view','id' => $this->id]);
        $options = [];
        return Html::a($this->customer_name,$url,$options);
    }

    /**
    * Get gender name for view
    */
    public function getGenderName(){
        return $this->gender == 0 ? yii::t('backend\modules\customer','Female') : yii::t('backend\modules\customer','Male');
    }
    /**
    * Get gender list for view
    */
    public function getCustomerGenderList(){
        return ['0' => yii::t('backend\modules\customer','Female'),'1'=>yii::t('backend\modules\customer','Male')];
    }
    /**
    * Get customer type name    
    */
    public function getCustomerTypeName(){
        return $this->customer_type == 0 ? Yii::t('backend/modules/customer','Retail') : Yii::t('backend/modules/customer','Wholesale');
    }

    /**
    * Get customer type list    
    */
    public function getCustomerTypeList(){
        return [
            '0' => Yii::t('backend/modules/customer','Retail'),
            '1' => Yii::t('backend/modules/customer','Wholesale')
        ];
    }

    /**
    * Get currency format    
    */
    public function getDebitCurrency(){
        return Yii::$app->formatter->asCurrency($this->debit);
    }

    /**
    * Get Phone number formatted by label tag to make VIEW nicely
    */
    public function getPhoneNumberListFormatted(){
        $arrayPhoneList = explode(',',$this->phone_number);            
        $result = '';
        foreach($arrayPhoneList as $phone){
            $result .= '<span class="label label-default" >' . $phone . '</span>';
        }             
        return $result;
    }
    /**
    * Get Bank account formatted by label tag to make VIEW nicely
    */
    public function getBankAccountListFormatted(){
        $arrayBankAccountList = explode(',',$this->bank_account);            
        $result = '';
        foreach($arrayBankAccountList as $account){
            $result .= '<span class="label label-warning">' . strtoupper($account) . '</span>';
        }             
        return $result;
    }
    /**
    * Get Tax number formatted by label tag to make VIEW nicely
    */
    public function getTaxNumberFormatted(){
        return '<span class="label label-success ">' . strtoupper($this->tax_no) . '</span>';
    }
    /**
    * Get customer code formatted by label tag to make VIEW nicely
    */
    public function getCustomerCodeFormatted(){
        return '<kbd>'. strtoupper($this->customer_code) . '</kbd>';
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getInvoices(){
         return $this->hasMany(Invoice::className(),['customer_id'=>'id']);
    }
}
