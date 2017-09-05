<?php

namespace frontend\service;

use yii\helpers\Url;

//统一管理链接，并规范书写　
class UrlService
{
    public static function buildUrl($uri, $params = [])
    {
        return Url::toRoute(array_merge([$uri], $params));
    }

    public static function buildNullUrl()
    {
        return "javascript:void(0);";
    }
}