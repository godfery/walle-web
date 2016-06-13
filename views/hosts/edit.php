<?php
/**
 * @var yii\web\View $this
 */
$this->title = yii::t('conf', ' host');
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
        <?= $form->field($conf, 'host')
                          ->textarea([
                              'placeholder'    => "",
                              'data-placement' => 'top',
                              'data-rel'       => 'tooltip',
                              'data-title'     => yii::t('conf', 'excludes tip'),
                              'rows'           => 1,
                          ])
                          ->label(yii::t('w', 'host'), ['class' => 'text-right bolder']) ?>
              
          <?= $form->field($conf, 'description')
                          ->textarea([
                              'placeholder'    => "",
                              'data-placement' => 'top',
                              'data-rel'       => 'tooltip',
                              'data-title'     => yii::t('conf', 'excludes tip'),
                              'rows'           => 10,
                          ])
                          ->label(yii::t('w', 'description'), ['class' => 'text-right bolder']) ?>
              
          

        
        <div class="hr hr-dotted"></div>

        <div class="form-group">
            <label class="text-right bolder blue">
                <?= yii::t('conf', 'branch/tag') ?>
            </label>
            

            
        <div class="form-group">
            <label class="text-right bolder blue">
                <?= yii::t('conf', 'enable open') ?>
                
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
