<?php
namespace app\Controller\admin;
use Uphp\Controller;
class indexController extends Controller
{
    public function index(){
        return "this is admin/indexController/index";
    }

    private function pr(){
        echo "pr";
    }
}