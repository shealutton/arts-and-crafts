<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'documents-form',
	'enableAjaxValidation'=>false,
));

if ($experiment_id) {
    $return_path = "experiments/$experiment_id";
} else {
    $return_path = "trials/$trial_id";
}

 ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div>
		<?php echo $form->labelEx($model,'file_name'); ?>
		<?php echo $form->textField($model,'file_name'); ?>
		<?php echo $form->error($model,'file_name'); ?>
	</div>

    <div>
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body', array('rows'=>'24', 'cols'=>'60', 'style'=>'width: 98%; height: 80%;')); ?>
		<?php echo $form->error($model,'body'); ?>    
    </div>

	<div class="buttons">
		<?php
		    echo $form->hiddenField($model,'experiment__id', array('value'=>$experiment_id));
		    echo $form->hiddenField($model,'trial__id', array('value'=>$trial_id));
		    echo CHtml::link('Cancel', array($return_path), array('class' => 'btn')) . "&nbsp;";
		    echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-info')); 
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->