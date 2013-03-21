<?php
if (isset($_REQUEST['experiment_id']) && is_numeric($_REQUEST['experiment_id'])) {
	$experiment_id = $_REQUEST['experiment_id'];
} else {
	//FIXME: Throw an exception or something. (is called by the experiment view and expects a starting exp_id)
}

$experiment=Experiments::model()->findByPk($experiment_id);
$this->breadcrumbs=array(
	//'Variables'=>array('index'),
	$experiment->title => array('/experiments/'.$experiment_id),	
	'Add Variable',
);
?>

<h1>Add Variable</h1>
<p>Variables represent the aspects of your experiment that can change between trials.</p>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'experiment_id'=>$experiment_id)); ?>
