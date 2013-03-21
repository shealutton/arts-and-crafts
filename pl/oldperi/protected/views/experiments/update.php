<?php
$this->breadcrumbs=array(
	'Experiments'=>array('index'),
	$model->title=>array('view','id'=>$model->experiment_id),
	'Edit',
);
/*
$this->menu=array(
	array('label'=>'List Experiments', 'url'=>array('index')),
	array('label'=>'Create Experiments', 'url'=>array('create')),
	array('label'=>'View Experiments', 'url'=>array('view', 'id'=>$model->experiment_id)),
	array('label'=>'Manage Experiments', 'url'=>array('admin')),
);
*/
?>

<h1>Edit Experiment</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
