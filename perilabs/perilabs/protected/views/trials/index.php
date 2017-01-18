<?php
$this->breadcrumbs=array(
	'Trials',
);
/*
$this->menu=array(
	array('label'=>'Create Trials', 'url'=>array('create')),
	array('label'=>'Manage Trials', 'url'=>array('admin')),
);
*/
?>

<h1>Trials</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
