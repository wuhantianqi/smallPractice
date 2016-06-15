<?php
/**
 * 使用正则千万记住要使用修饰符,否则写对了正则也匹配不上
 * @param $queryip
 * @return mixed
 */
    function getURL($queryip) {
        $url = $queryip;           //新浪ip接口
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $output = curl_exec($ch);
        return $output;
    }
    $queryip = "http://php.weather.sina.com.cn/xml.php?city=%B1%B1%BE%A9&password=DJOYnieT8234jlsK&day=0";
    $content = getURL($queryip);
    echo $content;
//    $pattern = '/北京.*无持续风向/Usi'; //
    $pattern = '/北京.*风向/Usi';
    preg_match($pattern, $content, $arr); //# 把文章列表 url 分配给数组$arr(二维数组)
    var_dump($arr);