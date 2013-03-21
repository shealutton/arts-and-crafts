<?php
$this->breadcrumbs=array(
	//'Variables'=>array('index'),
	$model->experiment->title => array('/experiments/'.$model->experiment->experiment_id),
	$model->title=>array('view','id'=>$model->variable_id),
	'Edit',
);
/*
$this->menu=array(
	array('label'=>'List Variables', 'url'=>array('index'), 'visible'=>Yii::app()->user->isAdmin()),
	array('label'=>'View Variable', 'url'=>array('view', 'id'=>$model->variable_id)),
	array('label'=>'Manage Variables', 'url'=>array('admin'), 'visible'=>Yii::app()->user->isAdmin()),
);
*/
?>

<h1>Edit Variable</h1>
<?php echo $this->renderPartial('_form', array('model'=>$model, 'experiment_id'=>$model->experiment->experiment_id, 'experiment'=>$model->experiment)); ?>
