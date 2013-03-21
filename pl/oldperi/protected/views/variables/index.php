<?php
$this->breadcrumbs=array(
	'Variables',
);
/*
$this->menu=array(
	array('label'=>'Manage Variables', 'url'=>array('admin'), 'visible'=>Yii::app()->user->isAdmin()),
);
*/
?>

<h1>Variables</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
