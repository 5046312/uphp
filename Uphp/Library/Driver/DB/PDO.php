<?php
namespace Uphp\Driver\DB;
use Uphp\Error;
use Uphp\Log;

/**
 * 操作PDO的类
 * Class PDO
 * @package Uphp
 */
class PDO
{
    protected $PDO; // 链接
    protected $PDOStatement; // PDOStatement
    protected $querySql; // Sql
    protected $bindParam = []; // Sql参数绑定

    /**
     * PDO Driver初始化
     * 传入配置
     * PDO constructor.
     * @param $config
     */
    public function __construct($config)
    {
        switch ($config['type']){
            case "mysql":
                $type = "mysql";
                break;
        }
        $dsn = $type.":host=".$config['host'].";dbname=".$config['name'].";port=".$config['port'];
        try {
            $this->PDO = new \PDO($dsn, $config['username'], $config['password'], [\PDO::ATTR_PERSISTENT => true]);
        }catch(\PDOException $e){
            Error::exception($e->getMessage());
        }
        $this->PDO->exec('SET NAMES UTF8');
    }

    /**
     * PDO执行query
     * @param $str
     * @param bool $showSql 返回sql语句，但不执行
     * @return bool
     */
    public function query($str, $showSql = false) {
        #   只返回查询语句
        if($showSql){
            return $str;
        }

        #   日志所记录查询时间
        $sqlStartTime = microtime();
        $this->querySql = $str;
        #   PDO预处理
        $this->PDOStatement = $this->PDO->prepare($str);
        if(false === $this->PDOStatement){
            $this->error();
        }
        #   遍历绑定
        foreach ($this->bindParam as $key => $val) {
            if(is_array($val)){
                $this->PDOStatement->bindValue($key, $val[0], $val[1]);
            }else{
                $this->PDOStatement->bindValue($key, $val);
            }
        }

        try{
            #   PDO执行
            $result = $this->PDOStatement->execute();
            #   执行结束，写入日志
            Log::add("SQL # {$str} - Time:".round(((microtime()-$sqlStartTime) * 1000), 3)."ms");
            if ( false === $result ) {
                $this->error();
            } else {
                return $this->fetchAll();
            }
        }catch (\PDOException $e) {
            $this->error();
        }
    }

    /**
     * PDO执行execute语句
     * @param $str
     * @param bool $showSql 返回sql语句，但不执行
     * @return bool
     */
    public function execute($str, $showSql = false) {
        #   只返回查询语句
        if($showSql){
            return $str;
        }
        #   日志所记录查询时间
        $sqlStartTime = microtime();
        $this->querySql = $str;
        #   PDO预处理
        $this->PDOStatement = $this->PDO->prepare($str);
        if(false === $this->PDOStatement){
            $this->error();
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
            #   执行结束，写入日志
            Log::add("SQL # {$str} - Time:".round(((microtime()-$sqlStartTime) * 1000), 3)."ms");
            if ( false === $result) {
                $this->error();
            } else {
                // execute success
                return $result;
            }
        }catch (\PDOException $e) {
            $this->error();
        }
    }

    /**
     * 参数绑定
     * @param $key
     * @param $value
     */
    public function bind($key, $value){
        $this->bindParam[$key] = $value;
    }

    /**
     * 获取最后插入的主键
     * @return string
     */
    public function getLastInsertId(){
        return $this->PDO->lastInsertId();
    }

    /**
     * 报错
     * TODO:Error类处理
     */
    private function error()
    {
        $error = $this->PDOStatement->errorInfo();
        Error::exception("SQL语句:".$this->querySql.'<br>'."错误原因:",($error[2]));
    }

    /**
     * 返回查询结果
     * @return mixed
     */
    public function fetchAll(){
        $res = $this->PDOStatement->fetchAll(\PDO::FETCH_ASSOC);
        return $res;
    }
}