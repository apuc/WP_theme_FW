<?php

namespace models;

/**
 * Модель для работы с таблицей "user"
 *
 * @property integer $id
 * @property string $ip
 * @property integer $views

 */
use lib\Model;

class Ip extends Model
{
    /**
     * @inheritdoc
     */
    public function table_name(){
        return 'banners_views';
    }

    /**
     * @inheritdoc
     */
    public function fields(){
        return [
            'ip',
            'views',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            [['views', 'ip'], 'required'],
            [['views'], 'integer'],
            [['ip'], 'string']
        ];
    }
}