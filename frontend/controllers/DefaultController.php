<?php

namespace frontend\controllers;

use frontend\controllers\common\BaseController;

class DefaultController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}