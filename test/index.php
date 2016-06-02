<?php

namespace WWD\test;
use WWD\Log;


include '../vendor/autoload.php';
$log = new Log();

Log::record('严重错误: 导致系统崩溃无法使用',Log::ALERT);
Log::record('警戒性错误: 必须被立即修改的错误',Log::ALERT);
Log::record('临界值错误: 超过临界值的错误，例如一天24小时，而输入的是25小时这样',Log::CRIT);
Log::record('一般错误: 一般性错误',Log::ERR);
Log::record('警告性错误: 需要发出警告的错误',Log::WARN);
Log::record('通知: 程序可以运行但是还不够完美的错误',Log::NOTICE);
Log::record('信息: 程序输出信息',Log::INFO);
Log::record('调试: 调试信息',Log::DEBUG);
Log::record('SQL：SQL语句 注意只在调试模式开启时有效',Log::SQL);
Log::save();


