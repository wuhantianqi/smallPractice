<?php
	/**
	 * http协议类相关功能
	 * 1.统计网站访问的相关数据
     *  <1> 趋势分析
     *      实时访客
     *      今日统计
     *      昨日统计
     *      最近30天
     *  <2> 来源分析
     *      全部来源
     *      搜索引擎
     *      外部链接
     *  <3> 页面分析
     *      受访页面
     *      受访域名
     *      入口页面
     *      页面点击图
     *  <3> 访客分析
     *      地域分布
     *      系统环境
     *      新老访客
     *      访客属性
     *      忠诚度
     *  $centent = array (
     *      url             来源地址
     *      num             访问次数
     *      ip              访客IP
     *      address         访客地址
     *      time            访问时间
     *      current_url     当前访问的页面
     * )
	 * 2.小偷功能,采集数据
	 */
	class http{
		/**
		 * 统计网站访问信息
		 * @return [type] [description]
		 */
		public function statistics(){
            $centent=array();                      //存储信息
            $current_url = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];     //当前访问的url
            $centent['current_url'] = $current_url;
            //获取用户来源地址
            if( !empty($head=$this->head()) ){   //获取头信息
//                var_dump($head);
                if(isset($head['Referer'])){     //是否有来源地址
                    $centent['url'] = $head['Referer'];
                    $centent['num'] = 1;
                }else{
                    $centent['url'] = '通过地址栏直接访问';
                    $centent['num'] = 1;
                }
            }else{
                return '获取头信息失败';
            }
            if(!empty($ip=$this->getip())){       //获取IP地址
                $centent['ip'] = $ip;
                if(!empty($address=$this->getURL($ip))){      //根据IP获取地址
//                    echo $address;exit;
                    $curl_res = mb_convert_encoding(trim(strip_tags($address)), 'utf-8','gbk');      //新浪ip接口是国内网站,使用的是gbk编码,所以要转成utf-8
//                    echo $curl_res;
                    $res="/本站主数据.*参考数据二/Usi";
                    preg_match($res,trim($curl_res),$str);
//                    var_dump($str);
                    $str = str_replace("："," ",$str[0]);
                    $str = explode(" ",$str);
                    $centent['address'] = $str[1];
                }else{
                    return '获取地址失败';
                }
            }else{
                return '获取IP失败';
            }
            $time = gmdate("Y-m-d H:i:s",time()+8*3600);   //获取访问时间
            $centent['time'] = $time;
            //写入文本文件
            if($ftext=$this->ftext($centent) >0){
                return '写入成功';
            }else{
                return '写入文件失败';
            }
		}

        /**
         * 获取http协议当中的请求头信息
         */
        protected function head(){
            if (!function_exists('getallheaders'))    //检测函数是否存在函数（getallheaders）
            {
                foreach ($_SERVER as $name => $value)
                {
                    if (substr($name, 0, 5) == 'HTTP_')
                    {
                        //substr规定在字符串的何处开始截取，str_replace替换函数,strtolower把字符串转换为小写,ucwords把字符串中每个单词的首字符转换为大写,
                        $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                    }
                }
                return $headers;
            }else{
                return getallheaders();
            }
        }

        /**
         * 统计浏览量
         */
        protected function Counter()
        {
            $five = "00000";//声明变量，$five,$four等变量表示零的个数，放在数字前边构成6位数
            $four = "0000";
            $three = "000";
            $two = "00";
            $one = "0";
            $counter = "rec.txt";//存放访问数的目的文件，.dat格式
            if(!file_exists($counter))//判断文件是否存在
            {
                $counter = fopen($counter,"w");
                $num = 1;
                fputs($counter,"1");//写入文件
                fclose($counter);
                print "$five"."$num";
            }else{
                $fp = fopen($counter,"r+");
                $num = fgets($fp,"1024");//如果文件存在则读出文件，并加 1
                $num = $num + 1;
                if($num < 10)
                    print "$five"."$num";
                elseif($num < 100)
                    print "$four"."$num";
                elseif($num < 1000)
                    print "$three"."$num";
                elseif($num < 10000)
                    print "$two"."$num";
                elseif($num < 100000)
                    print "$one"."$num";
                else
                    print "$num";
            }
            $fp = fopen("$counter","w");
            fputs($fp,"$num");
            fclose($fp);
        }

        /**
         * 写入文本数据
         * @param array  $centent  存储的内容array(网址<http>,浏览量<num>,'\r\n')
         * @param string $counter  指定文件路径
         */
        protected function ftext($centent=array(),$counter=''){
            $counter = empty($counter) ? './http.txt':$counter;
            $five = "00000";    //声明变量，$five,$four等变量表示零的个数，放在数字前边构成6位数
            $four = "0000";
            $three = "000";
            $two = "00";
            $one = "0";
            if(!file_exists($counter)) //判断文件是否存在
            {
                $centent['num']='000001';
                $pcenter=implode(' ',$centent);
                $counter = fopen($counter,"ab");
                return fputs($counter,$pcenter); //写入文件,返回写入数据的数量
                fclose($counter);
            }else{
                $fp = fopen($counter,"r+");
                $num = fgets($fp,"1024");//如果文件存在则读出文件，并加 1
//                echo $num.'<br/>';exit;
                $num = substr(trim($num),-6);
                $num = ltrim($num);
                $num =$num+1;
                if($num < 10){
                    $num = "$five"."$num";
                }else if($num < 100){
                    $num = "$four"."$num";
                }else if($num < 1000){
                    $num = "$three"."$num";
                }else if($num < 10000){
                    $num = "$two"."$num";
                }else if($num < 100000){
                    $num = "$one"."$num";
                }else{
                    $num = "$num";
                }
                $centent['num']=$num;
                $pcenter=implode(' ',$centent);
                return fwrite($fp,$pcenter);//写入文件,返回写入数据的数量
                fclose($fp);
            }
        }

        /**
         * 获取IP地址
         * @return string
         */
        protected function getip()
        {
            $realip='';
            if (isset($_SERVER)){
                //以下三种都是php超全局数组自带的获取ip地址的方法
                if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                    $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                    $realip = $_SERVER["HTTP_CLIENT_IP"];
                } else {
                    $realip = $_SERVER["REMOTE_ADDR"];
                }
            } else {
                //要想透过代理服务器取得客户端的真实 IP 地址，就要使用 getenv("HTTP_X_FORWARDED_FOR") 来读取。但是如果客户端没有通过代理服务器来访问，那么用getenv("HTTP_X_FORWARDED_FOR") 取到的值将是空的。
                if (getenv("HTTP_X_FORWARDED_FOR")){
                    $realip = getenv("HTTP_X_FORWARDED_FOR");
                } else if (getenv("HTTP_CLIENT_IP")) {
                    $realip = getenv("HTTP_CLIENT_IP");
                } else {
                    $realip = getenv("REMOTE_ADDR");
                }
             }
            return $realip;
        }
        /**
         * 接口或url的get 请求
         * @param type $url
         * @param type $param
         * @return type
         */
        function getURL($queryip) {
            $url = 'http://www.ip138.com/ips138.asp?ip='.$queryip.'&action=2';           //新浪ip接口
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            $output = curl_exec($ch);
            return $output;
        }

        /**
         * 接口或url的后台post请求
         */

        function postURL($url, $data, $type = '', $type_data = '')
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_POST, true);
            if ($type == 'PUT' || $type_data=='json') {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            }

            if($type){
                //$type  为'DELETE' OR 'PUT'
                curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST,$type);
            }

            if ($type_data == 'json') {
                $aHeader[] = "Content-Type:application/json;charset=UTF-8";
                curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
            }
            if($type_data == 'urlencoded'){
                $aHeader[] = "Content-Type:application/x-www-form-urlencoded;charset=UTF-8";
                curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
            }
            $response = curl_exec($ch);

            return $response;
        }
    }