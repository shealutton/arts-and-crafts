<?php
$this->breadcrumbs=array(
	'Variables Texts',
);

$this->menu=array(
	array('label'=>'Create VariablesText', 'url'=>array('create')),
	array('label'=>'Manage VariablesText', 'url'=>array('admin')),
);
?>

<h1>Variables Texts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
