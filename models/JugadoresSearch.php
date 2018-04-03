<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * JugadoresSearch represents the model behind the search form of `app\models\Jugadores`.
 */
class JugadoresSearch extends Jugadores
{
    public $posicion;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'equipo_id'], 'integer'],
            [['nombre', 'posicion', 'contrato'], 'safe'],
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
        $query = Jugadores::find()
        ->joinWith(['posicion'])
        ->where(['equipo_id' => $equipoId]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['posicion_id' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->sort->attributes['posicion'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['posiciones.nombre' => SORT_ASC],
        'desc' => ['posiciones.nombre' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'posiciones.nombre' => $this->posicion,
            'dorsal' => $this->dorsal,
            'equipo_id' => $this->equipo_id,
        ]);

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'contrato', $this->contrato]);

        return $dataProvider;
    }
}
