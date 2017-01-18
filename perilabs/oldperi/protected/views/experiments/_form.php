<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'experiments-form',
	'enableAjaxValidation'=>false,
	'focus'=>array($model,'title'),
)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary($model); ?>
    <div>
        <?php 
            $options = array();
            $orgs = User::model()->findByPk(Yii::app()->user->id)->organizations;
            foreach($orgs as $option) {
                    $options[$option->organization_id] = $option->name;
            }
        ?>
        <?php echo $form->labelEx($model,'organization__id'); ?>
        <?php echo $form->dropDownList($model, 'organization__id', $options) ?>
        <?php echo $form->error($model,'organization__id') ?>
    </div>
		<div>
			<?php echo $form->labelEx($model,'title'); ?>
			<?php echo $form->textField($model,'title',array('size'=>300,'maxlength'=>300, 'class'=>"formwide")); ?>
			<?php echo $form->error($model,'title'); ?>
		</div>
		<div>
			<?php echo $form->labelEx($model,'goal'); ?>
			<?php echo $form->textField($model,'goal',array('size'=>300,'maxlength'=>300, 'class'=>"formwide")); ?>
			<?php echo $form->error($model,'goal'); ?>
		</div>
<!--		<div>		
			<?php //echo $form->labelEx($model,'validity_average'); ?>
			<?php //echo $form->textField($model,'validity_average'); ?>
			<?php //echo $form->error($model,'validity_average'); ?>
		</div>
		<div>
			<?php //echo $form->labelEx($model,'value_average'); ?>
			<?php //echo $form->textField($model,'value_average'); ?>
			<?php //echo $form->error($model,'value_average'); ?>
		</div> -->
		<div>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>"btn btn-primary")); ?>
		</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
