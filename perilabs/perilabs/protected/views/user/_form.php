<div class="form">
        <?php $activeform = $this->beginWidget('CActiveForm', array(
        'id'=>'create-form',
        'enableAjaxValidation'=>true,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $activeform->errorSummary($model); ?>
    <?php echo $activeform->errorSummary($user); ?>

    <?php
    echo $activeform->labelEx($model,'username');
    echo $activeform->textField($model,'username');
    ?>

    <?php
    echo $activeform->labelEx($model,'firstname');
    echo $activeform->textField($model,'firstname');
    ?>

    <?php
    echo $activeform->labelEx($model,'lastname');
    echo $activeform->textField($model,'lastname');
    ?>

    <?php
    echo $activeform->labelEx($model,'email');
    echo $activeform->textField($model,'email');
    ?>

    <div class="form-inline well">
    <label>Organization Permissions:</label><br />
    <?php
      $organizations = Organizations::model()->findAll();
      foreach($organizations as $organization):
              if($user->id != null) {
                      $membership = Memberships::model()->find('organization__id=:organization_id and user__id=:user_id', 
                              array(':organization_id' => $organization->organization_id, ':user_id' => $user->id));
                      if($membership == null) {
                              $level = null;
                      } else {
                              $level = $membership->level;
                      }
              }
              if(isset($_REQUEST['organization_'.$organization->organization_id.'_level'])) {
                      $level = $_REQUEST['organization_'.$organization->organization_id.'_level'];
              }
              if(!isset($level)) {
                      $level = '';
              }
        ?>
        <select class="span2" name="organization_<?php echo $organization->organization_id ?>_level">
          <option value=""></option>
          <option value="member" <?php if($level == 'member') { ?> selected="selected" <?php } ?>>Member</option>
          <option value="manager" <?php if($level == 'manager') { ?> selected="selected" <?php } ?>>Manager</option>
        </select>
        <label><?php echo $organization->name ?></label>
        <br />
    <?php endforeach; ?>
    </div>

    <?php if(Yii::app()->controller->getAction()->getId() == 'create'):?>
        <?php echo $activeform->labelEx($model,'password').'<p>Passwords require 8 characters and must contain at least 1 number</p>'; ?>
        <?php echo $activeform->passwordField($model,'password'); ?>
    <?php else:?>
        <?php echo $activeform->labelEx($model,'newPassword').'<p>Passwords require 8 characters and must contain at least 1 number</p>'; ?>
        <?php echo $activeform->passwordField($model,'newPassword'); ?>
    <?php endif;?>
    <?php echo $activeform->labelEx($model,'verifyPassword'); ?>
    <?php echo $activeform->passwordField($model,'verifyPassword'); ?>

    <?php if($model->id != Yii::app()->user->id):?>
        <?php echo $activeform->labelEx($model,'role'); ?>
        <?php echo $activeform->dropDownList($model,'role', array(User::USER_ROLE=>'user', User::MANAGER_ROLE=>'manager')); ?>
        <?php if($model->getScenario() == 'update'):?>
            <br/>
            <?php echo $activeform->labelEx($model,'status'); ?>
            <?php echo $activeform->dropDownList($model,'status', array(User::STATUS_ACTIVE=>'active', User::STATUS_BANNED=>'banned', User::STATUS_INACTIVE=>'inactive')); ?>
        <?php endif;?>
    <?php endif;?>
    <br/>

    <?php echo CHtml::submitButton((Yii::app()->controller->getAction()->getId() == 'create') ? 'Create':'Update'); ?>

    <?php $this->endWidget(); ?>
</div><!-- form -->
