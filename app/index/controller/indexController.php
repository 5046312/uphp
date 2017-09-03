<?php
namespace app\index\controller;
use app\index\model\userModel;
use Uphp\Config;
use Uphp\Controller;

class indexController extends Controller
{
    public function index(){
        p(_MODULE_);
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