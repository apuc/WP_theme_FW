<?php

namespace lib;

use config\Config;

class Model
{
    private $db;
    public $query;

    function __construct(){
        $config = new Config();
        $this->db = new Db($config->db);
    }

    /**
     * Возвращает имя таблицы
     * @return string имя таблицы.
     */
    public function table_name(){
        return '';
    }

    /**
     * Возвращает имя таблицы
     * @return array поля таблицы.
     */
    public function fields(){
        return [];
    }

    /**
     * Возвращает правила таблицы
     * @return array правила таблицы.
     */
    public function rules(){
        return [];
    }

    /**
     * Возвращает имя таблицы
     * @param integer $id идентификатор таблицы
     * @return array поля таблицы.
     */
    public function findById($id){
        $arr = $this->db->getFromId($id, $this->table_name());
        foreach($this->fields() as $field){
            $this->$field = $arr[$field];
        }
        $this->id = $arr['id'];
        return $arr;
    }

    /**
     * Создает начальный запрос к таблице
     * @return $this the model instance itself.
     */
    public function find(){
        $this->query = "SELECT * FROM `".$this->table_name()."`";
        return $this;
    }

    /**
     * Добавляет к запросу "WHERE"
     * @param $arr array поля по которым необходимо произвести поиск
     * @return $this the model instance itself.
     */
    public function where($arr){
        $this->query .= " WHERE ";
        if(!empty($arr)){
            foreach($arr as $k => $v){
                if($this->getRuleByField($k,'integer')){
                    $this->query .= $k . " = " . $v;
                }
                else {
                    $this->query .= $k . " LIKE '%" . $v . "%'";
                }
                $this->query .= " AND ";
            }
            $this->query = substr($this->query, 0, -5);
        }
        return $this;
    }

    /**
     * Осуществляет запрос с множественным ответом
     * @return array|boolean ответ базы.
     */
    public function all(){
        return $this->db->getAll($this->query);
    }

    /**
     * Осуществляет запрос с одним ответом
     * @return array|boolean ответ базы.
     */
    public function one(){
        $arr = $this->db->getOne($this->query);
        foreach($this->fields() as $field){
            $this->$field = $arr[$field];
        }
        $this->id = $arr['id'];
        return $arr;
    }


    /**
     * Лимит выборки из базы
     * @param $offset integer отступ.
     * @param $count integer количество.
     * @return $this the model instance itself.
     */
    public function limit($count, $offset = 0){
        $this->query .= " LIMIT $offset, $count";
        return $this;
    }

    /**
     * Сортировка выборки из базы
     * @param $field string поле по которому сортировать.
     * @param $sorting string ASC/DESC.
     * @return $this the model instance itself.
     */
    public function orderBy($field, $sorting){
        $this->query .= " ORDER BY $field $sorting";
        return $this;
    }

    /**
     * Осуществляет сохранение (обновление) данных в таблице
     * @return integer|boolean id записи или false.
     */
    public function save(){
        if(empty($this->id)){
            $data = [];
            foreach($this->fields() as  $field){
                if(!empty($this->$field)){
                    $data[$field] = $this->$field;
                }
            }
            if($this->validate()){
                $this->id = $this->db->insert($data, $this->table_name());
                return $this->id;
            }
            else {
                return false;
            }

        }
        else {
            $data = [];
            foreach($this->fields() as  $field){
                if(!empty($this->$field)){
                    $data[$field] = $this->$field;
                }
            }
            return $this->db->update($data, $this->table_name(), ['id'=>$this->id]);
        }
    }

    /**
     * Проверяет совпадает ли переданное правило с полем
     * @param $field string поле для сравнения
     * @param $rule string правило для сравнения
     * @return boolean .
     */
    private function getRuleByField($field, $rule){
        if($field == 'id' && $rule == 'integer'){
            return true;
        }
        foreach($this->rules() as $r){
            if($r[1] == $rule){
                if(in_array($field, $r[0])){
                    return true;
                }
            }
        }
        return false;
    }

    private function validate(){
        foreach($this->rules() as $rule){
            if($rule[1] == 'required'){
                foreach($rule[0] as $field){
                    if(empty($this->$field)){
                        return false;
                    }
                }
            }
        }
        return true;
    }
}