<?php
/**
 * Created by PhpStorm.
 * User: jlxh
 * Date: 06/09/17
 * Time: 上午 06:57
 */

namespace frontend\controllers;


use frontend\controllers\common\BaseController;

class ErrorController extends BaseController
{
    public function actionForbidden()
    {
        return $this->render('index');
    }
}