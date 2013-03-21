<?php
if (isset($_REQUEST['trial_id']) && is_numeric($_REQUEST['trial_id'])) {
	$trial_id = $_REQUEST['trial_id'];
} else {
	//FIXME: Throw an exception or something.
}

$trial=Trials::model()->findByPk($trial_id);
$this->breadcrumbs=array(
	//'Results'=>array('index'),
	$trial->experiment->title => array('/experiments/'.$trial->experiment->experiment_id),
	$trial->title => array('/trials/'.$trial->trial_id),
	'Add Result Set',
);
/*
$this->menu=array(
	array('label'=>'List Results', 'url'=>array('index')),
	array('label'=>'Manage Results', 'url'=>array('admin')),
);
*/
?>

<h1>Add Result Set</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'experiment_id'=>$trial->experiment->experiment_id, 'experiment'=>$trial->experiment, 'trial_id'=>$trial_id, 'trial'=>$trial)); ?>