<?php
$this->breadcrumbs=array(
	'Variables Times'=>array('index'),
	$model->var_time_id=>array('view','id'=>$model->var_time_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List VariablesTime', 'url'=>array('index')),
	array('label'=>'Create VariablesTime', 'url'=>array('create')),
	array('label'=>'View VariablesTime', 'url'=>array('view', 'id'=>$model->var_time_id)),
	array('label'=>'Manage VariablesTime', 'url'=>array('admin')),
);
?>

<h1>Update VariablesTime <?php echo $model->var_time_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>