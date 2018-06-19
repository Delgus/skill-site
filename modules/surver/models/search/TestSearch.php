<?php

namespace app\modules\surver\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\surver\models\Test;
use app\modules\surver\models\TestCategory;
use yii\db\ActiveRecord;

/**
 * TestSearch represents the model behind the search form of `app\modules\surver\models\Test`.
 * Class TestSearch
 * @package app\modules\surver\models\search
 */
class TestSearch extends Test
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
    public $statusName;
    /**
     * @var
     */
    public $category;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'category_id'], 'integer'],
            [['name', 'description', 'creator', 'updater', 'statusName', 'category'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param $client
     *
     * @return ActiveDataProvider
     */
    public function search($params, $client = false)
    {
        $query = Test::find()->joinWith(['creator', 'category']);
        if ($client) {
            $query->where([self::tableName() . '.status' => self::STATUS_ACTIVE]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        /** Класс User для корректного определения таблицы */
        /** @var ActiveRecord $class */
        $class = Yii::$app->user->identityClass;
        $user_table = $class::tableName();

        $dataProvider->sort->attributes['creator'] = [
            'asc' => [$user_table . '.username' => SORT_ASC],
            'desc' => [$user_table . '.username' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['updater'] = [
            'asc' => [$user_table . '.username' => SORT_ASC],
            'desc' => [$user_table . '.username' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['statusName'] = [
            'asc' => ['status' => SORT_ASC],
            'desc' => ['status' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['category'] = [
            'asc' => [TestCategory::tableName() . '.name' => SORT_ASC],
            'desc' => [TestCategory::tableName() . '.name' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            self::tableName() . '.created_at' => $this->created_at,
            self::tableName() . '.updated_at' => $this->updated_at,
            self::tableName() . '.status' => $this->statusName
        ]);

        $query->andFilterWhere(['like', self::tableName() . '.name', $this->name])
            ->andFilterWhere(['like', self::tableName() . '.description', $this->description])
            ->andFilterWhere(['like', $user_table . '.username', $this->creator])
            ->andFilterWhere(['like', $user_table . '.username', $this->updater])
            ->andFilterWhere(['like', TestCategory::tableName() . '.name', $this->category]);


        return $dataProvider;
    }
}
