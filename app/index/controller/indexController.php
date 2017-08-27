<?php
namespace app\index\controller;
use app\index\model\userModel;
use uphp\Controller;

class indexController extends Controller
{
    public function index(){
        jump(url("index"));
    }
}