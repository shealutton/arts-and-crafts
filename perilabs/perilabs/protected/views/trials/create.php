<?php
if (isset($_REQUEST['experiment_id']) && is_numeric($_REQUEST['experiment_id'])) {
	$experiment_id = $_REQUEST['experiment_id'];
} else {
	//FIXME: Throw an exception or something.
}

$experiment=Experiments::model()->findByPk($experiment_id);
$this->breadcrumbs=array(
	//'Trials'=>array('index'),
	$experiment->title => array('/experiments/'.$experiment_id),	
	'Add Trial',
);

/*
$this->menu=array(
	array('label'=>'List Trials', 'url'=>array('index')),
	array('label'=>'Manage Trials', 'url'=>array('admin')),
);
*/
?>

<h1>Add Trial</h1>

<p>Trials represent one possible combination of experiment variables that you'd like to test.  Please provide those values below.  Once a trial is setup, you can add your results from each trial run.</p>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'experiment_id'=>$experiment_id, 'experiment'=>$experiment)); ?>
