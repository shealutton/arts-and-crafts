<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'datasets-form',
	'enableAjaxValidation'=>false,
)); ?>

	<!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($model); ?>

	<!--<div>
		<h4 style="color: red">These aren't stored in the database yet!</h4>
	</div>-->

	<?php
		foreach ($experiment->metrics as $metric) {
			echo "<div class=\"\">\n";
			$model_class_name = Yii::app()->params['data_type_storage'][$metric->dataType->data_type_id]['metric_class_name'];
			$data = null;
			
      if($model->dataset_id != null){
        $data_model = $model_class_name::model()->find('"dataset__id"=:dataset__id AND "metric__id"=:metric__id', array(":dataset__id" => $model->dataset_id, ":metric__id" => $metric->metric_id));
        $data = $data_model == null ? null : $data_model->value;
        //echo "<p>Editing an existing dataset.  dataset__id: ".$model->dataset_id.", metric__id: ".$metric->metric_id.", value: ".$data."</p>";
      }
			
      $name = "metrics[$metric->metric_id]";
      echo "<label for='$name'>$metric->title</label>";
			//echo '<small style="color: darkblue">Metric: <em>'.$metric->title . "</em>, of type: <em>" . $metric->dataType->title."</em>, Instance of Class: <em> ".Yii::app()->params['data_type_storage'][$metric->dataType->data_type_id]['metric_class_name'].'</em>, Stored in Table: <em>'.Yii::app()->params['data_type_storage'][$metric->dataType->data_type_id]['metric_table_suffix'].'</em></small><br />';

      switch ($model_class_name) {
        case 'MBin':
          break;
        case 'MBool':
        	echo "<select name='$name' id='$name'><option value=''>Select...</option>";
        	if ($data === true) {
        		echo "<option value='1' selected='selected'>True</option><option value='0'>False</option>";
        	} elseif ($data === false) {
        		echo "<option value='1'>True</option><option value='0' selected='selected'>False</option>";
        	} else {
        		echo "<option value='1'>True</option><option value='0'>False</option>";
        	}
          echo "</select>";
          break;
        case 'MInt':
          echo "<input type='number' name='$name' value='$data' />";
          break;
        case 'MReal':
          echo "<input type='text' name='$name' value='$data' />";
          break;
        case 'MText':
          echo "<input name='$name' type='text' value='$data' />";
          break;
        case 'MTime':
          echo "<input name='$name' type='text' value='$data' />"; //TODO: find a better way to handle time input.
          break;
      }







/*
			$current_metric_storage_model = new $model_class_name();

			echo $form->labelEx($current_metric_storage_model,'value');
			
			echo '<small style="color: darkblue">Metric: <em>'.$metric->title . "</em>, of type: <em>" . $metric->dataType->title."</em>, Instance of Class: <em> ".Yii::app()->params['data_type_storage'][$metric->dataType->data_type_id]['metric_class_name'].'</em>, Stored in Table: <em>'.Yii::app()->params['data_type_storage'][$metric->dataType->data_type_id]['metric_table_suffix'].'</em></small><br />';
			
			echo $form->textField($current_metric_storage_model,'value');
			echo $form->error($current_metric_storage_model,'value');
*/
			echo "</div>\n\n";
		}
	?>

	<div class="">
		<?php
			//echo $form->hiddenField($model,'result__id', array('value'=>$model->result->result_id));
			echo $form->hiddenField($model,'return_to_parent', array('value'=>true)); // controller should navigate back to result view
			echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save');
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->