<?php
/**
 * Created by PhpStorm.
 * User: jlxh
 * Date: 04/09/17
 * Time: 下午 06:32
 */

namespace frontend\service;

use Yii;

class StaticService
{
    //使用yii统一方法加载js或css
    public static function includeAppStatic($type, $path, $depend)
    {
        $releaseVersion = defined("RELEASE_VERSION") ? RELEASE_VERSION : '20170904';
        if (stripos($path, '?') !== false) {
            $path = $path."&version={$releaseVersion}";
        } else {
            $path = $path."?version={$releaseVersion}";
        }

        if ($type == "css") {
            Yii::$app->getView()->registerCssFile($path, ['depends' => $depend]);
        } else {
            Yii::$app->getView()->registerJsFile($path, ['depends' => $depend]);
        }
    }

    public static function includeAppJsStatic($path, $depend)
    {
        self::includeAppStatic('js', $path, $depend);
    }

    public static function includeAppCssStatic($path, $depend)
    {
        self::includeAppStatic('css', $path, $depend);
    }
}