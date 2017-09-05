<?php
/**
 * Created by PhpStorm.
 * User: jlxh
 * Date: 04/09/17
 * Time: 下午 05:58
 */

namespace frontend\controllers;


use app\models\Access;
use app\models\Role;
use app\models\RoleAccess;
use frontend\controllers\common\BaseController;

class RoleController extends BaseController
{
    public function actionIndex()
    {
        $list = Role::find()->orderBy(['id' => SORT_DESC])->all();
        return $this->render('index', ['list' => $list]);
    }

    public function actionSet()
    {
        if (\Yii::$app->request->isGet) {
            $id = $this->get('id', 0);
            $info = [];
            if ($id) {
                $info = Role::find()->where(['id' => $id])->one();
            }

            return $this->render('set', [
                'info' => $info
            ]);
        }

        $id = $this->post('id', 0);
        $name = $this->post('name', '');
        if (!$name) {
            return $this->renderJSON([], '请输入合法的角色名称', -1);
        }

        //查询是否角色名相等的记录
        $roleInfo = Role::find()
            ->where(['name' => $name])
            ->andWhere(['!=', 'id', $id])
            ->one();
        if ($roleInfo) {
            return $this->renderJSON([], '该角色名称已存在', -1);
        }

        $info = Role::find()->where(['id' => $id])->one();
        if ($info) { //编辑
            $roleModel = $info;
        } else {
            $roleModel = new Role();
            $roleModel->create_time = date('Y-m-d H:i:s');
        }

        $roleModel->name = $name;
        $roleModel->update_time = date('Y-m-d H:i:s');

        $roleModel->save();
        return $this->renderJSON([], '操作成功', 200);
    }

    //设置角色权限关系
    public function actionAccess()
    {
        if (\Yii::$app->request->isGet) {
            $id = $this->get('id', 0); //role_id
            $info = [];
            if ($id) {
                $info = Role::find()->where(['id' => $id])->one();
            }
//            echo $id;die;
            $accessList = Access::find()->where(['status' => 1])->orderBy(['id' => SORT_DESC])->all();
            $roleAccessList = RoleAccess::find()->where(['role_id' => $id])->asArray()->all();
            $accessIds = array_column($roleAccessList, 'access_id');
            return $this->render('access', [
                'info' => $info,
                'accessList' => $accessList,
                'accessIds' => $accessIds
            ]);
        }

        $id = $this->post('id', 0);
        $accessIds = $this->post('accessIds', '');

        if (!$id) {
            return $this->renderJSON([], '您指定的角色不存在', -1);
        }

        $info = Role::find()->where(['id'=>$id])->one();
        if (!$info) {
            return $this->renderJSON([], '您指定的角色不存在', -1);
        }

        $roleAccessList = RoleAccess::find()->where(['role_id' => $id])->asArray()->all();
        $assignAccessIds = array_column($roleAccessList, 'access_id');
        $deleteAccessIds = array_diff($assignAccessIds, $accessIds);

        if ($deleteAccessIds) {
            RoleAccess::deleteAll(['role_id' => $id, 'access_id' => $deleteAccessIds]);
        }

        $newAccessIds = array_diff($accessIds, $assignAccessIds);
        if ($newAccessIds) {
            foreach($newAccessIds as $accessIds) {
                $roleAccessModel = new RoleAccess();
                $roleAccessModel->role_id = $id;
                $roleAccessModel->access_id = $accessIds;
                $roleAccessModel->create_time = date('Y-m-d H:i:s');
                $roleAccessModel->save();
            }
        }

        return $this->renderJSON([], '操作成功', 200);

    }
}