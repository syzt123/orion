<?php
/**
 * Created by PhpStorm.
 * User: 54607
 * Date: 2019/5/26
 * Time: 19:51
 */

namespace app\common\service;


use app\common\moulds\user;

class Member
{

    public function isVip($openID)
    {
        return true;
    }

    /**
     * 推荐用户列表
     * @param user $userModel
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function recommend(User $userModel )
    {
        $where =[];

        if(self::isVip($userModel->open_id)){
            $where ['sex'] = ($userModel->sex==1)? 2 :1;
        }
        $list  = $userModel->where($where)->with('extend')->limit(50)->select();
        $list = collection($list)->toArray();


    }
}