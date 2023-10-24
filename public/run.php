<?php
/**
 * @Author: dray
 * @Date:   2016-05-03 09:29:59
 * @Last Modified by:   dray
 * @Last Modified time: 2016-05-15 14:30:16
 */

//加载包文件
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'init.php';

//清理 redis router 配置
$bot = Db::get_bot_name();
$redis = Db::get_redis();
$redis->del("{$bot}config:router");

// 开始循环处理数据
while (true) {
    Process::run();
}
