<?php
$this->breadcrumbs=array(
	//'Datasets'=>array('index'),
	$model->dataset_id,
);
/*
$this->menu=array(
	array('label'=>'List Datasets', 'url'=>array('index')),
	array('label'=>'Create Datasets', 'url'=>array('create')),
	array('label'=>'Update Datasets', 'url'=>array('update', 'id'=>$model->dataset_id)),
	array('label'=>'Delete Datasets', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->dataset_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Datasets', 'url'=>array('admin')),
);
*/
?>

<h1>View Datasets #<?php echo $model->dataset_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'dataset_id',
		'result__id',
	),
)); ?>
