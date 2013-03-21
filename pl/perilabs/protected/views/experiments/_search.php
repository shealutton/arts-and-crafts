<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div>
		<?php echo $form->label($model,'experiment_id'); ?>
		<?php echo $form->textField($model,'experiment_id'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>300,'maxlength'=>300, 'class'=>"formwide")); ?>
	</div>

	<div>
		<?php echo $form->label($model,'goal'); ?>
		<?php echo $form->textField($model,'goal',array('size'=>300,'maxlength'=>300, 'class'=>"formwide")); ?>
	</div>

	<div>
		<?php echo $form->label($model,'user__id'); ?>
		<?php echo $form->textField($model,'user__id'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'date_created'); ?>
		<?php echo $form->textField($model,'date_created'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'last_updated'); ?>
		<?php echo $form->textField($model,'last_updated'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'validity_average'); ?>
		<?php echo $form->textField($model,'validity_average'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'value_average'); ?>
		<?php echo $form->textField($model,'value_average'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'data_shard_hostname'); ?>
		<?php echo $form->textArea($model,'data_shard_hostname',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div>
		<?php echo $form->label($model,'data_shard_db'); ?>
		<?php echo $form->textArea($model,'data_shard_db',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div>
		<?php echo $form->label($model,'data_shard_schema'); ?>
		<?php echo $form->textArea($model,'data_shard_schema',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div>
		<?php echo $form->label($model,'data_shard_table'); ?>
		<?php echo $form->textArea($model,'data_shard_table',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div>
		<?php echo CHtml::submitButton('Search', array('class'=>"btn btn-primary")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
