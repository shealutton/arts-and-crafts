<?php
$this->breadcrumbs=array(
	'Variables Times',
);

$this->menu=array(
	array('label'=>'Create VariablesTime', 'url'=>array('create')),
	array('label'=>'Manage VariablesTime', 'url'=>array('admin')),
);
?>

<h1>Variables Times</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
