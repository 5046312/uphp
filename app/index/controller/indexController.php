<?php
namespace app\index\controller;
use app\index\model\userModel;
use Uphp\Config;
use Uphp\Controller;
use Uphp\Cookie;
use Uphp\Session;

class indexController extends Controller
{
    public function index(){
        Session::set("user", 123);
        Cookie::set("a", ["a"=>1, "b"=>2], 3600);
        $v = Cookie::get("a");
        p($v);
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