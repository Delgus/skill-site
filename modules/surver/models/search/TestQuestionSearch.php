<?php

namespace app\modules\surver\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\surver\models\TestQuestion;
use app\modules\surver\models\Test;
use yii\db\ActiveRecord;

/**
 * TestQuestionSearch represents the model behind the search form of `app\modules\surver\models\TestQuestion`.
 * Class TestQuestionSearch
 * @package app\modules\surver\models\search
 */
class TestQuestionSearch extends TestQuestion
{
    /**
     * @var
     */
    public $creator;
    /**
     * @var
     */
    public $updater;
    /**
     * @var
     */
    public $typeName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'test_id','points'], 'integer'],
            [['name', 'description', 'creator', 'updater', 'test','type','typeName'], 'safe'],
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
     * @param $id
     *
     * @return ActiveDataProvider
     */
    public function search($params, $id)
    {
        $query = TestQuestion::find()->joinWith(['creator']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query->where(['test_question.test_id' => $id]),
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

         $dataProvider->sort->attributes['typeName'] = [
            'asc' => ['type' => SORT_ASC],
            'desc' => ['type' => SORT_DESC],
        ];

        // No search? Then return data Provider
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            self::tableName() . '.points' => $this->points,
            self::tableName() . '.created_at' => $this->created_at,
            self::tableName() . '.updated_at' => $this->updated_at,
            self::tableName() . '.type' => $this->typeName
        ]);

        $query->andFilterWhere(['like', self::tableName() . '.name', $this->name])
            ->andFilterWhere(['like', self::tableName() . '.description', $this->description])
            ->andFilterWhere(['like', $user_table . '.username', $this->creator])
            ->andFilterWhere(['like', $user_table . '.username', $this->updater]);


        return $dataProvider;
    }
}
