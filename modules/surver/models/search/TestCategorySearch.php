<?php

namespace app\modules\surver\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\surver\models\TestCategory;
use yii\db\ActiveRecord;


/**
 * TestCategorySearch represents the model behind the search form of `app\modules\surver\models\TestCategory`.
 * Class TestCategorySearch
 * @package app\modules\surver\models\search
 */
class TestCategorySearch extends TestCategory
{
    /**
     * @property  $creator
     */
    public $creator;
    /**
     * @property $updater
     */
    public $updater;
    /**
     * @property $statusName
     */
    public $statusName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['name', 'description', 'creator', 'updater', 'statusName'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = TestCategory::find()->joinWith(['creator']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        /** Класс User для корректного определения таблицы */
        /** @var ActiveRecord $class */
        $class = Yii::$app->user->identityClass;
        $user_table = $class::tableName();

        $dataProvider->sort->attributes['creator'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => [$user_table . '.username' => SORT_ASC],
            'desc' => [$user_table . '.username' => SORT_DESC],
        ];
        // Lets do the same with country now
        $dataProvider->sort->attributes['updater'] = [
            'asc' => [$user_table . '.username' => SORT_ASC],
            'desc' => [$user_table . '.username' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['statusName'] = [
            'asc' => ['status' => SORT_ASC],
            'desc' => ['status' => SORT_DESC],
        ];
        // No search? Then return data Provider
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            self::tableName() . '.created_at' => $this->created_at,
            self::tableName() . '.updated_at' => $this->updated_at,
            self::tableName() . '.status' => $this->statusName
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', $user_table . '.username', $this->creator])
            ->andFilterWhere(['like', $user_table . '.username', $this->updater]);


        return $dataProvider;
    }
}
