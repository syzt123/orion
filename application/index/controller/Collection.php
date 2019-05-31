<?php
/**
 * Created by PhpStorm.
 * User: 54607
 * Date: 2019/5/26
 * Time: 20:37
 */

namespace app\index\controller;




use app\common\moulds\Collect;
class Collection extends Base
{

    public function add()
    {
         $params = input('param.');
         Collect::create($params);
    }
}