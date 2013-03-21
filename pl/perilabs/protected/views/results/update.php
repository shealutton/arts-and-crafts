<?php
$this->breadcrumbs=array(
	$model->trial->experiment->title => array('/experiments/'.$model->trial->experiment->experiment_id),
	$model->trial->title => array('/trials/'.$model->trial->trial_id),
	'Edit Results',
);
/*
$this->menu=array(
	array('label'=>'List Results', 'url'=>array('index')),
	array('label'=>'Create Results', 'url'=>array('create')),
	array('label'=>'View Results', 'url'=>array('view', 'id'=>$model->result_id)),
	array('label'=>'Manage Results', 'url'=>array('admin')),
);
*/
?>

<h1>Edit Results</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'trial_id'=>$model->trial->trial_id, 'trial'=>$model->trial)); ?>