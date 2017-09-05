<?php

namespace frontend\controllers;

use app\models\Role;
use app\models\UserRole;
use frontend\controllers\common\BaseController;
use app\models\User;
use frontend\service\UrlService;

class UserController extends BaseController
{
    public function actionIndex()
    {
        $list = User::find()->where(['status' => 1])->orderBy(['id' => SORT_DESC])->all();
        return $this->render('index', ['list' => $list]);
    }

    public function actionSet()
    {
        if (\Yii::$app->request->isGet) {
            $id = $this->get('id', 0);
            $info = [];
            if ($id) {
                $info = User::find()->where(['status' => 1,'id' => $id])->one();
            }

            $roleList = Role::find()->orderBy(['id' => SORT_DESC])->all();

            $userRoleList = UserRole::find()->where(['uid' => $id])->asArray()->all();
            $userRoleIds = array_column($userRoleList, 'role_id');
            return $this->render('set', [
                'info' => $info,
                'roleList' => $roleList,
                'userRoleIds' => $userRoleIds
            ]);
        }

        $id = $this->post('id', 0);
        $name = $this->post('name', '');
        $email = $this->post('email', '');
        $roleIds = $this->post('roleIds', []);
        if (mb_strlen($name, 'utf-8') < 1 || mb_strlen($name, 'utf-8') > 20) {
            return $this->renderJSON([], '请输入合法的用户名称', -1);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->renderJSON([], '请输入合法的邮箱', -1);
        }

        //查询是否角色名相等的记录
        $has = User::find()
            ->where(['email' => $email])
            ->andWhere(['!=', 'id', $id])
            ->count();
        if ($has) {
            return $this->renderJSON([], '该邮箱已存在', -1);
        }

        $info = User::find()->where(['id' => $id])->one();
        if ($info) { //编辑
            $userModel = $info;
        } else {
            $userModel = new User();
            $userModel->status = 1;
            $userModel->create_time = date('Y-m-d H:i:s');
        }

        $userModel->name = $name;
        $userModel->email = $email;
        $userModel->update_time = date('Y-m-d H:i:s');
        if ($userModel->save()) {

            $userRoleList = UserRole::find()->where(['uid' => $userModel->id])->all();
            $relateRoleIds = [];
            if ($userRoleList) {
                foreach($userRoleList as $item) {
                    $relateRoleIds[] = $item['id'];
                    if (!in_array($item['id'], $roleIds)) {
                        $item->delete();
                    }
                }
            }

            if ($roleIds) {
                foreach($roleIds as $role) {
                    if (!in_array($role, $relateRoleIds)) {
                        $userRoleModel = new UserRole();
                        $userRoleModel->uid = $userModel->id;
                        $userRoleModel->role_id = $role;
                        $userRoleModel->create_time = date('Y-m-d H:i:s');
                        $userRoleModel->save();
                    }
                }
            }
        }

        return $this->renderJSON([], '操作成功', 200);
    }

    public function actionLogin()
    {
        return $this->render('login');
    }

    public function actionVlogin()
    {
        $uid = $this->get('uid', 0);
        $rebackUrl = UrlService::buildUrl("/");
        if (!$uid) {
            return $this->redirect($rebackUrl);
        }

        $userInfo = User::find()->where(['id' => $uid])->one();
//        var_dump($userInfo);die;
        if (!$userInfo){
            return $this->redirect($rebackUrl);
        }
        //伪登录cookie保存用户登录态,加密
        $this->createLoginStatus($userInfo);

        return $this->redirect($rebackUrl);
    }
}