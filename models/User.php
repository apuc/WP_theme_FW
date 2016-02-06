<?php

namespace models;
use lib\Model;

/**
 * Модель для работы с таблицей "user"
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $photo
 * @property string $ip
 * @property string $last_name
 * @property integer $dt_add
 * @property integer $status
 * @property integer $vk_id
 * @property integer $city_id
 * @property integer $region_id
 */

class User extends Model
{
    /**
     * @inheritdoc
     */
    public function table_name(){
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function fields(){
        return [
            'name',
            'email',
            'phone',
            'photo',
            'ip',
            'last_name',
            'dt_add',
            'status',
            'vk_id',
            'city_id',
            'region_id',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            [['name', 'ip', 'dt_add', 'status', 'vk_id', 'city_id', 'region_id'], 'required'],
            [['dt_add', 'status', 'vk_id', 'city_id', 'region_id'], 'integer'],
            [['name', 'email', 'phone', 'ip', 'last_name', 'photo'], 'string']
        ];
    }
}