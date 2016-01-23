<?php

namespace backend\modules\item\models;

use Yii;
use backend\modules\invoice\models\Invoice;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
/**
 * This is the model class for table "items".
 *
 * @property string $id
 * @property string $product_name
 * @property double $price
 * @property string $created_at
 * @property string $updated_at
 * @property string $created_by
 * @property string $updated_by
 *
 * @property InvoicesItems[] $invoicesItems
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items';
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
            [['product_name', 'price'], 'required'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['product_name', 'created_by', 'updated_by'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend\modules\invoice', 'ID'),
            'product_name' => Yii::t('backend\modules\invoice', 'Product Name'),
            'price' => Yii::t('backend\modules\invoice', 'Price'),
            'created_at' => Yii::t('backend\modules\invoice', 'Created At'),
            'updated_at' => Yii::t('backend\modules\invoice', 'Updated At'),
            'created_by' => Yii::t('backend\modules\invoice', 'Created By'),
            'updated_by' => Yii::t('backend\modules\invoice', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {        
        return $this->hasMany(Invoice::className(), ['id' => 'invoice_id'])->viaTable('invoices_items',['item_id'=>'id']);
    }
}
