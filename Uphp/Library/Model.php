<?php
namespace Uphp;
/**
 * Model类
 * Class Model
 * @package Uphp
 */
class Model
{
    private $config; // 数据库配置
    protected $name; // 数据表
    protected $db; // Db链接
    protected $table; // 表名
    protected $prefix; // 表前缀
    protected $condition; // 条件

    /**
     * 初始化
     * Model constructor.
     * @param string $tableName 临时设置表名，如不设置则使用对应Model文件名
     * @param string $prefix 前缀名，如不设置，则使用配置项
     */
    public function __construct($tableName = NULL, $prefix = NULL)
    {
        $this->config = config('db');
        #   判断数据库driver文件是否存在
        if(!file_exists(UPHP_DIR."/Library/Driver/DB/".$this->config['type'].".php")){
            #   数据库类型配置错误
            Error::exception(Language::get("DB_DRIVER_NOT_ERROR").":".$this->config['type']);
        }else{
            #   实例化Driver
            $db = "Uphp\Driver\DB\\".$this->config['type'];
            $this->db = new $db($this->config);
        }
        $this->table = empty($tableName) ? rtrim(pathinfo(get_class($this))['basename'], "Model") : $tableName;
        $this->prefix = empty($prefix) ?: $this->config['db_prefix'];
    }

    /**
     * 设置所操作的表
     * @param $tableName
     * @return $this
     */
    public function table($tableName){
        $this->table = $tableName;
        return $this;
    }

    /**
     * 执行Insert语句
     * @param $data
     * @return mixed
     */
    public function insert($data){
        $fields = "";
        $values = "";
        foreach ($data as $k=>$v){
            $fields .= "`{$k}`,";
            $values .= ":{$k},";
            $this->db->bind(":{$k}", $v);
        }
        $fields = rtrim($fields, ",");
        $values = rtrim($values, ",");
        $sql = "INSERT INTO ".$this->table."({$fields}) VALUES({$values});";
        return $this->db->execute($sql);
    }

    /**
     * 获取最新插入的主键值
     * @return mixed
     */
    public function getLastInsertId(){
        return $this->db->getLastInsertId();
    }

    /**
     * 执行delete
     * @return mixed
     */
    public function delete(){
        $sql = "DELETE FROM " . $this->table . $this->parseWhere();
        return $this->db->execute($sql);
    }

    /**
     * 执行update语句
     * @param $data
     * @return mixed
     */
    public function update($data){
        $fields = "";
        foreach ($data as $k=>$v){
            $fields .= "`{$k}` = :{$k} , ";
            $this->db->bind(":{$k}", $v);
        }
        $fields = rtrim($fields, " , ");
        $sql = "UPDATE ".$this->table. " SET {$fields} " . $this->parseWhere();
        return $this->db->execute($sql);
    }

    /**
     * 执行select语句
     * @return mixed
     */
    public function select(){
        # SELECT * FROM TABLE WHERE A=2 AND B=3
        $sql = "SELECT " . (empty($this->condition['field']) ? "*" : $this->condition['field']) . " FROM " . $this->table . $this->parseWhere();
        $res = $this->db->query($sql);
        return $res;
    }

    /**
     * 添加where条件
     * TODO:字符串形式
     * ['id'=> 1]
     * ['id'=>['>',1]]
     * ['user.id'=>['>',1]]
     * ['id'=>['in', '1,2,3,4']]
     * @param $data
     * @return $this
     */
    public function where($data){
        foreach($data as $k=>$v){
            if(!is_array($v)){
                // condition is string, eq
                $this->condition['where'][] = [$k, '=', $v];
            }else{
                // condition is array
                $this->condition['where'][] = [$k, $v[0], $v[1]];
            }
        }
        return $this;
    }

    /**
     * 添加Or条件
     * @param $data
     * @return $this
     */
    public function orWhere($data){
        foreach($data as $k=>$v){
            if(!is_array($v)){
                // condition is string, eq
                $this->condition['orWhere'][] = [$k, '=', $v];
            }else{
                // condition is array
                $this->condition['orWhere'][] = [$k, $v[0], $v[1]];
            }
        }
        return $this;
    }

    /**
     * where条件AND和OR拼装
     * @return bool|string
     */
    private function parseWhere(){
        if(empty($this->condition['where'])){
            return false;
        }else{
            $sql = " WHERE ";
            foreach ($this->condition['where'] as $k=>$v){
                $sql .= "`{$v[0]}` {$v[1]} {$v[2]} AND ";
            }
            $sql = rtrim($sql, "AND ");
            if(!empty($this->condition['orWhere'])){
                foreach ($this->condition['orWhere'] as $k=>$v){
                    $sql .= " OR `{$v[0]}` {$v[1]} {$v[2]}";
                }
            }
            return $sql;
        }
    }

    /**
     * Limit
     * @param $start
     * @param $pageSize
     * @return $this
     */
    public function limit($start, $pageSize){
        $this->condition['limit'] = empty($pageSize) ? "LIMIT {$start}" : "LIMIT {$start},{$pageSize}";
        return $this;
    }

    /**
     * 设置查询的字段
     * 字符串形式：field("a,b,c,d,e")
     * 数组形式：field(["a", "b", "c.id"]);
     * @param $data
     * @return $this
     */
    public function field($data){
        if(is_array($data)){
            $this->condition['field'] = implode(",", $data);
        }else{
            $this->condition['field'] = $data;
        }
        return $this;
    }

    /**
     * 排序
     * 字符串形式："id desc"
     * 数组形式：["id"=>"desc", "name"=>"asc"]
     * @param $data
     * @return $this
     */
    public function order($data){
        if(is_array($data)){
            $order = "";
            foreach ($data as $k=>$v){
                $order .= "`{$k}` {$v},";
            }
            $this->condition['order'] = rtrim($order, ',');
        }else{
            $this->condition['order'] = $data;
        }
        return $this;
    }
}
