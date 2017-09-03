<?php
namespace Uphp;
/**
 * Model类
 * Class Model
 * @package Uphp
 */
class Model
{
    protected $name; // 数据表
    protected $db; // Db链接
    protected $table; // 表名
    protected $prefix; // 表前缀
    protected $condition; // 条件

    public function __construct($tableName = "", $prefix = "")
    {
        $this->db = new Mysql();
        $this->table = empty($tableName) ? rtrim(pathinfo(get_class($this))['basename'], "Model") : $tableName;
        $this->prefix = empty($prefix)?:Config::get('db_prefix');
    }

    public function __set($key, $value){
        $this->$key = $value;
    }

    public function table($tableName){
        $this->table = $tableName;
        return $this;
    }

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

    public function getLastInsertId(){
        return $this->db->getLastInsertId();
    }

    public function delete(){
        $sql = "DELETE FROM " . $this->table . $this->parseWhere();
        return $this->db->execute($sql);
    }

    public function update($data){
        $fields = "";
        foreach ($data as $k=>$v){
            $fields .= "`{$k}` = :{$k} , ";
            $this->db->bind(":{$k}", $v);
        }
        $fields = rtrim($fields, " , ");
        $sql = "UPDATE ".$this->table. " SET {$fields} " . $this->parseWhere();
        d($sql);
        return $this->db->execute($sql);
    }

    public function select(){
        # SELECT * FROM TABLE WHERE A=2 AND B=3
        $sql = "SELECT " . (empty($this->condition['field']) ? "*" : $this->condition['field']) . " FROM " . $this->table . $this->parseWhere();
        $res = $this->db->query($sql);
        return $res;
    }

    // ['id'=> 1]
    // ['id'=>['>',1]]
    // ['user.id'=>['>',1]]
    // ['id'=>['in', '1,2,3,4']]
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

    public function limit($start, $pageSize){
        $this->condition['limit'] = empty($pageSize) ? "LIMIT {$start}" : "LIMIT {$start},{$pageSize}";
        return $this;
    }

    # field("a,b,c,d,e")
    # field(["a", "b", "c.id"]);
    public function field($data){
        if(is_array($data)){
            $this->condition['field'] = implode(",", $data);
        }else{
            $this->condition['field'] = $data;
        }
        return $this;
    }

    # "id desc"
    # ["id"=>"desc", "name"=>"asc"]
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
