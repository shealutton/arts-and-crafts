<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<?php $flashes = Yii::app()->user->getFlashes();?>
<?php if(!empty($flashes)):?>
<div id="flash-messages">
    <?php foreach($flashes as $flashKey=>$flashMsg):?>
    <div class="flash-message <?php echo $flashKey;?>">
        <?php echo $flashMsg; ?>
    </div>
    <?php endforeach;?>
</div>
<?php endif;?>
<h1><?php echo $title ?></h1>

<p>Please fill out the following form with your login credentials:</p>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
  'action'=>array('site/login')
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->labelEx($model,'username'); ?>
    <?php echo $form->textField($model,'username'); ?>
    <?php echo $form->error($model,'username'); ?>

    <?php echo $form->labelEx($model,'password'); ?>
    <?php echo $form->passwordField($model,'password'); ?>
    <?php echo $form->error($model,'password'); ?>
    <p></p>
    <?php echo $form->checkBox($model,'rememberMe'); ?>
    <?php echo $form->label($model,'rememberMe'); ?>
    <?php echo $form->error($model,'rememberMe'); ?>

    <?php echo CHtml::submitButton('Login'); ?>

<?php $this->endWidget(); ?>
</div><!-- form -->

<?php echo CHtml::link('registration', Yii::app()->createUrl('user/registration'));?> |
<?php echo CHtml::link('forgot your password?', Yii::app()->createUrl('user/recovery'));?>
