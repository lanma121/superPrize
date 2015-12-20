<?php
/**
 * Created by zhp.
 * User: Administrator
 * Date: 2015/5/18
 * Time: 16:49
 */
    class OAuthException extends Exception {
        // pass
    }
    class WeiApi{
        public $appid;
        public $appkey;
        public $access_token;
        public $refresh_token;
        public $format = 'json';
        public $host = '';
        public $debug = FALSE;
        public $http_info;
        public static $boundary = '';
        public $useragent = 'Sae T OAuth2 v0.1';
        public $connecttimeout = 30;
        public $timeout = 30;
        public $ssl_verifypeer = FALSE;
       function __construct($appid,$appkey) {
           $this->appid= $appid;
           $this->apkey= $appkey;
       }
        function authorizeURL()    { return 'https://open.weixin.qq.com/connect/qrconnect'; }
        function accessTokenURL()  { return 'https://api.weixin.qq.com/sns/oauth2/access_token'; }
        function checkaccessTokenUrl(){return 'https://api.weixin.qq.com/sns/auth';}
        function getUserinfoUrl()  { return 'https://api.weixin.qq.com/sns/userinfo';}
        function get_userinfo($access_token,$open_id){
            $params = array();
            $params['access_token'] = $access_token;
            $params['openid'] = $open_id;
            $errmsg = $this->check_token($params);
            if($errmsg['errmsg'] =='ok' && $errmsg['errcode'] == 0){
                $userinfo = $this->oAuthRequest($this->getUserinfoUrl(), 'GET', $params);
                return json_decode($userinfo, true);
            }
        }
        function check_token($params){
            $errmsg = $this->oAuthRequest($this->checkaccessTokenUrl(), 'GET', $params);
            return json_decode($errmsg, true);
        }
        function getAuthorizeURL( $url, $response_type = 'code', $scope = 'snsapi_login',$state = NULL) {
            $params = array();
            $params['appid'] = $this->appid;
            $params['redirect_uri'] = $url;
            $params['response_type'] = $response_type;
            $params['scope'] = $scope;
            $params['state'] = $state;
            return $this->authorizeURL() . "?" . http_build_query($params).'#wechat_redirect';
        }
        function getAccessToken( $type = 'code', $keys ) {
            $params = array();
            $params['appid'] = $this->appid;
            $params['secret'] = $this->apkey;
            if ( $type === 'token' ) {
                $params['grant_type'] = 'refresh_token';
                $params['refresh_token'] = $keys['refresh_token'];
            } elseif ( $type === 'code' ) {
                $params['code'] = $keys['code'];
                $params['grant_type'] = 'authorization_code';
                //$params['redirect_uri'] = $keys['redirect_uri'];
            } elseif ( $type === 'password' ) {
                $params['grant_type'] = 'password';
                $params['username'] = $keys['username'];
                $params['password'] = $keys['password'];
            } else {
                throw new OAuthException("wrong auth type");
            }
            $response = $this->oAuthRequest($this->accessTokenURL(), 'GET', $params);
            $token = json_decode($response, true);
            if ( is_array($token) && !isset($token['error']) ) {
                $this->access_token = $token['access_token'];
                $this->refresh_token = $token['refresh_token'];
            } else {
                throw new OAuthException("get access token failed." . $token['error']);
            }
            return $token;
        }
        function oAuthRequest($url, $method, $parameters, $multi = false) {

            if (strrpos($url, 'http://') !== 0 && strrpos($url, 'https://') !== 0) {
                $url = "{$this->host}{$url}.{$this->format}";
            }
            switch ($method) {
                case 'GET':
                    $url = $url . '?' . http_build_query($parameters);
                    if (ini_get("allow_url_fopen") == "1") {
                        $response = file_get_contents($url);
                    }else{
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                        curl_setopt($ch, CURLOPT_URL, $url);
                        $response =  curl_exec($ch);
                        curl_close($ch);
                    }
                    return $response;
                default:
                    $headers = array();
                    if (!$multi && (is_array($parameters) || is_object($parameters)) ) {
                        $body = http_build_query($parameters);
                    } else {
                        $body = self::build_http_query_multi($parameters);
                        $headers[] = "Content-Type: multipart/form-data; boundary=" . self::$boundary;
                    }
                    return $this->http($url, $method, $body, $headers);
            }
        }
        function http($url, $method, $postfields = NULL, $headers = array()) {
            $this->http_info = array();
            $ci = curl_init();
            /* Curl settings */
            curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
            curl_setopt($ci, CURLOPT_USERAGENT, $this->useragent);
            curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
            curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);
            curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ci, CURLOPT_ENCODING, "");
            curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
            curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
            curl_setopt($ci, CURLOPT_HEADER, FALSE);

            switch ($method) {
                case 'POST':
                    curl_setopt($ci, CURLOPT_POST, TRUE);
                    if (!empty($postfields)) {
                        curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                        $this->postdata = $postfields;
                    }
                    break;
                case 'DELETE':
                    curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
                    if (!empty($postfields)) {
                        $url = "{$url}?{$postfields}";
                    }
            }

            if ( isset($this->access_token) && $this->access_token )
                $headers[] = "Authorization: OAuth2 ".$this->access_token;

            $headers[] = "API-RemoteIP: " . $_SERVER['REMOTE_ADDR'];
            curl_setopt($ci, CURLOPT_URL, $url );
            curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
            curl_setopt($ci, CURLINFO_HEADER_OUT, TRUE );

            $response = curl_exec($ci);
            $this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
            $this->http_info = array_merge($this->http_info, curl_getinfo($ci));
            $this->url = $url;

            if ($this->debug) {
                echo "=====post data======\r\n";
                var_dump($postfields);

                echo '=====info====='."\r\n";
                print_r( curl_getinfo($ci) );

                echo '=====$response====='."\r\n";
                print_r( $response );
            }
            curl_close ($ci);
            return $response;
        }
        public static function build_http_query_multi($params) {
            if (!$params) return '';

            uksort($params, 'strcmp');

            $pairs = array();

            self::$boundary = $boundary = uniqid('------------------');
            $MPboundary = '--'.$boundary;
            $endMPboundary = $MPboundary. '--';
            $multipartbody = '';

            foreach ($params as $parameter => $value) {

                if( in_array($parameter, array('pic', 'image')) && $value{0} == '@' ) {
                    $url = ltrim( $value, '@' );
                    $content = file_get_contents( $url );
                    $array = explode( '?', basename( $url ) );
                    $filename = $array[0];

                    $multipartbody .= $MPboundary . "\r\n";
                    $multipartbody .= 'Content-Disposition: form-data; name="' . $parameter . '"; filename="' . $filename . '"'. "\r\n";
                    $multipartbody .= "Content-Type: image/unknown\r\n\r\n";
                    $multipartbody .= $content. "\r\n";
                } else {
                    $multipartbody .= $MPboundary . "\r\n";
                    $multipartbody .= 'content-disposition: form-data; name="' . $parameter . "\"\r\n\r\n";
                    $multipartbody .= $value."\r\n";
                }

            }

            $multipartbody .= $endMPboundary;
            return $multipartbody;
        }
    }