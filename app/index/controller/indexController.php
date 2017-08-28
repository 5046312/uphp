<?php
namespace app\index\controller;
use app\index\model\userModel;
use uphp\Controller;

class indexController extends Controller
{
    public function index(){

    }

    public function article(){
        echo 123;
    }

    public function login(){
        $user = new userModel();
        $res = $user->select();
        echo "login";
        $this->view("user/home");
    }
}