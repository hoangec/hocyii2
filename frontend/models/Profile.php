<?php

namespace frontend\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\db\ActiveRecord;
use common\models\User;

/**
 * This is the model class for table "profile".
 *
 * @property string $id
 * @property string $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $birthday
 * @property string $gender_id
 * @property string $create_at
 * @property string $updated_at
 *
 * @property Gender $gender
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
    * behaviors to control time stamp
    **/

    public function behaviors(){
        return [
            'timestamp' =>[
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' =>[
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_at','update_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['update_at'],
                ],
                'value' => new Expression('NOW()')
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'gender_id'], 'required'],
            [['gender_id'],'in','range' => $this->getGenderList()],
            [['user_id', 'gender_id'], 'integer'],
            [['first_name', 'last_name'], 'string'],
            [['birthday', 'create_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'birthday' => 'Birthday',
            'gender_id' => 'Gender ID',
            'create_at' => 'Create At',
            'updated_at' => 'Updated At',
            'genderName' => Yii::t('app', 'Gender'),
            'userLink' => Yii::t('app', 'User'),
            'profileIdLink' => Yii::t('app', 'Profile'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender_id']);
    }

    /**
    * get gender name
    */

    public function getGenderName(){
        return $this->gender->gender_name;
    }

    /**
    * get gender list
    */
    public function getGenderList(){
       $droptions = Gender::find()->asArray()->all();
       return ArrayHelper::map($droptions,'id','gender_name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
    * get user name
    */

    public function getUserName(){
        return $this->user->username;
    }

    /**
    * get user id
    */

    public function getUserid(){
        return $this->user ? $this->user->id : 'none';
    }

    /**
    * get user link
    */
    public function getUserLink(){
       $url = URL::to(['user/view','id' => $this->user->id]);
       $options = [];
       return Html::a($this->getUserName(),$url,$options);
    }

    /**
    * get user profile
    */
    public function getProfileIdLink(){
       $url = URL::to(['profile/update','id' => $this->id]);
       $options = [];
       return Html::a($this->id,$url,$options);
    }

}
