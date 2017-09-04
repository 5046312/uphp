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
        p(Session::id("6s87gko2r5e9b9jgjti11dms75"));
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