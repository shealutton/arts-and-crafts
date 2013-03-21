<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'trials-form',
	'enableAjaxValidation'=>false,
	'focus'=>array($model,'title'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
	<!--<p><em>TODO: as indicated in the small blue text, we'll need to add rows to the appropriate variable instance table to hold the value of each variable for this particular trial.  The create action will need to handle that appropriately, and form validation should be enforced, eventually using the expected form widgets, etc.</em></p>-->

	<?php echo $form->errorSummary($model); ?>

	<div class="">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>600,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

  <?php if(isset($errors) && sizeof($errors > 0)) { ?>
    <ul class="errors">
      <?php foreach($errors as $error): ?>
        <li><?php echo $error ?></li>
      <?php endforeach ?>
    </ul>
  <?php } ?>
	<?php
		// Loop through each variable, recording what their values will be for this particular trial.
		foreach ($experiment->variables as $variable) {
			echo "<div class=\"\">\n";
      $model_class_name = Yii::app()->params['data_type_storage'][$variable->dataType->data_type_id]['variable_class_name'];
      $data = null;
      if($model->trial_id != null){
        $data_model = $model_class_name::model()->find('"variable__id"=:variable_id AND "trial__id"=:trial_id', array(":variable_id" => $variable->variable_id, ":trial_id" => $model->trial_id));
        $data = $data_model == null ? null : $data_model->value;
      } else {
              if(isset($_GET["variables"][$variable->variable_id])) {
                      $data = $_GET["variables"][$variable->variable_id];
              }
      }
                            

      $name = "variables[$variable->variable_id]";
      echo "<label for='$name'>$variable->title</label>";
			
      switch ($model_class_name) {
        case 'VBin':
          break;
        case 'VBool':
        	echo "<select name='$name' id='$name'><option value=''>Select...</option>";
        	if ($data === true or $data == "1") {
        		echo "<option value='1' selected='selected'>True</option><option value='0'>True</option>";
        	} elseif ($data === false or $data == "0") {
        		echo "<option value='1'>True</option><option value='0' selected='selected'>False</option>";
        	} else {
        		echo "<option value='1'>True</option><option value='0'>False</option>";
        	}
          echo "</select>";
          break;
        case 'VInt':
          echo "<input type='number' name='$name' value='$data' />";
          break;
        case 'VReal':
          echo "<input type='text' name='$name' value='$data' />";
          break;
        case 'VText':
          echo "<input name='$name' type='text' value='$data' />";
          break;
        case 'VTime':
          echo "<input name='$name' type='text' value='$data' />"; //TODO: find a better way to handle time input.
          break;
      }
			echo "</div>\n\n";
		}
	?>
<!--
	<div>
		<?php //echo $form->labelEx($model,'skip_f'); ?>
		<?php //echo $form->checkBox($model,'skip_f'); ?>
		<?php //echo $form->error($model,'skip_f'); ?>
	</div>

	<div>
		<?php //echo $form->labelEx($model,'update_time'); ?>
		<?php //echo $form->textField($model,'update_time'); ?>
		<?php //echo $form->error($model,'update_time'); ?>
	</div>

	<div>
		<?php //echo $form->labelEx($model,'sequence_num'); ?>
		<?php //echo $form->textField($model,'sequence_num'); ?>
		<?php //echo $form->error($model,'sequence_num'); ?>
	</div>

	<div>
		<?php //echo $form->labelEx($model,'locked_f'); ?>
		<?php //echo $form->textArea($model,'locked_f',array('rows'=>6, 'cols'=>50)); ?>
		<?php //echo $form->error($model,'locked_f'); ?>
	</div>
-->
	<div class="">
		<?php 
			//echo $form->hiddenField($model,'experiment__id', array('value'=>$experiment_id));
			echo $form->hiddenField($model,'return_to_experiment', array('value'=>true));		
			echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-info'));
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
