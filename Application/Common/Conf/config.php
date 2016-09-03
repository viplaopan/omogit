<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

/**
 * 系统配文件
 * 所有系统级别的配置
 */
return array(
    /* 模块相关配置 */
    'AUTOLOAD_NAMESPACE' => array('Addons' => ONETHINK_ADDON_PATH), //扩展模块列表
    'DEFAULT_MODULE'     => 'Home',
    'MODULE_DENY_LIST'   => array('Common','User','Admin','Install'),
    //'MODULE_ALLOW_LIST'  => array('Home','Admin'),

    /* 系统数据加密设置 */
    'DATA_AUTH_KEY' => 'qy8@xhX1(6T#"*>-,~.A2K[]n}l|<DsRYbctZ4e{', //默认数据加密KEY

    /* 用户相关设置 */
    'USER_MAX_CACHE'     => 1000, //最大缓存用户数
    'USER_ADMINISTRATOR' => 1, //管理员用户ID

    /* URL配置 */
    'URL_CASE_INSENSITIVE' => true, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'            => 2, //URL模式
    'VAR_URL_PARAMS'       => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR'    => '/', //PATHINFO URL分割符

    /* 全局过滤配置 */
    'DEFAULT_FILTER' => '', //全局过滤函数

    /* 数据库配置 */
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'ohmyoffice_db', // 数据库名
    'DB_USER'   => 'homestead', // 用户名
    'DB_PWD'    => 'secret',  // 密码
    'DB_PORT'   => '33060', // 端口
    'DB_PREFIX' => 'xh_', // 数据库表前缀
    /*
	'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '47.90.4.173', // 服务器地址
    'DB_NAME'   => 'ohmyoffice_db', // 数据库名
    'DB_USER'   => 'ohmyoffice', // 用户名
    'DB_PWD'    => 'Pa1234560d31f219',  // 密码
    'DB_PORT'   => '3306', // 端口
    'DB_PREFIX' => 'xh_', // 数据库表前缀
	*/
	
    'LOAD_EXT_CONFIG' => 'router',

    /* 文档模型配置 (文档模型核心配置，请勿更改) */
    'DOCUMENT_MODEL_TYPE' => array(2 => '主题', 1 => '目录', 3 => '段落'),
);
