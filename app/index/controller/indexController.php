<?php
namespace app\index\controller;
use app\index\model\userModel;
use Uphp\Config;
use Uphp\Controller;
use Uphp\Cookie;
use Uphp\Log\File;
use Uphp\Session;

class indexController extends Controller
{
    public function index(){
        echo "<img src='public/1.jpg'>";
        return "this is indexController/indexController";
    }

    public function test($abc, $p){
        echo "this is test";
        p($p);
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