<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div>
		<?php echo $form->label($model,'variable_id'); ?>
		<?php echo $form->textField($model,'variable_id'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'experiment__id'); ?>
		<?php echo $form->textField($model,'experiment__id'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div>
		<?php echo $form->label($model,'data_type__id'); ?>
		<?php echo $form->textField($model,'data_type__id'); ?>
	</div>

	<div>
		<?php echo CHtml::submitButton('Search', array('class'=>"btn btn-primary")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->