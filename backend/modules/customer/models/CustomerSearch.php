<?php

namespace backend\modules\customer\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\customer\models\Customer;
use yii\helpers\ArrayHelper;
/**
 * CustomerSearch represents the model behind the search form about `backend\modules\customer\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * @inheritdoc
     */

    public $specialQuery_input;
    public $specialQuery_options;
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['customer_code', 'customer_name', 'birthday', 'phone_number', 'email', 'address', 'remarks', 'specialQuery_input','specialQuery_options','created_at', 'updated_at'], 'safe'],
            [['gender', 'customer_type'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Customer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>[
                'pageSize' =>10,
            ]
        ]);

/*        $dataProvider->setSort([
            'attributes' =>[
                'customerCodeLink'=>[
                    'asc' => ['customer_code' => SORT_ASC],
                    'desc' => ['customer_code' => SORT_DESC],
                ],
                'customerNameLink'=>[
                    'asc' => ['customer_name' => SORT_ASC],
                    'desc' => ['customer_name' => SORT_DESC],
                ],
            ],
        ]);*/
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

/*        $query->andFilterWhere([
            'id' => $this->id,
            'gender' => $this->gender,
            'customer_type' => $this->customer_type,
            'birthday' => $this->birthday,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ]);*/

        if(isset($this->specialQuery_input) && isset($this->specialQuery_options)){           
            $query->andFilterWhere(['like', 'customer_code', $this->specialQuery_input])
                 ->orFilterWhere(['like', 'customer_name', $this->specialQuery_input])
                 ->orFilterWhere(['like', 'phone_number', $this->specialQuery_input]);
            if($this->specialQuery_options == 2){
                $query->andFilterWhere(['>','debit',0]);
            }
            if($this->specialQuery_options == 3){
                $query->andFilterWhere(['=','customer_type','1']);
            }
            if($this->specialQuery_options == 4){
                $query->andFilterWhere(['=','customer_type','0']);
            }
        }else{

            $query->andFilterWhere(['like', 'customer_code', $this->customer_code])               
                ->andFilterWhere(['like', 'customer_name', $this->customer_name])            
                ->andFilterWhere(['=', 'customer_type', $this->customer_type])  
                ->andFilterWhere(['like', 'phone_number', $this->phone_number]);   
        }
        

        return $dataProvider;
    }

    private function searchpatternToArray($pattern){

    }
}
