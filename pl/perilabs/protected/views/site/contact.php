<?php
$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Contact',
);
?>

<h1>Contact Us</h1>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<p>If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'focus'=>array($model,'name'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php 
	    //echo $form->errorSummary($model);
	?>

		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo '<div class="control-group error inline">'.$form->error($model,'name', array('inputContainer'=>'span', 'class'=>'help-inline')).'</div>'; ?>

		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo '<div class="control-group error inline">'.$form->error($model,'email', array('inputContainer'=>'span', 'class'=>'help-inline')).'</div>'; ?>

		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo '<div class="control-group error inline">'.$form->error($model,'subject', array('inputContainer'=>'span', 'class'=>'help-inline')).'</div>'; ?>

		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo '<div class="control-group error inline">'.$form->error($model,'body', array('inputContainer'=>'span', 'class'=>'help-inline')).'</div>'; ?>
		<!-- If you comment out captcha, you must do the controller too. -->
		<?php if(CCaptcha::checkRequirements()): ?>
			<?php echo $form->labelEx($model,'verifyCode'); ?>
			<?php $this->widget('CCaptcha'); ?><br />
			<?php echo $form->textField($model,'verifyCode'); ?>
			<?php echo '<div class="control-group error inline">'.$form->error($model,'verifyCode', array('inputContainer'=>'span', 'class'=>'help-inline')).'</div>'; ?>
			<div class="hint">Please enter the letters as they are shown in the image above.
			<br/>Letters are not case-sensitive.</div>
		<?php endif; ?>
		<?php echo CHtml::submitButton('Submit', array("class" => "btn btn-info")); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>
