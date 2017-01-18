<?php
$this->breadcrumbs=array(
	//'Datasets'=>array('index'),
	$model->result->trial->experiment->title=>array('view','id'=>$model->result->trial->experiment->experiment_id),
	$model->result->trial->title => array('/trials/'.$model->result->trial->trial_id),
	$model->result->title => array('/results/'.$model->result->result_id),
	'Edit Dataset',
);
/*
$this->menu=array(
	array('label'=>'List Datasets', 'url'=>array('index')),
	array('label'=>'Create Datasets', 'url'=>array('create')),
	array('label'=>'View Datasets', 'url'=>array('view', 'id'=>$model->dataset_id)),
	array('label'=>'Manage Datasets', 'url'=>array('admin')),
);
*/
?>

<h1>Edit Dataset</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'experiment_id'=>$model->result->trial->experiment->experiment_id, 'experiment'=>$model->result->trial->experiment)); ?>