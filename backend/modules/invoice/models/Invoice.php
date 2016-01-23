<?php

namespace backend\modules\invoice\models;

use Yii;
use backend\modules\customer\models\Customer;
use backend\modules\item\models\Item;
use yii\helpers\JSON;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "invoice".
 *
 * @property string $id
 * @property string $invoice_number
 * @property string $invoice_time
 * @property string $subtotal
 * @property string $customer_id
 * @property string $comment
 * @property string $attribute1
 * @property Customers $customer
 * @property Customers $total_price
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoices';
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
            [['invoice_number', 'customer_id'], 'required'],
            [['invoice_time'], 'safe'],
            [['customer_id'], 'integer'],
            [['comment'], 'string'],
            [['invoice_number'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend\modules\invoice', 'ID'),
            'invoice_number' => Yii::t('backend\modules\invoice', 'Invoice Number'),
            'invoice_time' => Yii::t('backend\modules\invoice', 'Invoice Time'),
            'customer_id' => Yii::t('backend\modules\invoice', 'Customer ID'),
            'comment' => Yii::t('backend\modules\invoice', 'Comment'),
            'customerName' =>Yii::t('backend\modules\invoice', 'Customer Name'),
            'customerAddress' =>Yii::t('backend\modules\invoice', 'Customer Address'),
            'customerPhone' =>Yii::t('backend\modules\invoice', 'Customer Phone'),
            'customerTaxNumber' =>Yii::t('backend\modules\invoice', 'Tax Number'),
            'customerBankAccount' =>Yii::t('backend\modules\invoice', 'Bank Account'),
            'invoiceLink' => Yii::t('backend\modules\invoice', 'Invoice Number'),
            'total_price' => Yii::t('backend\modules\invoice', 'Total price')
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['id' => 'item_id'])->viaTable('invoices_items',['invoice_id'=>'id']);
    }

    /**
    * Get customer Name form attribute col with JSON Format
    */
    public function getCustomerName(){
        $attributeCustomer = JSON::decode($this->attribute1);
        return isset($attributeCustomer['customer_name']) ? $attributeCustomer['customer_name'] : '';
    }

    /**
    * Get customer Adderss form attribute col with JSON Format
    */
    public function getCustomerAddress(){
        $attributeCustomer = JSON::decode($this->attribute1);
        return isset($attributeCustomer['address']) ? $attributeCustomer['address'] : '';
    }

    /**
    * Get customer Phone form attribute col with JSON Format
    */
    public function getCustomerPhone(){
        $attributeCustomer = JSON::decode($this->attribute1);
        return isset($attributeCustomer['phone_number']) ? $attributeCustomer['phone_number'] : '';
    }

    /**
    * Get customer Tax number form attribute col with JSON Format
    */
    public function getCustomerTaxNumber(){
        $attributeCustomer = JSON::decode($this->attribute1);
        return isset($attributeCustomer['tax_no']) ? $attributeCustomer['tax_no'] : '';
    }

    /**
    * Get customer Bank Account form attribute col with JSON Format
    */
    public function getCustomerBankAccount(){
        $attributeCustomer = JSON::decode($this->attribute1);
        return isset($attributeCustomer['bank_account']) ? $attributeCustomer['bank_account'] : '';
    }

    /**
    * Get Invoice detail links
    */
    public function getInvoiceLink(){
        $url = URL::to(['/invoice/invoice/view','id' => $this->id]);
        $options = [];
        return Html::a($this->invoice_number,$url,$options);
    }

    /*
    * get total price form input
    * Input: array of invoice active record objects
    */
    public static function getRevenuesFormInvoiceList($invoiceList,$currencyFormat = true){
        $result = 0;
        foreach($invoiceList as $invoice){
            $result +=  $invoice->total_price;
        }
        if($currencyFormat){
            return yii::$app->formatter->asCurrency($result);
        }
        return $result;
    }
}
