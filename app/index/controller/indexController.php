<?php
namespace app\index\controller;
use app\index\model\userModel;
use uphp\Controller;

class indexController extends Controller
{
    public function index(){
        $user = new userModel();
        d($user);
    }
}