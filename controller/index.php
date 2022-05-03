<?php
/**
 * 首页模板入口
 */
//检查认证 wangting, 私人使用强制登录
check_auth($site_setting['user'],$site_setting['password']);
//如果已经登录，获取所有分类和链接
if( is_login() ){
    //查询所有分类目录
    $categorys = $db->select('on_categorys','*',[
        "ORDER" =>  ["weight" => "DESC"]
    ]);
    //查询一级分类目录，分类fid为0的都是一级分类
    $category_parent = $db->select('on_categorys','*',[
        "fid"   =>  0,
        "ORDER" =>  ["weight" => "DESC"]
    ]);
    //根据分类ID查询二级分类，分类fid大于0的都是二级分类
    function get_category_sub($id) {
        global $db;
        $id = intval($id);

        $category_sub = $db->select('on_categorys','*',[
            "fid"   =>  $id,
            "ORDER"     =>  ["weight" => "DESC"]
        ]);

        return $category_sub;
    }

    //根据category id查询链接
    function get_links($fid) {
        global $db;
        $fid = intval($fid);
        $links = $db->select('on_links','*',[ 
                'fid'   =>  $fid,
                'ORDER' =>  ["weight" => "DESC"]
            ]);
        return $links;
    }
    //右键菜单标识
    $onenav['right_menu'] = 'admin_menu();';
}
//如果没有登录，只获取公有链接
else{
    //查询分类目录
    $categorys = $db->select('on_categorys','*',[
        "property"  =>  0,
        "ORDER" =>  ["weight" => "DESC"]
    ]);
    //查询一级分类目录，分类fid为0的都是一级分类
    $category_parent = $db->select('on_categorys','*',[
        "fid"   =>  0,
        'property'  =>  0,
        "ORDER" =>  ["weight" => "DESC"]
    ]);
    //根据分类ID查询二级分类，分类fid大于0的都是二级分类
    function get_category_sub($id) {
        global $db;
        $id = intval($id);

        $category_sub = $db->select('on_categorys','*',[
            "fid"   =>  $id,
            'property'  =>  0,
            "ORDER"     =>  ["weight" => "DESC"]
        ]);

        return $category_sub;
    }
    //根据category id查询链接
    function get_links($fid) {
        global $db;
        $fid = intval($fid);
        $links = $db->select('on_links','*',[ 
            'fid' =>  $fid,
            'property'  =>  0,
            'ORDER' =>  ["weight" => "DESC"]
        ]);
        return $links;
    }
    //右键菜单标识
    $onenav['right_menu'] = 'user_menu();';
}


//获取访客IP
function getIP() { 
    if (getenv('HTTP_CLIENT_IP')) { 
    $ip = getenv('HTTP_CLIENT_IP'); 
  } 
  elseif (getenv('HTTP_X_FORWARDED_FOR')) { 
      $ip = getenv('HTTP_X_FORWARDED_FOR'); 
  } 
      elseif (getenv('HTTP_X_FORWARDED')) { 
      $ip = getenv('HTTP_X_FORWARDED'); 
  } 
    elseif (getenv('HTTP_FORWARDED_FOR')) { 
    $ip = getenv('HTTP_FORWARDED_FOR'); 
  } 
    elseif (getenv('HTTP_FORWARDED')) { 
    $ip = getenv('HTTP_FORWARDED'); 
  } 
  else { 
      $ip = $_SERVER['REMOTE_ADDR']; 
  } 
      return $ip; 
  }
//获取版本号
function get_version(){
    if( file_exists('version.txt') ) {
        $version = @file_get_contents('version.txt');
        return $version;
    }
    else{
        $version = 'null';
        return $version;
    }
} 
//判断用户是否已经登录
function is_login(){
    $key = md5(USER.PASSWORD.'onenav');
    //获取session
    $session = $_COOKIE['key'];
    //如果已经成功登录
    if($session == $key) {
        return true;
    }
    else{
        return false;
    }
}
//将URL转换为base64编码
function base64($url){
    $urls = parse_url($url);

    //获取请求协议
    $scheme = empty( $urls['scheme'] ) ? 'http://' : $urls['scheme'].'://';
    //获取主机名
    $host = $urls['host'];
    //获取端口
    $port = empty( $urls['port'] ) ? '' : ':'.$urls['port'];

    $new_url = $scheme.$host.$port;
    return base64_encode($new_url);
}

//获取版本号
$version = get_version();
//载入js扩展
if( file_exists('data/extend.js') ) {
    $onenav['extend'] = '<script src = "data/extend.js"></script>';
}
else{
    $onenav['extend'] = '';
}


// 载入前台首页模板
//查询主题设置
$template = $db->get("on_options","value",[
    "key"   =>  "theme"
]);
//获取当前站点信息
$site = $db->get('on_options','value',[ 'key'  =>  "s_site" ]);
$site = unserialize($site);

//判断文件夹是否存在
if( is_dir('templates/'.$template) ){
    $tpl_dir = 'templates/';
}
else{
    $tpl_dir = 'data/templates/';
}

/**
 * 检查授权
 */

function check_auth($user,$password){
    $ip = getIP();
    $key = md5($user.$password.'onenav');
    //获取cookie
    $cookie = $_COOKIE['key'];
    //如果cookie的值和计算的key不一致，则没有权限
    if( $cookie !== $key ){
        $msg = "<h3>认证失败，请<a href = 'index.php?c=login'>重新登录</a>！</h3>";
        require('templates/admin/403.php');
        exit;
    }
}


require($tpl_dir.$template.'/index.php');
?>
