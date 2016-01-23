<?php

namespace backend\modules\customer\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "customer_statement_account".
 *
 * @property string $id
 * @property string $transaction_code
 * @property double $credit
 * @property double $debit
 * @property string $transaction_ref
 * @property integer $transaction_type
 * @property string $transaction_date
 * @property string $created_at
 * @property string $updated_at
 * @property string $created_by
 * @property string $updated_by
 * @property string $customer_id
 *
 * @property Customers $customer
 */
class CustomerStatementAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer_statement_account';
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
            [['credit', 'debit'], 'number'],
            [['transaction_type', 'created_by', 'updated_by', 'customer_id'], 'integer'],
            [['transaction_date', 'created_at', 'updated_at'], 'safe'],
            [['transaction_code', 'transaction_ref'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend\modules\invoice', 'ID'),
            'transaction_code' => Yii::t('backend\modules\invoice', 'Transaction Code'),
            'credit' => Yii::t('backend\modules\invoice', 'Credit'),
            'debit' => Yii::t('backend\modules\invoice', 'Debit'),
            'transaction_ref' => Yii::t('backend\modules\invoice', 'Transaction Ref'),
            'transaction_type' => Yii::t('backend\modules\invoice', 'Transaction Type'),
            'transaction_date' => Yii::t('backend\modules\invoice', 'Transaction Date'),
            'created_at' => Yii::t('backend\modules\invoice', 'Created At'),
            'updated_at' => Yii::t('backend\modules\invoice', 'Updated At'),
            'created_by' => Yii::t('backend\modules\invoice', 'Created By'),
            'updated_by' => Yii::t('backend\modules\invoice', 'Updated By'),
            'customer_id' => Yii::t('backend\modules\invoice', 'Customer ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customers::className(), ['id' => 'customer_id']);
    }
}
