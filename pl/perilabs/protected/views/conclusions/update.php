<?php
$this->breadcrumbs=array(
	//'Conclusions'=>array('index'),
	$model->experiment->title => array('/experiments/'.$model->experiment->experiment_id),	
	$model->title=>array('view','id'=>$model->conclusion_id),
	'Edit',
);
/*
$this->menu=array(
	array('label'=>'List Conclusions', 'url'=>array('index'), 'visible'=>Yii::app()->user->isAdmin()),
	array('label'=>'View Conclusion', 'url'=>array('view', 'id'=>$model->conclusion_id)),
	array('label'=>'Manage Conclusions', 'url'=>array('admin'), 'visible'=>Yii::app()->user->isAdmin()),
);
*/
?>

<h1>Edit Conclusion</h1>
<?php echo $this->renderPartial('_form', array('model'=>$model, 'experiment_id'=>$model->experiment->experiment_id)); ?>
