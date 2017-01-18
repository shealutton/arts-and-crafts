<?php
if (isset($_REQUEST['experiment_id']) && is_numeric($_REQUEST['experiment_id'])) {
    $experiment_id = $_REQUEST['experiment_id'];
} else {
    $experiment_id = false;
}

if (isset($_REQUEST['trial_id']) && is_numeric($_REQUEST['trial_id'])) {
    $trial_id = $_REQUEST['trial_id'];
} else {
    $trial_id = false;
}

if (!$experiment_id && !$trial_id) {
    throw new CHttpException(500, 'Documents must be attached to either an experiment or trial that you control.');
}

$experiment=Experiments::model()->findByPk($experiment_id);
$this->breadcrumbs=array(
    //'Trials'=>array('index'),
    $experiment->title => array('/experiments/'.$experiment_id),	
    'Add Document',
);

?>

<h1>Create Document</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'experiment_id'=>$experiment_id, 'trial_id'=>$trial_id)); ?>
