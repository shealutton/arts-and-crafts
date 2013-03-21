<h2> Registration </h2>

<div class="form">
<?php $activeform = $this->beginWidget('CActiveForm', array(
    'id'=>'registration-form',
    'enableAjaxValidation'=>true,
    //'focus'=>array($model,'organization'),
    ));
?>

<p class="note">Fields with <span class="required">*</span> are required.</p>
<?php echo $activeform->errorSummary($model); ?>
<?php echo $activeform->errorSummary($user); ?>
<?php echo $activeform->errorSummary($org); ?>

<?php
echo $activeform->labelEx($model,'plan');
echo $activeform->dropDownList($model, 'plan',
    array(
        User::FREE_PLAN=>'Free',
        User::SMALL_PLAN=>'Small ($39/mo)',
        User::MEDIUM_PLAN=>'Medium ($69/mo)',
        User::LARGE_PLAN=>'Large ($129/mo)',
        User::HUGE_PLAN=>'Huge ($249/mo)'
    ));
?>

<?php
echo $activeform->labelEx($model,'organization');
echo $activeform->textField($model,'organization');
?>

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

<?php echo $activeform->labelEx($model,'password').'<p>Passwords require 8 characters and must contain at least 1 number</p>'; ?>
<?php echo $activeform->passwordField($model,'password'); ?>

<?php echo $activeform->labelEx($model,'verifyPassword'); ?>
<?php echo $activeform->passwordField($model,'verifyPassword'); ?>

<?php if (extension_loaded('gd')): ?>
    <?php echo $activeform->labelEx($model, 'verifyCode');?> 
    <?php $this->widget('CCaptcha', array('captchaAction' => 'user/captcha'));?>
    <?php echo $activeform->textField($model, 'verifyCode');?>
    
    <p class="hint">Please enter the letters as they are shown in the image above.
    <br/>Letters are not case-sensitive.</p>   
<?php endif; ?>
	
<?php echo CHtml::submitButton('Registration'); ?>

<?php $this->endWidget(); ?>
</div><!-- form -->
