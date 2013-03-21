<?php
if (isset($_REQUEST['experiment_id']) && is_numeric($_REQUEST['experiment_id'])) {
	$experiment_id = $_REQUEST['experiment_id'];
} else {
	//FIXME: Throw an exception or something.
}

$experiment=Experiments::model()->findByPk($experiment_id);
$this->breadcrumbs=array(
	//'Conclusions'=>array('index'),
	$experiment->title => array('/experiments/'.$experiment_id),	
	'Add Conclusion',
); ?>

<h1>Add Conclusion</h1>
<p>Conclusions represent your judgement or decision based on what you learned from the experiment.</p>
<?php echo $this->renderPartial('_form', array('model'=>$model, 'experiment_id'=>$experiment_id)); ?>
