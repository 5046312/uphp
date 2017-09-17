<?php
namespace app\Controller\index;
use app\Model\UserModel;
use Uphp\Controller;
class indexController extends Controller
{
    public function index(){
        $user = new UserModel();
        p($user->select());
    }
}