<?php

namespace lib;

use config\Config;
use models\User;

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
     * Возвращает класс
     * @return string класс.
     */
    public static function classNameStatic(){
        return get_called_class();
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
     * Возвращает имя таблицы
     * @param string $field поле таблицы
     * @param string|integer $value значение поля таблицы
     * @return array поля таблицы.
     */
    public function findByField($field, $value){
        $arr = $this->db->getByField($field, $value, $this->table_name(),($this->getRuleByField($field,'integer') ? 'int' : 'str'));
        if(empty($arr[0])){
            return false;
        }
        foreach($this->fields() as $fl){
            $this->$fl = $arr[0][$fl];
        }
        $this->id = $arr[0]['id'];
        return $arr[0];
    }

    /**
     * @param string $field
     * @param string $value
     * @return object $obj
     */
    public static function getByField($field, $value){
        $class = self::classNameStatic();
        $obj = new $class();
        $obj->findByField($field, $value);
        unset($obj->db);
        return $obj;
    }

    /**
     * @return array|bool
     */
    public static function getAll(){
        $class = self::classNameStatic();
        $obj = new $class();
        $arr = $obj->find()->all();
        return $arr;
    }

    /**
     * Возвращает имя таблицы
     * @param string $field поле таблицы
     * @param integer $id значение поля таблицы
     * @return string поля таблицы.
     */
    public function getFieldById($field, $id){
        $str = $this->db->getFromId($id, $this->table_name());
        if(isset($str[$field])){
            return $str[$field];
        }
        else {
            return false;
        }
    }

    /**
     * Создает начальный запрос к таблице
     * @param string $select необходимые поля
     * @return $this the model instance itself.
     */
    public function find($select = '*'){
        $this->query = "SELECT $select FROM `".$this->table_name()."`";
        return $this;
    }

    /**
     * Добавляет к запросу "WHERE"
     * @param $arr array поля по которым необходимо произвести поиск
     * @param $logic string логика запроса
     * @return $this the model instance itself.
     */
    public function where($arr, $logic = 'AND'){
        $this->query .= " WHERE ( ";
        if(!empty($arr)){
            foreach($arr as $k => $v){
                if(is_array($v)){
                    $this->query .= $k . " IN ( " . implode(',', $v) . " )";
                }
                else {
                    if($this->getRuleByField($k,'integer')){
                        $this->query .= $k . " = " . $v;
                    }
                    else {
                        $this->query .= $k . " LIKE '%" . $v . "%'";
                    }
                }
                $this->query .= " $logic ";
            }
            $this->query = substr($this->query, 0, -4);
            $this->query .= " )";
        }
        return $this;
    }

    /**
     * Добавляет к запросу "GROUP BY"
     * @param $field string поле по которому необходимо произвести группировку
     * @return $this the model instance itself.
     */
    public function groupBy($field){
        if(!empty($field)){
            $this->query .= " GROUP BY $field ";
        }
        return $this;
    }

    /**
     * Добавляет к запросу "AND"
     * @param $arr array поля по которым необходимо произвести поиск
     * @param $logic string логика запроса
     * @return $this the model instance itself.
     */
    public function andWhere($arr, $logic = "AND"){
        $this->query .= " AND ( ";
        if(!empty($arr)){
            foreach($arr as $k => $v){
                if($this->getRuleByField($k,'integer')){
                    $this->query .= $k . " = " . $v;
                }
                else {
                    $this->query .= $k . " LIKE '%" . $v . "%'";
                }
                $this->query .= " $logic ";
            }
            $this->query = substr($this->query, 0, -4);
            $this->query .= " )";
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
     * @param $table string имя таблицы.
     * @param $on string параметры присоединения.
     * @return $this the model instance itself.
     */
    public function leftJoin($table, $on){
        $this->query .= " LEFT JOIN `$table` ON $on";
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
     * @param $id integer
     * @return array|bool
     */
    public function deleteAll($id){
        if(is_array($id)){
            foreach ($id as $i) {
                $this->db->queryDelete($this->table_name(), $i);
            }
        }else{
            return $this->db->queryDelete($this->table_name(), $id);
        }
        return true;
    }

    /**
     * @param $arr array
     * @return array|bool
     */
    public function deleteWhere($arr){
        return $this->db->queryDeleteWhere($this->table_name(), $arr);
    }

    /**
     * @param $field string
     * @param $value integer|string
     * @return array|bool
     */
    public function deleteByField($field,$value){
        return $this->db->queryDeleteByField($this->table_name(), $field, $value);
    }

    /**
     * @return mixed
     */
    public function get_stat(){
        return $this->db->stat;
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