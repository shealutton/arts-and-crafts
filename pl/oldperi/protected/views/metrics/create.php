<?php
if (isset($_REQUEST['experiment_id']) && is_numeric($_REQUEST['experiment_id'])) {
	$experiment_id = $_REQUEST['experiment_id'];
} else {
	//FIXME: Throw an exception or something.
}

$experiment=Experiments::model()->findByPk($experiment_id);
$this->breadcrumbs=array(
	//'Metrics'=>array('index'),
	$experiment->title => array('/experiments/'.$experiment_id),	
	'Add Metric',
);
/*
$this->menu=array(
	array('label'=>'List Metrics', 'url'=>array('index'), 'visible'=>Yii::app()->user->isAdmin()),
	array('label'=>'Manage Metrics', 'url'=>array('admin'), 'visible'=>Yii::app()->user->isAdmin()),
);
*/
?>

<h1>Add Metric</h1>

<p>Metrics represent the individual data points that you will measure and record for each sample in a result set.</p>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'experiment_id'=>$experiment_id)); ?>
