<?php
/**
 * @var yii\web\View $this
 */
$this->title = yii::t('conf', 'new host');
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
        <a class="btn btn-default btn-sm" href="<?= Url::to('@web/hosts/edit') ?>">
            <i class="icon-pencil align-top bigger-125"></i>
            <?= yii::t('conf', 'new host') ?>
        </a>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive no-padding clearfix">
        <table class="table table-striped table-bordered table-hover">
            <tbody><tr>
                <th>主机名</th>
                <th>描述</th>
                <th>时间</th>
                
                
                <th><?= yii::t('conf', 'p_opera') ?></th>
            </tr>
            <?php foreach ($list as $item) { ?>
                <tr>
                    <td><?= $item['host'] ?></td>
                    <td><?= $item['description'] ?></td>
                    <td><?= date("Y-m-d H:i:s",$item['log_time']) ?></td>
                    
                    
                    
                   <td>
                        <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                            
                           
                            <a href="<?= Url::to("@web/hosts/edit?projectId={$item['host']}") ?>">
                                <i class="icon-pencil bigger-130"></i>
                                <?= yii::t('conf', 'p_edit') ?>
                            </a>
                            <a class="red btn-delete" data-id="<?= $item['host'] ?>" href="javascript:;">
                                <i class="icon-trash bigger-130"></i>
                                <?= yii::t('conf', 'p_delete') ?>
                            </a>
                           
                            <a class="red toconf" data-id="<?= $item['host'] ?>" href="javascript:;">
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
                $.get('<?= Url::to('@web/hosts/delete') ?>', {projectId: $this.data('id')}, function(o) {
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
                $.get('<?= Url::to('@web/hosts/toconf') ?>', {projectId: $this.data('id')}, function(o) {
                    if (!o.code) {
//                         $this.closest("tr").remove();
                    	alert('success' + o.msg);
                    } else {
                        alert('<?= yii::t('w', '生成文件失败') ?>' + o.msg);
                    }
                })
            }
        })
        $("#myModal").on("hidden.bs.modal", function() {
            $(this).removeData("bs.modal");
        });
    });
</script>