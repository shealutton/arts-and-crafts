<?php
$this->pageTitle = 'Password recovery';

$this->breadcrumbs=array(
    'Login' => Yii::app()->createUrl('/site/login'),
    'Change password'
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
<?php else: ?>
    <h2> Change password </h2>


<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'new-pass-form',
    'enableClientValidation'=>false,

)); ?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->labelEx($model,'password'); ?>
    <?php echo $form->passwordField($model,'password'); ?>
    <p>Passwords require 8 characters and must contain at least 1 number</p>

    <?php echo $form->labelEx($model,'verifyPassword'); ?>
    <?php echo $form->passwordField($model,'verifyPassword'); ?>

    <?php echo CHtml::submitButton('change', array('class' => 'button')); ?>

    <?php $this->endWidget(); ?>
</div><!-- form -->

<?php endif; ?>