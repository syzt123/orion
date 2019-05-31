<?php
/**
 * Created by PhpStorm.
 * User: 54607
 * Date: 2019/5/26
 * Time: 19:34
 */

namespace app\index\controller;


use app\common\moulds\Area;
use think\Controller;

class Login extends Controller
{

    /**
     *  注册页面
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function register()
    {
       $areaList =  Area::all(['parent_id'=>0]);
       return  $this->fetch('register',[
           'arealist'=>collection($areaList)->toArray()
       ]);
    }

    /**
     * 获取子区域
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getChildArea() {
        $where['parent_id'] = input('post.parent_id');
        if (input('post.putype') == 1) {
            $where['is_open'] = 1;
        }
        $areaModel = new Area();
        $area = $areaModel->field('id, area_name, is_reg, is_open')->where($where)->select();
        if ($area) {
            $option = '<option value="">---请选择---</option>';
            foreach ($area as $key => $value) {
                $option .= '<option value="'.$value['id'].'">'.$value['area_name'].'</option>';
            }
            return  json_encode(['error' => 0, 'option' => $option]);
        } else {
            return json_encode(['error' => 1]);
        }
    }
}