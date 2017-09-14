<?php
namespace app\Controller\index;
use Uphp\Cache;
use Uphp\Log;

class indexController
{
    public function index(){
        #   index/index/index()
        echo "index/index/index";
        Cache::init();
    }

    public function test($a, $b){
        p(func_get_args());
    }
}