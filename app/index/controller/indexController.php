<?php
namespace app\index\controller;
use app\index\model\userModel;
use uphp\Config;
use uphp\Controller;

class indexController extends Controller
{
    public function index(){
        return "this is index/index";
    }

    public function article(){
        echo 123;
    }

    public function login(){
        $user = new userModel();
        $res = $user->select();
        echo "login";
        return $this->view("user/home");
    }
}