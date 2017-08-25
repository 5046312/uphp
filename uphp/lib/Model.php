<?php
namespace uphp;
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
        $this->table = empty($tableName);
        $this->prefix = empty($prefix)?:config('db')['prefix'];
    }

    public function __set($key, $value){
        $this->$key = $value;
    }

    public function table($tableName){
        $this->table = $tableName;
        return $this;
    }

    public function insert($data){

    }

    public function delete($data){

    }

    public function update($data){

    }

    public function select(){
        # SELECT * FROM TABLE WHERE A=2 AND B=3
    }

    // ['id'=> 1]
    // ['id'=>['>',1]]
    // ['user.id'=>['>',1]]
    // ['id'=>['in', '1,2,3,4']]
    public function where($data){
        foreach($data as $k=>$v){
            if(!is_array($v)){
                // eq
                $this->condition['where'][] =
            }
        }
        return $this;
    }

    public function orWhere($data){

    }

    public function limit($start, $pageSize = ""){

    }
}
