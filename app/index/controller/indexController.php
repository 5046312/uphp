<?php
namespace app\index\controller;
use app\index\model\userModel;
use uphp\Controller;

class indexController extends Controller
{
    public function index(){
        $user = new userModel();
//        $res = $user->field(['id','name'])->where(['id'=>['>','1']])->orwhere(['id'=> 1])->select();
//        $data = [
//            'name'=> rand(1000, 9999)
//        ];
//        $res = $user->insert($data);

//        $res = $user->where(['id'=>'1'])->delete();


        $data = [
            'name' => 'wwww'
        ];
        $res = $user->where(['id'=>1])->update($data);
        d($res);
    }
}