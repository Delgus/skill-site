<?php

namespace app\modules\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\blog\models\PostCategory;

/**
 * PostCategorySearch represents the model behind the search form of `app\modules\blog\models\PostCategory`.
 */
class PostCategorySearch extends PostCategory
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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'description', 'creator', 'updater'], 'safe'],
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
        $query = PostCategory::find()->joinWith(['creator']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        /** Класс User для корректного определения таблицы */
        /** @var yii\db\ActiveRecord $class */
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

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', $user_table . '.username', $this->creator])
            ->andFilterWhere(['like', $user_table . '.username', $this->updater]);

        return $dataProvider;
    }
}
