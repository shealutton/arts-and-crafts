<?php
if (isset($_REQUEST['experiment_id']) && is_numeric($_REQUEST['experiment_id'])) {
	$experiment_id = $_REQUEST['experiment_id'];
} else {
	//FIXME: Throw an exception or something.
}

$experiment=Experiments::model()->findByPk($experiment_id);
$this->breadcrumbs=array(
	//'Constants'=>array('index'),
	$experiment->title => array('/experiments/'.$experiment_id),	
	'Add Constant',
);

/*
$this->menu=array(
	array('label'=>'List Constants', 'url'=>array('index'), 'visible'=>Yii::app()->user->isAdmin()),
	array('label'=>'Manage Constants', 'url'=>array('admin'), 'visible'=>Yii::app()->user->isAdmin()),
);
*/
?>

<h1>Add Constant</h1>

<p>Constants represent the aspects of your experiment that <em>do not change</em> between trials.</p>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'experiment_id'=>$experiment_id)); ?>
