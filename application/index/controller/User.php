<?php
/**
 * Created by PhpStorm.
 * User: SNQU
 * Date: 2019/5/29
 * Time: 19:45
 */

namespace app\index\controller;


class User extends Base
{
    public function detailed()
    {
        return $this->fetch();
    }

    public function addUser(){
        $params = input('post.');
        print_r($params);
    }

}