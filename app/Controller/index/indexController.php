<?php
namespace app\Controller\index;
use Uphp\Log;

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