<?php

require './vendor/autoload.php';
use phpspider\core\phpspider;
use phpspider\core\requests;

/* Do NOT delete this comment */
/* 不要删除这段注释 */
$configs = [
    'name' => '糗事百科', // 定义当前爬虫名称
    'domains' => [
        'qiushibaike.com',
        'www.qiushibaike.com'
    ], // 定义爬虫爬取哪些域名下的网页, 非域名下的url会被忽略以提高爬取速度 数组类型 不能为空
    'scan_urls' => [
        'http://www.qiushibaike.com/'
    ], // 定义爬虫的入口链接, 爬虫从这些链接开始爬取,同时这些链接也是监控爬虫所要监控的链接 数组类型 不能为空
    'content_url_regexes' => [
        "http://www.qiushibaike.com/article/\d+"
    ], // 定义内容页url的规则内容页是指包含要爬取内容的网页 比如http://www.qiushibaike.com/article/115878724 就是糗事百科的一个内容页
    'list_url_regexes' => [
        "http://www.qiushibaike.com/8hr/page/\d+\?s=\d+"
    ], //定义列表页url的规则 对于有列表页的网站, 使用此配置可以大幅提高爬虫的爬取速率 列表页是指包含内容页列表的网页 比如http://www.qiushibaike.com/8hr/page/2/?s=4867046 就是糗事百科的一个列表页
    'fields' => [
        [
            // 抽取内容页的文章内容
            'name' => "article_content",
            'selector' => "//*[@id='single-next-link']",
            'required' => true
        ],
        [
            // 抽取内容页的文章作者
            'name' => "article_author",
            'selector' => "//div[contains(@class,'author')]//h2",
            'required' => true
        ],
    ], // 定义内容页的抽取规则 规则由一个个field组成, 一个field代表一个数据抽取项
    'log_show' => false, // 是否显示日志 为true时显示调试信息 为false时显示爬取面板
    // 'log_file' => '', // log_file默认路径为data/phpspider.log
    'log_type' => 'error, debug', // 显示和记录的日志类型 普通类型: info 警告类型: warn 调试类型: debug 错误类型: error log_type默认值为空，即显示和记录所有日志类型
    'input_encoding' => 'UTF-8', // 输入编码 input_encoding默认值为null，即程序自动识别页面编码
    'output_encoding' => 'UTF-8', // 输出编码 防止出现乱码,如果设置null则为utf-8
    'tasknum' => 1, // 同时工作的爬虫任务数 需要配合redis保存采集任务数据，供进程间共享使用
    // 'proxy' => ['http://user:pass@host:port'], // 如果爬取的网站根据IP做了反爬虫, 可以设置此项
    'interval' => 1000, // 设置爬取时间间隔为1秒
    'timeout' => 5, // 爬虫爬取每个网页的超时时间5秒,
    'max_try' => 5, // 爬虫爬取每个网页失败后尝试次数 网络不好可能导致爬虫在超时时间内抓取失败, 可以设置此项允许爬虫重复爬取 max_try默认值为0，即不重复爬取
    'max_depth' => 0, // 爬虫爬取网页深度，超过深度的页面不再采集 默认值为0，即不限制
    'max_fields' => 0, // 爬虫爬取内容网页最大条数 抓取到一定的字段后退出 默认值为0，即不限制
    'user_agent' => [phpspider::AGENT_ANDROID],
    // 爬虫爬取网页所使用的浏览器类型
    // phpspider::AGENT_ANDROID, 表示爬虫爬取网页时, 使用安卓手机浏览器
    // phpspider::AGENT_IOS, 表示爬虫爬取网页时, 使用苹果手机浏览器
    // phpspider::AGENT_PC, 表示爬虫爬取网页时, 使用PC浏览器
    // phpspider::AGENT_MOBILE, 表示爬虫爬取网页时, 使用移动设备浏览器
    'client_ip' => [
        '192.168.0.2',
        '192.168.0.3',
        '192.168.0.4'
    ], // 随机伪造IP，用于破解防采集
    'export' => [
        'type' => 'db',
        'table' => '数据表',  // 如果数据表没有数据新增请检查表结构和字段名是否匹配
    ],
    // 爬虫爬取数据导出
    // 导出SQL语句到文件
    // 'export' => array(
    //     'type'  => 'sql',
    //     'file'  => './data/qiushibaike.sql',
    //     'table' => '数据表',
    // )
    // 导出CSV结构数据到文件
    // 'export' => array(
    //     'type' => 'csv',
    //     'file' => './data/qiushibaike.csv', // data目录下
    // )
    'db_config' => [
        'host'  => '127.0.0.1',
        'port'  => 3306,
        'user'  => 'root',
        'pass'  => 'root',
        'name'  => 'demo',
    ], // 数据库配置
];
$spider = new phpspider($configs);
requests::set_timeout([3, 27]); // 同时设置connect和read超时时间
$spider->start();
