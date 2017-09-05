<?php
use frontend\service\UrlService;
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">角色列表</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <a href="<?=UrlService::buildUrl('/role/set')?>" class="btn btn-primary">添加兑换信息</a>
    </div>
    <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
            <tr>
                <th>角色名</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if($list):?>

                <?php foreach($list as $item):?>
                    <tr class="odd gradeX">
                        <td><?=$item['name'];?></td>
                        <td>
                            <a href="<?=UrlService::buildUrl('role/set', ['id' => $item['id']])?>">编辑</a>
                            <a href="<?=UrlService::buildUrl('role/access', ['id' => $item['id']])?>">设置权限</a>
                        </td>
                    </tr>
                <?php endforeach;?>
            <?php else:?>
                <tr class="odd gradeX">
                    <td colspan="2">无数据</td>
                </tr>
            <?php endif;?>
            </tbody>
        </table>
    </div>
</div>