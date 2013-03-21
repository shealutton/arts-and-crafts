<?php
$this->breadcrumbs=array(
	//'Metrics'=>array('index'),
	$model->experiment->title => array('/experiments/'.$model->experiment->experiment_id),
	$model->title=>array('view','id'=>$model->metric_id),
	'Edit',
);
/*
$this->menu=array(
	array('label'=>'List Metrics', 'url'=>array('index'), 'visible'=>Yii::app()->user->isAdmin()),
	array('label'=>'View Metric', 'url'=>array('view', 'id'=>$model->metric_id)),
	array('label'=>'Manage Metrics', 'url'=>array('admin'), 'visible'=>Yii::app()->user->isAdmin()),
);
*/
?>

<h1>Edit Metric</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'experiment_id'=>$model->experiment->experiment_id)); ?>
