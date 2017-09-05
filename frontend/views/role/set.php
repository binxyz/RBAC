<?php
use frontend\service\UrlService;
use frontend\service\StaticService;
//Yii::$app->getView()->registerJs('/js/role/set.js', \frontend\assets\AppAsset::className());
StaticService::includeAppJsStatic('/js/role/set.js', \frontend\assets\AppAsset::className())
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">添加角色</h1>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <form>

            <!-- end modal -->
            <div class="form-group">
                <label>角色</label>
                <input class="form-control" type="text" name="name" placeholder="请输入角色名"
                value="<?=$info ? $info['name'] : '';?>">
            </div>
            <input type="hidden" name="id" value="<?=$info ? $info['id'] : '';?>">
            <button type="button" class="btn btn-primary pull-right set">提交</button>
        </form>

    </div>
</div>