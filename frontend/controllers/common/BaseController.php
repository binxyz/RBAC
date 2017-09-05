<?php

namespace frontend\controllers\common;

use app\models\Access;
use app\models\RoleAccess;
use app\models\UserRole;
use common\models\User;
use frontend\service\UrlService;
use Yii;
use yii\rbac\Role;
use yii\web\Controller;

class BaseController extends Controller
{
    protected $authCookieName = 'binbin';
    protected $currentUser = null; //当前登录人信息
    protected $allowAllAction = [
        'user/login',
        'user/vlogin'
    ];

    protected $ignoreUrl = [
        'user/login',
        'user/vlogin',
        'error/forbidden'
    ];

    //本系统所有页面都需要登录才能访问，在框架中加入统一验证方法

    public function beforeAction($action)
    {
        $loginStatus = $this->checkLoginStatus();
        if (!$loginStatus && !in_array($action->uniqueId, $this->allowAllAction)) {
            if (Yii::$app->request->isAjax) {
                $this->renderJSON([], '未登录，请返回用户中心', -302);
            } else {

                $this->redirect(UrlService::buildUrl('/user/login'));
            }

            return false;
        }

        if ($this->currentUser) {
            $privilegeUrls = $this->getRolePrivilege();
            if (in_array($action->getUniqueId(), $this->ignoreUrl)) {

                return true;
            }

            if ($this->currentUser && $this->currentUser['is_admin']) {
                return true;
            }

            if (!in_array($action->getUniqueId(), $privilegeUrls)) {
                $this->redirect(UrlService::buildUrl('/error/forbidden'));
                return false;
            }
        }

        return true;
    }

    public function getRolePrivilege($uid = 0)
    {
        if (!$uid) {
            $uid = $this->currentUser->id;
        }
        $privilegeUrls = [];
        //取出指定用户的所属角色
        $roleId = UserRole::find()->where(['uid' => $uid])->select('role_id')->asArray()->column();
        if ($roleId) { //通过角色取出所属权限关系
            $accessId = RoleAccess::find()->where(['role_id' => $roleId])->select('access_id')->asArray()->column();
//            var_dump($accessId);die;
            //查询权限表找出所有权限链接
            $list = Access::find()->where(['id' => $accessId])->all();
//            var_dump($list);die;
            if ($list) {
                foreach($list as $item) {
                    $urls = json_decode($item['urls'], true);
                    $privilegeUrls = array_merge($privilegeUrls, $urls);
                }
            }
        }

        return  $privilegeUrls;
    }

    protected function checkLoginStatus()
    {
        $request = Yii::$app->request;
        $cookies = $request->cookies;
        $authCookie = $cookies->get($this->authCookieName);

        if (!$authCookie) {
            return false;
        }

        list($authToken, $uid) = explode('#', $authCookie);
        if (!$authToken || !$uid) {
            return false;
        }

        if ($uid && preg_match('/^\d+$/', $uid)) {
            $userInfo = User::findOne(['id' => $uid]);
            if (!$userInfo) {
                return false;
            }

            //校验码
            if($authToken != $this->createAuthToken($userInfo['id'], $userInfo['name'], $userInfo['email'], $_SERVER['HTTP_USER_AGENT'])) {
                return false;
            }

            $this->currentUser = $userInfo;
            $view = Yii::$app->view;
            $view->params['currentUser'] = $userInfo;
            return true;
        }
    }

    public function createLoginStatus($userInfo)
    {
        $userAuthToken = md5($userInfo['id'].$userInfo['name'].$userInfo['email'].$_SERVER['HTTP_USER_AGENT']);
        $cookieTarget = \Yii::$app->response->cookies;
        $cookieTarget->add(new \yii\web\Cookie([
            'name' => 'binbin',
            'value' => $userAuthToken.'#'.$userInfo['id']
        ]));
    }

    public function createAuthToken($uid, $name, $email, $userAgent)
    {
        return md5($uid.$name.$email.$userAgent);
    }
    //统一获取post参数方法
    public function post($key, $default = '')
    {
        return Yii::$app->request->post($key, $default);
    }

    //统一获取get参数方法
    public function get($key, $default = '')
    {
        return Yii::$app->request->get($key, $default);
    }

    //封装json返回值，主要用于ajax和后端交互返回格式
    protected function renderJSON($data = [], $msg = "ok", $code = 200)
    {
        header('Content-type:application/json'); //设置头部内容格式
        echo json_encode([
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'req_id' => uniqid()
        ]);
        return Yii::$app->end(); //终止请求，立即返回
    }
}