<?php
/**
 * Created by PhpStorm.
 * User: 54607
 * Date: 2019/5/26
 * Time: 19:03
 */

namespace app\common\component;


class FuncHelp
{
    /**
     * 唯一ID
     * @return string
     */
    public static function uniqid () {
        $nowmics = explode(' ', microtime());
        $sec = substr('00' . base_convert(substr(($nowmics[1] - 1420041600), -9), 10, 36), -6);
        $msec = substr('00' . base_convert(substr($nowmics[0], 2, -2), 10, 36), -4);
        // 最后一位随机产生
        return $sec . $msec . base_convert(mt_rand(0, 35), 10, 36) . base_convert(mt_rand(0, 35), 10, 36);
    }

    /**
     * 获取指定长度的随机数
     * @param int $len
     * @param int $min
     * @param int $max
     * @return string
     */
    public static function getRandomNumber ($len = 19, $min = 0, $max = 9) {
        $random = "";
        for ($i = 0; $i < $len; $i++) {
            $random .= rand($min, $max);
        }
        return $random;
    }


    /**
     * 生成30位订单号
     * @param $orderType
     * @return string
     */
    public static function generateOrderNo ($orderType) {
        $hostIp = $_SERVER['SERVER_ADDR'];
        return date('YmdHis') . sprintf('%02d', $orderType) . ip2long($hostIp) . self::getRandomNumber(3);
    }

    /**
     * 生成16位订单号
     * @return string
     */
    public static function generateTradeNo () {
        return date('Ymd') . sprintf('%010d', crc32(self::uniqid()));
    }
}