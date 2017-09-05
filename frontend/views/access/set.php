<?php
use frontend\service\UrlService;
use frontend\service\StaticService;
//Yii::$app->getView()->registerJs('/js/role/set.js', \frontend\assets\AppAsset::className());
StaticService::includeAppJsStatic('/js/access/set.js', \frontend\assets\AppAsset::className())
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">添加权限</h1>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body"
    <form>

        <!-- end modal -->
        <div class="form-group">
            <label>权限</label>
            <input class="form-control" type="text" name="title" placeholder="请输入权限名"
                   value="<?=$info ? $info['title'] : '';?>">
        </div>
        <?php
        $urls = isset($info['urls']) ? json_decode($info['urls'], true) : [];
        $urls = $urls ? $urls : [];
        ?>
        <div class="form-group">
            <label>Urls</label>
            <textarea class="form-control" rows="5" name="urls"><?=implode("\r\n", $urls);?></textarea>
        </div>
        <input type="hidden" name="id" value="<?=$info ? $info['id'] : '';?>">
        <button type="button" class="btn btn-primary pull-right set">提交</button>
    </form>

</div>
</div>