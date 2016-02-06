<?php
namespace models;

use lib\Model;

/**
 * ������ ��� ������ � �������� "geobase_city"
 *
 * @property integer $id
 * @property string $name
 * @property integer $region_id
 * @property double $latitude
 * @property double $longitude
 */
class GeobaseCity extends Model
{
    /**
     * @inheritdoc
     */
    public function table_name(){
        return 'geobase_city';
    }

    /**
     * @inheritdoc
     */
    public function fields(){
        return [
            'id',
            'name',
            'region_id',
            'latitude',
            'longitude',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            [['id','name','region_id'], 'required'],
            [['id','region_id'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['name'], 'string']
        ];
    }
}