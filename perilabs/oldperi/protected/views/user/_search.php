<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div>
		<?php echo $form->label($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
	</div>

	<div>
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

    <div>
        <?php echo $form->label($model,'role'); ?>
        <?php echo $form->textField($model,'role'); ?>
    </div>

	<div>
		<?php echo CHtml::submitButton('Search', array('class'=>"btn btn-primary")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->