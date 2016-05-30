<?php
/**
 * @var yii\web\View $this
 */
$this->title = yii::t('conf', 'index');
use yii\helpers\Url;
?>
<div class="box">
    <div class="box-header">
        <form action="/conf/" method="POST">
            <input type="hidden" value="<?= \Yii::$app->request->getCsrfToken(); ?>" name="_csrf">
            <div class="col-xs-12 col-sm-8" style="padding-left: 0;margin-bottom: 10px;">
                <div class="input-group">
                    <input type="text" name="kw" class="form-control search-query" placeholder="<?= yii::t('conf', 'index search placeholder') ?>">
                    <span class="input-group-btn">
                        <button type="submit"
                                class="btn btn-default btn-sm">
                            Search
                            <i class="icon-search icon-on-right bigger-110"></i>
                        </button>
                    </span>
                </div>
            </div>
        </form>
        <a class="btn btn-default btn-sm" href="<?= Url::to('@web/conf/edit') ?>">
            <i class="icon-pencil align-top bigger-125"></i>
            <?= yii::t('conf', 'create project') ?>
        </a>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive no-padding clearfix">
        <table class="table table-striped table-bordered table-hover">
            <tbody><tr>
                <th>playbook剧本</th>
                <th>自定义脚本</th>
                <th>停服执行的mysql</th>
                <th>开服执行的mysql</th>
                <th>开服httpurl</th>
                <th>svn 版本号</th>
                <th><?= yii::t('conf', 'p_status') ?></th>
                <th><?= yii::t('conf', 'p_opera') ?></th>
            </tr>
            <?php foreach ($list as $item) { ?>
                <tr>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['custom_order'] ?></td>
                    <td><?= $item['stop_server_mysql'] ?></td>
                    <td><?= $item['running_server_mysql'] ?></td>
                    <td><?= $item['running_httpurl'] ?></td>
                    <td><?= $item['version'] ?></td>
                    <td><?= $item['status'] ?></td>
                    
                    
                    <td class="<?= \Yii::t('w', 'conf_status_' . $item['status'] . '_color') ?>">
                        <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                            
                           
                            <a href="<?= Url::to("@web/playbook/edit?projectId={$item['id']}") ?>">
                                <i class="icon-pencil bigger-130"></i>
                                <?= yii::t('conf', 'p_edit') ?>
                            </a>
                            <a class="red btn-delete" data-id="<?= $item['id'] ?>" href="javascript:;">
                                <i class="icon-trash bigger-130"></i>
                                <?= yii::t('conf', 'p_delete') ?>
                            </a>
                           
                            <a class="red toconf" data-id="<?= $item['id'] ?>" href="javascript:;">
                                <i class="icon-trash bigger-130"></i>
                                <?= yii::t('w', 'write to conf') ?>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- 模态框（Modal） -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        </div>

    </div><!-- /.box-body -->
</div>

<script>
    jQuery(function($) {
        $('.btn-delete').click(function(e) {
            $this = $(this);
            if (confirm('<?= yii::t('conf', 'js delete project') ?>')) {
                $.get('<?= Url::to('@web/playbook/delete') ?>', {projectId: $this.data('id')}, function(o) {
                    if (!o.code) {
                        $this.closest("tr").remove();
                    } else {
                        alert('<?= yii::t('w', 'js delete failed') ?>' + o.msg);
                    }
                })
            }
        })
         $('.toconf').click(function(e) {
            $this = $(this);
            if (confirm('<?= yii::t('w', 'write to conf') ?>')) {
                $.get('<?= Url::to('@web/playbook/toconf') ?>', {projectId: $this.data('id')}, function(o) {
                    if (!o.code) {
//                         $this.closest("tr").remove();
                    	alert('success' + o.msg);
                    } else {
                        alert('<?= yii::t('w', 'js delete failed') ?>' + o.msg);
                    }
                })
            }
        })
        $("#myModal").on("hidden.bs.modal", function() {
            $(this).removeData("bs.modal");
        });
    });
</script>