<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'variables-form',
	'enableAjaxValidation'=>false,
	'focus'=>array($model,'title'),
)); 

$data_types = Yii::app()->db2->createCommand()
	->select('*')
	->from('data_types')
	->order('title')
	->queryRow();
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary($model); ?>

                <?php echo $form->labelEx($model,'data_type__id'); ?>
                <?php echo $form->dropDownList($model,'data_type__id', CHtml::listData(DataTypes::model()->findAll(), 'data_type_id', 'title')); ?>
                <?php echo $form->error($model,'data_type__id'); ?>

		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'title'); ?>

                <h3>Possible Values:</h3>
                <ul>
                <?php foreach($model->variablesTexts() as $text): ?>
                        <li><input type="text" name="VariablesText[<?php $text->var_text_id ?>]" value="<?php $text->value ?>" /></li>
                <?php endforeach; ?>
                </ul>
                <input type="text" name="VariablesText[]" />

		<?php echo CActiveForm::labelEx($model,'min'); ?>
		<?php echo CActiveForm::textField($model,'min',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'min'); ?>

		<?php echo CActiveForm::labelEx($model,'max'); ?>
		<?php echo CActiveForm::textField($model,'max',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'max'); ?>

		<?php echo CActiveForm::labelEx($model,'increment'); ?>
		<?php echo CActiveForm::textField($model,'increment',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'increment'); ?>
		
		<br />


		<?php
			echo $form->hiddenField($model,'experiment__id', array('value'=>$experiment_id));
			echo $form->hiddenField($model,'return_to_experiment', array('value'=>true)); // controller should navigate back to experiment view
			echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); 
		?>

<?php $this->endWidget(); ?>

</div><!-- form -->
