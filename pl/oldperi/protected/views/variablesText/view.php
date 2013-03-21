<?php
$this->breadcrumbs=array(
	'Variables Texts'=>array('index'),
	$model->var_text_id,
);

$this->menu=array(
	array('label'=>'List VariablesText', 'url'=>array('index')),
	array('label'=>'Create VariablesText', 'url'=>array('create')),
	array('label'=>'Update VariablesText', 'url'=>array('update', 'id'=>$model->var_text_id)),
	array('label'=>'Delete VariablesText', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->var_text_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage VariablesText', 'url'=>array('admin')),
);
?>

<h1>View VariablesText #<?php echo $model->var_text_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'var_text_id',
		'variable__id',
		'value',
	),
)); ?>
