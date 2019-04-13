<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2019/4/8
 * Time: 17:30
 * @see http://www.ruanyifeng.com/blog/2017/08/elasticsearch.html
 */

require_once 'Curl.php';

$base_uri = "http://localhost:9200";

$curl = new Curl($base_uri);

## Index
//查看当前节点的所有 Index
// curl -X GET 'http://localhost:9200/_cat/indices?v'
//$res = $curl->request('/_cat/indices?v', 'GET');
//var_dump($res);

### 新建Index
// curl -X PUT 'localhost:9200/weather'
//$res = $curl->request('/weather', 'PUT');
//var_dump($res);

### 删除Index
// curl -X DELETE 'localhost:9200/weather'
//$res = $curl->request('/weather', 'DELETE');
//var_dump($res);

## 中文分词
// 安装安装中文分词插件ik
// elasticsearch-plugin install https://github.com/medcl/elasticsearch-analysis-ik/releases/download/v5.6.16/elasticsearch-analysis-ik-5.6.16.zip

//新建一个 Index，指定需要分词的字段
/* curl -X PUT 'localhost:9200/accounts' -d '
{
  "mappings": {
    "person": {
      "properties": {
        "user": {
          "type": "text",
          "analyzer": "ik_max_word",
          "search_analyzer": "ik_max_word"
        },
        "title": {
          "type": "text",
          "analyzer": "ik_max_word",
          "search_analyzer": "ik_max_word"
        },
        "desc": {
          "type": "text",
          "analyzer": "ik_max_word",
          "search_analyzer": "ik_max_word"
        }
      }
    }
  }
}'*/
//$res = $curl->request('/accounts', 'PUT', '{
//  "mappings": {
//    "person": {
//        "properties": {
//            "user": {
//                "type": "text",
//          "analyzer": "ik_max_word",
//          "search_analyzer": "ik_max_word"
//        },
//        "title": {
//                "type": "text",
//          "analyzer": "ik_max_word",
//          "search_analyzer": "ik_max_word"
//        },
//        "desc": {
//                "type": "text",
//          "analyzer": "ik_max_word",
//          "search_analyzer": "ik_max_word"
//        }
//      }
//    }
//  }
//}');
//var_dump($res);

//上面代码中，首先新建一个名称为accounts的 Index，里面有一个名称为person的 Type。person有三个字段 user、title、desc 这三个字段都是中文，而且类型都是文本（text），所以需要指定中文分词器，不能使用默认的英文分词器。

## 数据操作

### 新增记录
//向指定的 /Index/Type 发送 PUT 请求，就可以在 Index 里面新增一条记录
/* curl -X PUT 'localhost:9200/accounts/person/1' -d '
{
  "user": "张三",
  "title": "工程师",
  "desc": "数据库管理"
}' */
//$res = $curl->request('/accounts/person/1', 'PUT', '{
//  "user": "张三",
//  "title": "工程师",
//  "desc": "数据库管理"
//}');
//var_dump($res);

//新增记录的时候，也可以不指定 Id，这时要改成 POST 请求
//$res = $curl->request('/accounts/person', 'POST', '{
//  "user": "李四",
//  "title": "工程师",
//  "desc": "数据库管理"
//}');
//var_dump($res);

### 查看记录
// 向/Index/Type/Id发出 GET 请求，就可以查看这条记录
// curl 'localhost:9200/accounts/person/1?pretty=true'
//$res = $curl->request('/accounts/person/1', 'GET');
//var_dump($res);

### 删除记录
// curl -X DELETE 'localhost:9200/accounts/person/1'
//$res = $curl->request('/accounts/person/1', 'DELETE');
//var_dump($res);

### 更新记录
//$res = $curl->request('/accounts/person/1?pretty=true', 'PUT', '{
//  "user": "张三1",
//  "title": "工程师1",
//  "desc": "数据库管理1"
//}');
//var_dump($res);

## 数据查询

### 返回所有记录
// curl 'localhost:9200/accounts/person/_search'
//$res = $curl->request('/accounts/person/_search?pretty=true', 'GET');
//var_dump($res);

### 全文搜索
/* curl 'localhost:9200/accounts/person/_search'  -d '
{
  "query" : { "match" : { "desc" : "软件" }}
}' */
//$res = $curl->request('/accounts/person/_search?pretty=true', 'GET', '{
//  "query" : { "match" : { "desc" : "数据库" }},
//  "size": 5,
//  "from": 1
//}');
//var_dump($res);

### 逻辑运算
//如果有多个搜索关键字， Elastic 认为它们是or关系
/* curl 'localhost:9200/accounts/person/_search'  -d '
{
  "query" : { "match" : { "desc" : "软件 系统" }}
}'*/
//$res = $curl->request('/accounts/person/_search?pretty=true', 'GET', '{
//  "query" : { "match" : { "desc" : "数据库 1" }}
//}');
//var_dump($res);

//如果要执行多个关键词的and搜索，必须使用布尔查询。
/*
curl 'localhost:9200/accounts/person/_search'  -d '
{
  "query": {
    "bool": {
      "must": [
        { "match": { "desc": "软件" } },
        { "match": { "desc": "系统" } }
      ]
    }
  }
}'
*/
//$res = $curl->request('/accounts/person/_search?pretty=true', 'GET', '{
//  "query": {
//    "bool": {
//      "must": [
//        { "match": { "desc": "数据库" } },
//        { "match": { "desc": "1" } }
//      ]
//    }
//  }
//}');
//var_dump($res);


