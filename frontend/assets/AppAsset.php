<?php

namespace frontend\assets;

use frontend\service\UrlService;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
//    public $css = [
//        '/bootstrap/css/bootstrap.min.css',
//    ];
//    public $js = [
//        '/jquery/jquery.min.js',
//        '/bootstrap/js/bootstrap.min.js'
//    ];

    public function registerAssetFiles($view)
    {
        //加版本号变量时对于此重写方法灵活，是浏览器获取最新的文件
        $release = "20170904";
        $this->css = [
            UrlService::buildUrl('/bootstrap/css/bootstrap.min.css?', ['v' => $release]),
            UrlService::buildUrl('/css/app.css')
        ];

        $this->js = [
            UrlService::buildUrl('/jquery/jquery.min.js'),
            UrlService::buildUrl('/bootstrap/js/bootstrap.min.js')
        ];
        parent::registerAssetFiles($view);
    }
}
