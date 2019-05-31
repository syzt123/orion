<?php
/**
 * Created by PhpStorm.
 * User: SNQU
 * Date: 2019/5/28
 * Time: 13:12
 */

namespace app\common\component;


class Curl
{

    protected $_useragent          = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36';
    protected $_url;
    protected $_followLocation;
    protected $_timeout;
    protected $_maxRedirects;
    protected $_cookieFileLocation = './curl_cookie.txt';
    protected $_post               = false;
    protected $_postFields;
    protected $_refer              = '';

    protected $session;
    protected $_webpage;
    protected $_includeHeader;
    protected $_noBody;
    protected $_status;
    protected $_binaryTransfer;
    protected $_ssl   = false;
    protected $_noCA  = true;
    protected $header = [];

    public $authentication = 0;
    public $auth_name      = '';
    public $auth_pass      = '';

    /**
     *
     * @param    string $url [description]
     * @param    boolean $followLocation [启用时会将服务器服务器返回的"Location: "放在header中递归的返回给服务器，使用 CURLOPT_MAXREDIRS 可以限定递归返回的数量。 ]
     * @param    integer $timeout [超时时间]
     * @param    integer $maxredirects [递归返回数量]
     * @param    boolean $binaryTransfer [在启用 CURLOPT_RETURNTRANSFER 的时候，返回原生的（Raw）输出]
     * @param    boolean $includeHeader [启用时会将头文件的信息作为数据流输出。]
     * @param    boolean $noBody [启用时将不对HTML中的BODY部分进行输出。]
     */
    function __construct($url = '', $followLocation = true, $timeout = 10, $maxredirects = 4, $binaryTransfer = false, $includeHeader = false, $noBody = false)
    {
        $this->_url = $url;
        $this->_followLocation = $followLocation;
        $this->_timeout = $timeout;
        $this->_maxRedirects = $maxredirects;
        $this->_binaryTransfer = $binaryTransfer;

    }

    /**
     * 设置连接是否验证
     * @author
     * @param    [type]                   $use [1，启用安全连接，0，不启用]
     * @return   [type]                        [description]
     */
    public function useAuth($use)
    {
        if ($use) {
            $this->authentication = 1;
        } else {
            $this->authentication = 0;
        }
    }

    /**
     * 设置连接用户名
     * @author      *
     * @param    [type]                   $name [用户名]
     */
    public function setName($name)
    {
        $this->auth_name = $name;
    }

    /**
     * 设置连接密码
     * @author
     * @param    [type]                   $pass [description]
     */
    public function setPass($pass)
    {
        $this->auth_pass = $pass;
    }

    /**
     * 设置在HTTP请求头中"Referer: "的内容
     * @author
     * @param    [type]                   $referer [description]
     */
    public function setReferer($referer)
    {
        $this->_refer = $referer;
    }

    /**
     * 设置cookie产生位置
     * @author
     * @param    [type]                   $location [description]
     */
    public function setCookieFileLocation($location)
    {
        $this->_cookieFileLocation = $location;
    }

    /**
     * 设置请求为Post请求
     * @param    [type]                   $postFields [post请求内容]
     */
    public function setPost($postFields)
    {
        $this->_post = true;
        if (is_array($postFields)) {
            foreach ($postFields as $key => $val) {
                if (is_array($val)) {
                    unset($postFields[$key]);
                    foreach ($val as $key2 => $val2) {
                        $postFields[$key . '[' . $key2 . ']'] = $val2;
                    }
                }
            }
        }
        $this->_postFields = $postFields;
    }

    /**
     * 设置get参数
     * @param $getFields
     */
    public function setGet($getFields)
    {
        $parseUrl = explode('?', $this->_url);
        if (isset($parseUrl[1])) {
            //如果url上带有参数，则需将url上参数和getFields合并
            $params = explode('&', $parseUrl[1]);
            $url = $parseUrl[0];
        } else {
            $params = [];
            $url = $this->_url;
        }

        $extraParams = [];
        foreach ($getFields as $key => $val) {
            $extraParams[] = $key . '=' . $val;
        }
        $params = array_merge($params, $extraParams);

        $this->_url = $url . '?' . implode('&', $params);
    }

    /**
     * 获取url
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * 设置HTTP请求中包含一个"User-Agent: "头的字符串
     * @datatime 2015-06-02T21:07:47+0800
     * @param    [type]                   $user_agent [description]
     */
    public function setUserAgent($user_agent)
    {
        $this->_useragent = $user_agent;
    }

    /**
     * 设置是否开启SSL安全连接
     * @datatime 2015-06-02T21:09:06+0800
     * @param    [type]                   $ssl [description]
     */
    public function setSSL($ssl)
    {
        $this->_ssl = $ssl;
    }

    /**
     * 设置header
     * @param $header array http请求头
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * 创建一个curl连接
     * @author 
     * @datatime 2015-06-02T21:09:30+0800
     * @param    string $url [请求地址]
     * @return   [type]                        [description]
     */
    public function createUrl($url = 'null')
    {
        if ($url != 'null') {
            $this->_url = $url;
        }

        $conn_curl = curl_init();

        curl_setopt($conn_curl, CURLOPT_URL, $this->_url);
        curl_setopt($conn_curl, CURLOPT_HTTPHEADER, $this->header);
        curl_setopt($conn_curl, CURLOPT_TIMEOUT, $this->_timeout);
        curl_setopt($conn_curl, CURLOPT_MAXREDIRS, $this->_maxRedirects);
        curl_setopt($conn_curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($conn_curl, CURLOPT_FOLLOWLOCATION, $this->_followLocation);
        curl_setopt($conn_curl, CURLOPT_COOKIEJAR, $this->_cookieFileLocation);
        curl_setopt($conn_curl, CURLOPT_COOKIEFILE, $this->_cookieFileLocation);

        if ($this->_ssl) {
            curl_setopt($conn_curl, CURLOPT_SSL_VERIFYPEER, 1);
            if ($this->_noCA) {
                curl_setopt($conn_curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                // https请求 不验证证书和hosts
                curl_setopt($conn_curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            }
        }

        if ($this->authentication == 1) {
            curl_setopt($conn_curl, CURLOPT_USERPWD, $this->auth_name . ':' . $this->auth_pass);
        }

        if ($this->_post) {
            curl_setopt($conn_curl, CURLOPT_POST, true);
            curl_setopt($conn_curl, CURLOPT_POSTFIELDS, $this->_postFields);
        }

        if ($this->_includeHeader) {
            curl_setopt($conn_curl, CURLOPT_HEADER, true);
        }

        if ($this->_noBody) {
            curl_setopt($conn_curl, CURLOPT_NOBODY, true);
        }

        if ($this->_binaryTransfer) {
            curl_setopt($conn_curl, CURLOPT_BINARYTRANSFER, true);
        }

        curl_setopt($conn_curl, CURLOPT_USERAGENT, $this->_useragent);
        curl_setopt($conn_curl, CURLOPT_REFERER, $this->_refer);

        $this->_webpage = trim(curl_exec($conn_curl));
        $this->_status = curl_getinfo($conn_curl, CURLINFO_HTTP_CODE);
        curl_close($conn_curl);
    }

    public function getHttpStatus()
    {
        return $this->_status;
    }

    public function __tostring()
    {
        return $this->_webpage;
    }

    public function getWebPage()
    {
        return $this->_webpage;
    }
}