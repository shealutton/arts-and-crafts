<?php
$this->breadcrumbs=array(
	'Variables Times'=>array('index'),
	$model->var_time_id,
);

$this->menu=array(
	array('label'=>'List VariablesTime', 'url'=>array('index')),
	array('label'=>'Create VariablesTime', 'url'=>array('create')),
	array('label'=>'Update VariablesTime', 'url'=>array('update', 'id'=>$model->var_time_id)),
	array('label'=>'Delete VariablesTime', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->var_time_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage VariablesTime', 'url'=>array('admin')),
);
?>

<h1>View VariablesTime #<?php echo $model->var_time_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'var_time_id',
		'variable__id',
		'value',
	),
)); ?>
