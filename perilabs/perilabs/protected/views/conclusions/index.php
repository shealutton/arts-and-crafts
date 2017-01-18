<?php
$this->breadcrumbs=array(
	'Conclusions',
);
/*
$this->menu=array(
	array('label'=>'Manage Conclusions', 'url'=>array('admin'), 'visible'=>Yii::app()->user->isAdmin()),
);
*/
?>

<h1>Conclusions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
