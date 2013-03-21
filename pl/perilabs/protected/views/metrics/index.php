<?php
$this->breadcrumbs=array(
	'Metrics',
);
/*
$this->menu=array(
	array('label'=>'Manage Metrics', 'url'=>array('admin'), 'visible'=>Yii::app()->user->isAdmin()),
);
*/
?>

<h1>Metrics</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
