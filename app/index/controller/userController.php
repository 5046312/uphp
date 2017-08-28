<?php
namespace app\index\controller;

class userController extends BaseController
{
    public function home(){
        echo "welcome {$_SESSION['login']['user']}";
    }
}