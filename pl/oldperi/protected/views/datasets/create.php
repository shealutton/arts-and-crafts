<?php
if (isset($_REQUEST['result_id']) && is_numeric($_REQUEST['result_id'])) {
	$result_id = $_REQUEST['result_id'];
} else {
	//FIXME: Throw an exception or something.
}

$result=Results::model()->findByPk($result_id);
$this->breadcrumbs=array(
	//'Datasets'=>array('index'),
	$result->trial->experiment->title => array('/experiments/'.$result->trial->experiment->experiment_id),
	$result->trial->title => array('/trials/'.$result->trial->trial_id),
	$result->title => array('/results/'.$result->result_id),
	'Add Dataset',
);
/*
$this->menu=array(
	array('label'=>'List Datasets', 'url'=>array('index')),
	array('label'=>'Manage Datasets', 'url'=>array('admin')),
);
*/
?>

<h1>Add Dataset</h1>

<p>Datasets store the individual metrics values recorded in a given result set for an experiment trial.</p>

<!--<p><em>TODO: iterate through this experiment's metrics, displaying the appropriate form widget, with validation, to be stored in the appropriate metric instance table. Eventually the form will need to be made aware of the metric value min, max, and interval constraints (not yet present in the db), so that they can be enforced.</em></p>

<p><em>This view fragment was split into the separate '_create-form.php' file, in case creation and update logic are dissimilar.</em></p>-->

<?php echo $this->renderPartial('_form', array('model'=>$model, 'result_id'=>$result_id, 'trial'=>$result->trial, 'experiment'=>$result->trial->experiment)); ?>