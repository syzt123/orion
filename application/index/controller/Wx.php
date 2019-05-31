<?php
/**
 * Created by PhpStorm.
 * User: SNQU
 * Date: 2019/5/28
 * Time: 13:15
 */

namespace app\index\controller;


use app\common\component\Curl;
use think\Controller;
use think\Session;

class Wx extends Controller
{
    protected $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?';
    protected $callback = 'http://www.at818.cn/base-api';

    /**
     * 获取用户授权 openID
     *
     */
    public function index()
    {
       $url = $this->url.'appid='.config('wx.appid').'&redirect_uri='.urlencode($this->callback).'&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect' ;
       $this->redirect($url);
    }

    public function baseApi()
    {
        $code = input('get.code');
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.config('wx.appid').'&secret='.config('wx.appSecret').'&code='.$code.'&grant_type=authorization_code';
        $curl = new Curl();
        $curl->createUrl($url);
        $result = $curl->getWebPage();
        $result = json_decode($result,true);
        print_r($result);
        if(!empty($result['openid'])){
            echo 7777;
            Session::set('openid',$result['openid']);
            $this->redirect('/index');
        }
        //        返回404页面

    }

    /**
     * 签证微信
     */
    public function Sign()
    {
        //获得参数 signature nonce token timestamp echostr
        $nonce     = $_GET['nonce'];
        $token     = 'sign';
        $timestamp = $_GET['timestamp'];
        $echostr   = $_GET['echostr'];
        $signature = $_GET['signature'];
        //形成数组，然后按字典序排序
        $array = array();
        $array = array($nonce, $timestamp, $token);
        sort($array);
        //拼接成字符串,sha1加密 ，然后与signature进行校验
        $str = sha1( implode( $array ) );
        if( $str  == $signature && $echostr ){
            //第一次接入weixin api接口的时候
            ob_clean();  //清除缓存
            echo $echostr;
            exit;
        }
    }





}