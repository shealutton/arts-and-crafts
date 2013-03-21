<?php
$this->breadcrumbs=array(
	'Constants',
);
/*
$this->menu=array(
	array('label'=>'Manage Constants', 'url'=>array('admin'), 'visible'=>Yii::app()->user->isAdmin()),
);
*/
?>

<h1>Constants</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
