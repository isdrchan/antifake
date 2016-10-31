# 基于微信的防伪查询demo
  - 基于ThinkPHP
  - 验证字符串300s过期
  - 记录查询次数、IP、坐标、地理信息

## 流程
  请求带参数的URL获取随机验证字符串，粘贴到微信公众号返回结果，点击结果跳转到详情页面

## 配置
  - PHP + MySQL
  - SQL : /Application/Common/Conf/config.php
  - 高德Web服务API Key : /Application/Common/Conf/config.php Line:52
  - 微信 : /Application/Wechat/Controller/IndexController.class.php

## 用法
  - 后台 : (YOUR_URL)/admin
  - 获取 : (YOUR_URL)/?id=(RANDOM_STRING)
  - 验证 : (YOUR_URL)/index.php/Home/Index/query/random/(RANDOM_STRING)