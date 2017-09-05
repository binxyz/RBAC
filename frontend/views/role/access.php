<?php
use frontend\service\UrlService;
use frontend\service\StaticService;
//Yii::$app->getView()->registerJs('/js/role/set.js', \frontend\assets\AppAsset::className());
StaticService::includeAppJsStatic('/js/role/access.js', \frontend\assets\AppAsset::className())
?>
<div class="row">
    <div class="col-lg-12">

        <h1 class="page-header">为<?=$info['name'];?>添加权限</h1>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <form>
            <!-- end modal -->
            <div class="form-group">
                <label>权限列表</label>
                <div>
                    <?php if($accessList):?>
                        <?php foreach($accessList as $item):?>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="accessIds[]" value="<?=$item['id']?>"
                                <?php if(in_array($item['id'], $accessIds)):?> checked <?php endif;?>> <?=$item['title']?>
                            </label>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>
            <input type="hidden" name="id" value="<?=$info['id']?>">
            <button type="button" class="btn btn-primary pull-right set">提交</button>
        </form>
    </div>
</div>