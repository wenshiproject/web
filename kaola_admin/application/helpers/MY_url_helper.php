<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 创建URL，创建后的链接格式如 helper/code?check=1
 * 
 * @param string $route 路由地址
 * @param array $params 参数
 * @param string $ampersand 默认连接符
 * @return string
 */
function create_url($route, $params = array(), $ampersand = '&')
{
    $route = base_url($route);
    if(is_array($params) && count($params) > 0) {
        $route .= "?";
        foreach($params as $key => $val) {
            $route .= $key.'='.$val.$ampersand;
        }
        $route = substr($route, 0, -1);
    }
    return $route;
}

/**
 * 获取当前页面地址，包含参数
 * @return string
 * @return 当前地址
 */
function get_current_url()
{
    $page_url = 'http://';
    if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
        $page_url = "https://";
    }
    if($_SERVER["SERVER_PORT"] != "80") {
        $page_url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $page_url .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $page_url;
}