<?php
namespace app\Controller\index;


class indexController
{
    public function index(){
        #   index/index/index()
        echo "index/index/index";
    }

    public function test($a, $b){
        p(func_get_args());
    }
}