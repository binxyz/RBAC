<?php
use frontend\service\UrlService;
use frontend\service\StaticService;
//Yii::$app->getView()->registerJs('/js/role/set.js', \frontend\assets\AppAsset::className());
StaticService::includeAppJsStatic('/js/user/set.js', \frontend\assets\AppAsset::className())
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">添加用户</h1>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <form>

            <!-- end modal -->
            <div class="form-group">
                <label>姓名</label>
                <input class="form-control" type="text" name="name" placeholder="请输入姓名"
                       value="<?=$info ? $info['name'] : '';?>">
            </div>

            <div class="form-group">
                <label>邮箱</label>
                <input class="form-control" type="text" name="email" placeholder="请输入邮箱"
                       value="<?=$info ? $info['email'] : '';?>">
            </div>

            <div class="form-group">
                <label>所属角色</label>
                <div>
                    <?php if($roleList):?>
                        <?php foreach($roleList as $item):?>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="roleIds[]" value="<?=$item['id']?>"
                                <?php if(in_array($item['id'], $userRoleIds)):?> checked <?php endif;?>><?=$item['name']?>
                            </label>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>

            </div>
            <input type="hidden" name="id" value="<?=$info ? $info['id'] : '';?>">
            <button type="button" class="btn btn-primary pull-right set">提交</button>
        </form>
    </div>
</div>