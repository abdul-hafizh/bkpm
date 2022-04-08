<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 10/11/17
 * Time: 19:39
 */

if( ! function_exists('responseMessage') )
{
    function responseMessage($message,$otherArray=[]){
        return array_merge(['message'=>$message],$otherArray);
    }
}

if( ! function_exists('responseException') )
{
    function responseException($message){
        if(app()->request()->isAjax()){
            return responseError($message);
        }
        throw new \ErrorException($message);
    }
}