<?php
namespace app\Controller\index;
use app\Model\UserModel;
use Uphp\Controller;
class indexController extends Controller
{
    public function index(){
        $user = new UserModel();
        p($user->where("id = 4")->where(['id' => 6])->orwhere("id = 5")->select());
    }
}