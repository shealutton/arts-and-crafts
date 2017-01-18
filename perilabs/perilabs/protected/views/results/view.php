<?php
$this->breadcrumbs=array(
	$model->trial->experiment->title => array('/experiments/'.$model->trial->experiment->experiment_id),
	$model->trial->title => array('/trials/'.$model->trial->trial_id),
	$model->title,
);
?>

<h1>Result Set: <?php echo CHtml::encode($model->title); ?></h1>

<?php

	if ($model->datasetCount > 0) {
	
		echo "<p>" . CHtml::encode($model->datasetCount) . " data set(s) found.</p>\n";
	
		echo "<table class='table table-striped table-bordered table-condensed result-table'>\n\t<thead>\n\t\t<tr>\n";
	
		foreach ($model->trial->experiment->metrics as $metric) {
			echo "\t\t\t<th>".CHtml::encode($metric->title)."</th>\n";
		}
		echo "\t\t\t<th>Actions</th>\n";
		echo "\t\r</tr>\n\t</thead>\n\t<tbody>\n";
							
			foreach ($model->datasets as $dataset) {

				echo "\t\t<tr>\n";
			
					// Iterate over each metric for this experiment, then find its value for this particular dataset, for this particular result, from this particular trial.
					foreach ($model->trial->experiment->metrics as $metric) {
					
						$value = Yii::app()->db2->createCommand()
							->select('value')
							->from(Yii::app()->params['data_type_storage'][$metric->data_type__id]['metric_table_suffix'])
							->where('metric__id=:metric__id AND dataset__id=:dataset__id', 
								array(
									':metric__id'=>$metric->metric_id,
									':dataset__id'=>$dataset->dataset_id
								)
							)
							->queryRow();
							
							if ($metric->data_type__id == 1) { // BOOL
								if ($value['value'] === true) {
									$value_string = 'True';
								} else {
									$value_string = 'False';
								}
							} else {
								$value_string = $value['value'];
							}

						echo "\t\t\t<td>". CHtml::encode($value_string) . "</td>\n";
						
					} // end foreach metric
					
					echo "\t\t\t<td>";
					echo CHtml::link(
            '<img src="' . Yii::app()->theme->baseUrl . '/images/pencil.png" />',
            array('datasets/update', 'id'=>$dataset->dataset_id),
            array('title'=>'Edit this dataset')
          );
          echo "&nbsp;";
					echo CHtml::link(
            '<img src="' . Yii::app()->theme->baseUrl . '/images/remove.png" />',
            array('#'),
            array('title'=>'Not yet implemented')
          );
          echo "</td>\n";
          
          //array('label'=>'Delete Datasets', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->dataset_id),'confirm'=>'Are you sure you want to delete this item?')),
					
			} // end foreach dataset

		echo "\t\t</tr>\n\t</tbody>\n";
		echo "</table>\n";		
		
	} else {
		echo "<p>This result set doesn't have any data yet.  Would you like to ".CHtml::link(CHtml::encode('add some'),array("datasets/create?result_id=".$model->result_id))."?</p>\n";
	}

?>

<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'result_id',
		'trial__id',
		'title',
	),
));*/ ?>
