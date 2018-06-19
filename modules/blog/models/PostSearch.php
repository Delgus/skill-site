<?php

namespace app\modules\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PostSearch represents the model behind the search form of `app\modules\blog\models\Post`.
 */
class PostSearch extends Post
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
            [['id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'category_id'], 'integer'],
            [['title', 'description', 'text', 'category', 'statusName', 'creator', 'updater'], 'safe'],
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
     * @param bool $client
     *
     * @return ActiveDataProvider
     */
    public function search($params, $client = false)
    {
        $query = Post::find()->joinWith(['creator', 'category']);
        if ($client) {
            $query->where([self::tableName() . '.status' => self::STATUS_ACTIVE]);
        }

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

        $dataProvider->sort->attributes['statusName'] = [
            'asc' => ['status' => SORT_ASC],
            'desc' => ['status' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['category'] = [
            'asc' => [PostCategory::tableName() . '.name' => SORT_ASC],
            'desc' => [PostCategory::tableName() . '.name' => SORT_DESC],
        ];
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            self::tableName() . '.status' => $this->statusName
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', $user_table . '.username', $this->creator])
            ->andFilterWhere(['like', $user_table . '.username', $this->updater])
            ->andFilterWhere(['like', PostCategory::tableName() . '.name', $this->category]);

        return $dataProvider;
    }
}
