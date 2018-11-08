<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/11/8
 * Time: 17:20
 */

require_once 'src/IndexController.php';
require_once 'src/LoginController.php';


$dst = (new ApiDocCodeGenerator)->generate(\Api\LoginController::class);
var_dump($dst);

class ApiDocCodeGenerator{

    public function generate($className){
        $ref = new \ReflectionClass($className);

        $dst['apiGroupName'] = $this->parseGroup($ref->getDocComment());

        $dst['apiList'] = [];

        foreach ($ref->getMethods() as $method){
            //var_dump(parse_method($method->getDocComment()));
            $dst['apiList'][] = $this->parseMethod($method->getDocComment());
        }
        return $dst;
    }

    protected function parseGroup($string){
        $res = preg_match("#\* @apiGroupName (.*)#", $string, $matches);
        if($res){
            return $matches[1];
        }
        return '';
    }

    protected function parseMethod($string){
        $dst = [];
        $dst['name'] = '';
        $res = preg_match("#\* @apiName (.*)#", $string, $matches);
        if($res){
            $dst['name'] = $matches[1];
        }

        $dst['url'] = '';
        $res = preg_match("#\* @apiUrl (.*)#", $string, $matches);
        if($res){
            $dst['url'] = $matches[1];
        }

        $dst['method'] = '';
        $res = preg_match("#\* @apiMethod (.*)#", $string, $matches);
        if($res){
            $dst['method'] = $matches[1];
        }

        $dst['params'] = [];
        $res = preg_match_all("#\* @apiParam (.*)#", $string, $matches);
        if($res){
            $dst['params'] = $this->parseParams($matches[1]);
        }

        return $dst;
    }

    protected function parseParams($params){
        $dst = [];
        foreach($params as $param){
            $tmpArr = explode(' ', trim($param));
            //var_dump($tmpArr)
            $dst[] = [
                'type'=>$tmpArr[0] ?? '',
                'field'=>$tmpArr[1] ?? '',
                'desc'=>$tmpArr[2] ?? '',
            ];
        }
        return $dst;
    }
}


