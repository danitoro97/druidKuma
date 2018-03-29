<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * JugadoresSearch represents the model behind the search form of `app\models\Jugadores`.
 */
class JugadoresSearch extends Jugadores
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'posicion_id', 'equipo_id'], 'integer'],
            [['nombre', 'contrato'], 'safe'],
            [['dorsal'], 'number'],
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
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     * @param mixed $equipoId
     *
     * @return ActiveDataProvider
     */
    public function search($params, $equipoId)
    {
        $query = Jugadores::find()->where(['equipo_id' => $equipoId]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'posicion_id' => $this->posicion_id,
            'dorsal' => $this->dorsal,
            'equipo_id' => $this->equipo_id,
        ]);

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'contrato', $this->contrato]);

        return $dataProvider;
    }
}
