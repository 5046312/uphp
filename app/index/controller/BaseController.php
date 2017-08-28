<?php
namespace app\index\controller;
use uphp\Controller;
class BaseController extends Controller
{
    public function __construct()
    {
        if(empty($_SESSION['login'])){
            $this->redirect('index/index/login');
        }
    }
}