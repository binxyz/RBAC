<?php
use frontend\service\UrlService;
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">权限列表</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <a href="<?=UrlService::buildUrl('/access/set')?>" class="btn btn-primary">添加权限</a>
    </div>
    <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
            <tr>
                <th>权限名</th>
                <th>Urls</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if($list):?>

                <?php foreach($list as $item):?>
                    <?php
                    $urls = json_decode($item['urls'], true);
                    $urls = implode("<br/>", $urls);
                    ?>
                    <tr class="odd gradeX">
                        <td><?=$item['title'];?></td>
                        <td><?=$urls;?></td>
                        <td>
                            <a href="<?=UrlService::buildUrl('access/set', ['id' => $item['id']])?>">编辑</a>
                        </td>
                    </tr>
                <?php endforeach;?>
            <?php else:?>
                <tr class="odd gradeX">
                    <td colspan="3">无数据</td>
                </tr>
            <?php endif;?>
            </tbody>
        </table>
    </div>
</div>