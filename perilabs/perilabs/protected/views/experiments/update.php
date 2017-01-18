<?php
$this->breadcrumbs=array(
	'Experiments'=>array('index'),
	$model->title=>array('view','id'=>$model->experiment_id),
	'Edit',
);
/*
$this->menu=array(
	array('label'=>'List Experiments', 'url'=>array('index')),
	array('label'=>'Create Experiments', 'url'=>array('create')),
	array('label'=>'View Experiments', 'url'=>array('view', 'id'=>$model->experiment_id)),
	array('label'=>'Manage Experiments', 'url'=>array('admin')),
);
*/
?>

<?php if(isset($_GET['lastAction']) and $_GET['lastAction'] == 'copy') { ?>
<h1>Copy Experiment</h1>
<?php } else { ?>
<h1>Edit Experiment</h1>
<?php } ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
