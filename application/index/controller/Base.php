<?php
/**
 * Created by PhpStorm.
 * User: 54607
 * Date: 2019/5/26
 * Time: 19:15
 */

namespace app\index\controller;


use think\Controller;
use think\Request;
use think\Session;

class Base extends Controller
{
    protected $openID = 'asdasd';

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->openID = Session::get('openid');
    }




}