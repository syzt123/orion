<?php
namespace app\index\controller;

use app\common\moulds\User;
use app\common\service\Member;
use think\Request;

class Index extends Base
{

    /**
     * 初始化用户open_id
     * Index constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    /**
     * 用户首页
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        //  获取用户身份
//        if(empty($this->openID)){
//            $this->redirect('/wx');
//        }
//
        $this->openID = 'qweqe';
        $userModel = User::get(['_id'=>$this->openID]);
//        //  如果用户不存在那就 跳转到注册页面
//        if(empty($userModel)){
//             $this->redirect('/register');
//        }

//        TODO:获取列表信息
       $result =  $userModel->getUserList();
       return  $this->fetch('index',[
           'result'=>$result
       ]);

    }







}
