<?php
namespace uphp;
class Mysql
{
    protected $PDO; // 链接
    protected $PDOStatement; // PDOStatement
    protected $querySql; // Sql
    protected $bindParam = []; // Sql参数绑定

    public function __construct()
    {
        $dsn = "mysql:host=".config('db_host').";dbname=".config('db_name').";port=".config('db_port');
        try {
            $this->PDO = new \PDO($dsn, config('db_username'), config('db_password'), [\PDO::ATTR_PERSISTENT => true]);
        }catch(\PDOException $e){
            d($e->getMessage());
            die;
        }
        $this->PDO->exec('set names utf8');
    }

    public function query($str, $showSql = false) {
        $this->querySql = $str;
        if($showSql){
            return $this->querySql;
        }
        $this->PDOStatement = $this->PDO->prepare($str);
        if(false === $this->PDOStatement){
            $this->error();
            return false;
        }
        foreach ($this->bindParam as $key => $val) {
            if(is_array($val)){
                $this->PDOStatement->bindValue($key, $val[0], $val[1]);
            }else{
                $this->PDOStatement->bindValue($key, $val);
            }
        }
        $this->bindParam = NULL;
        try{
            $result = $this->PDOStatement->execute();
            if ( false === $result ) {
                $this->error();
                return false;
            } else {
                return $this->fetchAll();
            }
        }catch (\PDOException $e) {
            $this->error();
            return false;
        }
    }

    public function execute($str, $showSql = false) {
        $this->querySql = $str;
        if($showSql){
            return $this->querySql;
        }
        $this->PDOStatement = $this->PDO->prepare($str);
        if(false === $this->PDOStatement){
            $this->error();
            return false;
        }
        foreach ($this->bindParam as $key => $val) {
            if(is_array($val)){
                $this->PDOStatement->bindValue($key, $val[0], $val[1]);
            }else{
                $this->PDOStatement->bindValue($key, $val);
            }
        }
        $this->bindParam = NULL;
        try{
            $result =   $this->PDOStatement->execute();
            if ( false === $result) {
                $this->error();
                return false;
            } else {
                // execute success
                return $result;
            }
        }catch (\PDOException $e) {
            $this->error();
            return false;
        }
    }

    public function bind($key, $value){
        $this->bindParam[$key] = $value;
    }

    public function getLastInsertId(){
        return $this->PDO->lastInsertId();
    }

    public function free() {
        $this->PDO = null;
    }

    public function error()
    {
        $error = $this->PDOStatement->errorInfo();
        echo "SQL语句:".$this->querySql.'<br>';
        echo "错误原因:",($error[2]);
        die;
    }

    public function fetchAll(){
        $res = $this->PDOStatement->fetchAll(\PDO::FETCH_ASSOC);
        return $res;
    }

    public function showTables($dbname = ""){
        $this->querySql = empty($dbname)?'SHOW TABLES':'SHOW TABLES FROM '.$dbname;
        $res = $this->query($this->querySql);
        $tables = [];
        foreach($res as $k=>$v){
            $tables[] = current($v);
        }
        return $tables;
    }
}