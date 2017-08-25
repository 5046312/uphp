<?php
namespace app\index\model;
use uphp\Model;
class userModel extends Model
{
    public function getUserById($id){
        return $this->where(['id'=>$id])->select();
    }
}