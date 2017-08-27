<?php
namespace app\index\controller;
use uphp\Controller;
class BaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if(empty($_SESSION['login'])){

        }
    }
}