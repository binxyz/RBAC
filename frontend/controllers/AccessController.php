<?php
namespace frontend\controllers;

use app\models\Access;
use frontend\controllers\common\BaseController;

class AccessController extends BaseController
{
    public function actionIndex()
    {
        $list = Access::find()->where(['status' => 1])->orderBy(['id' => SORT_DESC])->all();
        return $this->render('index', ['list' => $list]);
    }

    public function actionSet()
    {
        if (\Yii::$app->request->isGet) {
            $id = $this->get('id', 0);
            $info = [];
            if ($id) {
                $info = Access::find()->where(['id' => $id])->one();
            }

            return $this->render('set', [
                'info' => $info
            ]);
        }

        $id = $this->post('id', 0);
        $title = $this->post('title', '');
        $urls = $this->post('urls', '');
        $time = date('Y-m-d H:i:s');

        if (mb_strlen($title, 'utf-8') < 1 || mb_strlen($title, 'utf-8') > 20) {
            return $this->renderJSON([], '请输入合法的权限名称', -1);
        }

        if (!$urls) {
            return $this->renderJSON([], '请输入合法的urls', -1);
        }

        $urls = explode("\n", $urls);

        if (!$urls) {
            return $this->renderJSON([], '请输入合法的urls', -1);
        }

        $accessInfo = Access::find()
            ->where(['title' => $title])
            ->andWhere(['!=', 'id', $id])
            ->one();
        if ($accessInfo) {
            return $this->renderJSON([], '该权限名称已存在', -1);
        }

        $info = Access::find()->where(['id' => $id])->one();
        if ($info) { //编辑
            $accessModel = $info;
        } else {
            $accessModel = new Access();
            $accessModel->create_time = $time;
            $accessModel->status = 1;
        }

        $accessModel->title = $title;
        $accessModel->urls = json_encode($urls);
        $accessModel->update_time = $time;

        $accessModel->save();
        return $this->renderJSON([], '操作成功', 200);
    }
}