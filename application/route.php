<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


use think\Route;


//首页
Route::get('index','index/index/index');
/**
 * 用户
 */
Route::rule('detailed','index/user/detailed');
Route::rule('add-user','index/user/addUser');

/**
 * 登录控制器
 */
Route::get('register','index/login/register');
Route::post('getChildArea','index/login/getChildArea');

/**
 * 收藏
 */
Route::get('collection-add/:id','index/collection/add');

/**
 * 微信控制器
 */
Route::rule('wx','index/wx/index');
Route::rule('sign','index/wx/sign');
Route::rule('base-api','index/wx/baseApi');