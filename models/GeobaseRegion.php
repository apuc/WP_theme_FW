<?php
namespace models;

use lib\Model;

/**
 * ������ ��� ������ � �������� "geobase_region"
 *
 * @property integer $id
 * @property string $name
 */

class GeobaseRegion extends Model
{
    /**
     * @inheritdoc
     */
    public function table_name(){
        return 'geobase_region';
    }

    /**
     * @inheritdoc
     */
    public function fields(){
        return [
            'id',
            'name',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            [['id','name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string']
        ];
    }
}