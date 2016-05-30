<?php
/**
 * @var yii\web\View $this
 */
$this->title = yii::t('conf', 'edit');
use app\models\Playbook;
use yii\widgets\ActiveForm;
?>

<div class="box">
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    <div class="box-body">
        
        <div class="clearfix"></div>
        <div class="clearfix"></div>
        

        <!-- 地址 配置 end-->
        <div class="clearfix"></div>
        <?= $form->field($conf, 'name')
                          ->textarea([
                              'placeholder'    => "",
                              'data-placement' => 'top',
                              'data-rel'       => 'tooltip',
                              'data-title'     => yii::t('conf', 'excludes tip'),
                              'rows'           => 1,
                          ])
                          ->label(yii::t('w', 'name'), ['class' => 'text-right bolder']) ?>
              
          <?= $form->field($conf, 'custom_order')
                          ->textarea([
                              'placeholder'    => "",
                              'data-placement' => 'top',
                              'data-rel'       => 'tooltip',
                              'data-title'     => yii::t('conf', 'excludes tip'),
                              'rows'           => 10,
                          ])
                          ->label(yii::t('w', 'custom_order'), ['class' => 'text-right bolder']) ?>
              
          <?= $form->field($conf, 'stop_server_mysql')
                          ->textarea([
                              'placeholder'    => "use gwar;",
                              'data-placement' => 'top',
                              'data-rel'       => 'tooltip',
                              'data-title'     => yii::t('w', 'playbook tip'),
                              'rows'           => 5,
                          ])
                          ->label(yii::t('w', 'stop_server_mysql'), ['class' => 'text-right bolder']) ?>
                  
        
          <?= $form->field($conf, 'running_server_mysql')
                          ->textarea([
                              'placeholder'    => "use gwar;",
                              'data-placement' => 'top',
                              'data-rel'       => 'tooltip',
                              'data-title'     => yii::t('w', 'running_server_mysql'),
                              'rows'           => 5,
                          ])
                          ->label(yii::t('conf', 'running_server_mysql'), ['class' => 'text-right bolder']) ?>
                     
        <?= $form->field($conf, 'running_httpurl')
                          ->textInput([
                                  'placeholder'    => 'http://',
                                  'data-placement' => 'top',
                                  'data-rel'       => 'tooltip',
                                  'data-title'     => yii::t('w', 'playbook tip'),
                              ])
                          ->label(yii::t('conf', 'running_httpurl').'<small><i class="light-blue icon-asterisk"></i></small>',
                              ['class' => 'text-right bolder']) ?>
                      <?= $form->field($conf, 'version')
                          ->textarea([
                              'placeholder'    => "111",
                              'data-placement' => 'top',
                              'data-rel'       => 'tooltip',
                              'data-title'     => yii::t('w', 'playbook tip'),
                              'rows'           => 2,
                          ])
                          ->label(yii::t('conf', 'version'), ['class' => 'text-right bolder']) ?>
                  

        
        <div class="hr hr-dotted"></div>

        <div class="form-group">
            <label class="text-right bolder blue">
                <?= yii::t('conf', 'branch/tag') ?>
            </label>
            

            
        <div class="form-group">
            <label class="text-right bolder blue">
                <?= yii::t('conf', 'enable open') ?>
                <input name="Project[status]" value="0" type="hidden">
                <input name="Project[status]" value="1" <?= $conf->status ? 'checked' : '' ?> type="checkbox"
                       class="ace ace-switch ace-switch-6"  data-rel="tooltip" data-title="<?= yii::t('conf', 'open tip') ?>" data-placement="right">
                <span class="lbl"></span>
            </label>
        </div>

      </div>
      <div class="box-footer">
        <input type="submit" class="btn btn-primary" value="<?= yii::t('w', 'submit') ?>">
      </div>
    <?php ActiveForm::end(); ?>

</div>

<script>
    jQuery(function($) {
        $('[data-rel=tooltip]').tooltip({container:'body'});
        $('[data-rel=popover]').popover({container:'body'});
        $('.show-git').click(function() {
            $('.username-password').hide();
            $('#project-repo_type').val('git');
            $('#div-repo_mode_nontrunk').hide();
        });
        $('.show-svn').click(function() {
            $('.username-password').show();
            $('#project-repo_type').val('svn');
            $('#div-repo_mode_nontrunk').css({'display': 'inline'});
        });
    });
</script>
