<?php
$this->breadcrumbs=array(
	//'Trials'=>array('index'),
	$model->experiment->title=>array('view','id'=>$model->experiment->experiment_id),
	$model->title=>array('view','id'=>$model->trial_id),
	'Edit Trial',
);
/*
$this->menu=array(
	array('label'=>'List Trials', 'url'=>array('index')),
	array('label'=>'Create Trials', 'url'=>array('create')),
	array('label'=>'View Trials', 'url'=>array('view', 'id'=>$model->trial_id)),
	array('label'=>'Manage Trials', 'url'=>array('admin')),
);
*/
?>

<h1>Edit Trial: <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'experiment_id'=>$model->experiment->experiment_id, 'experiment'=>$model->experiment, 'errors'=>$errors)); ?>
