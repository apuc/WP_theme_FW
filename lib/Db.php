<?php

namespace lib;

class Db
{
    public $stat;

    private $settings;
    private $connect;
    private $defaults = array(
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'db' => 'fw',
        'port' => NULL,
        'socket' => NULL,
        'pconnect' => FALSE,
        'charset' => 'utf8',
    );

    function __construct($data = [])
    {
        $this->settings = array_merge($this->defaults, $data);

        $this->connect = mysqli_connect($this->settings['host'], $this->settings['user'], $this->settings['pass'], $this->settings['db']);
        if (!$this->connect) {
            printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error());
            exit;
        }
        else {
            mysqli_set_charset($this->connect, "utf8");
        }
    }

    public function rawQuery($query)
    {
        $start = microtime(TRUE);
        $result = mysqli_query($this->connect, $query);
        $timer = microtime(TRUE) - $start;

        $this->stat[] = array(
            'query' => $query,
            'start' => $start,
            'timer' => $timer,
        );
        if ($result) {
            if(is_object($result)){
                $arr = $this->getArray($result);
                $this->free($result);
            }
            else {
                $arr = true;
            }
            return $arr;
        }
        else {
            return false;
        }

    }

    public function getAll($query){
        return $this->rawQuery($query);
    }

    public function getOne($query){
        $res = $this->rawQuery($query);
        if(!empty($res)){
            return $res[0];
        }
        else {
            return false;
        }
    }

    public function getFromId($id, $table){
        $query = "SELECT * FROM `$table` WHERE id = $id";
        return $this->getOne($query);
    }

    public function getByField($field, $value, $table){
        $query = "SELECT * FROM `$table` WHERE ";
        if(is_int($value)){
            $query .= "$field = $value";
        }
        else {
            $query .= "$field LIKE '%$value%'";
        }
        return $this->rawQuery($query);
    }

    public function insert($data, $table){
        if(!empty($data)){
            $query = "INSERT INTO `$table` ";
            $key = "(";
            $value = "(";
            foreach($data as $k=>$v){
                $key .= $k.",";
                if(is_int($v)){
                    $value .= $v.",";
                }
                else{
                    $value .= "'".$v."',";
                }
            }
            $key = substr($key, 0, -1);
            $value = substr($value, 0, -1);
            $key .= ")";
            $value .= ")";
            $query .= $key . "VALUES" . $value;
            if($this->rawQuery($query)){
                return mysqli_insert_id($this->connect);
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    public function update($data, $table, $where){
        if(!empty($data)){
            $query = "UPDATE `$table` SET";
            foreach($data as $k => $v){
                if(is_int($v)){
                    $query .= " $k = $v,";
                }
                else {
                    $query .= " $k = '$v',";
                }

            }
            $query = substr($query, 0, -1);
            $query .= " WHERE";
            foreach($where as $k => $v){
                if($k == 'id'){
                    $query .= " $k = $v";
                }
                else {
                    if(is_int($v)){
                        $query .= " $k = $v";
                    }
                    else {
                        $query .= " $k LIKE '%$v%'";
                    }
                }

            }
            //var_dump($query);
            return $this->rawQuery($query);
        }
    }

    public function free($result){
        mysqli_free_result($result);
    }

    public function getRow(){

    }

    private function getArray($res){
        $arr = [];
        while( $row = mysqli_fetch_assoc($res) ){
            $arr[] = $row;
        }
        return $arr;
    }

}