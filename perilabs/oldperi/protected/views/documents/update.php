<?php
$experiment=Experiments::model()->findByPk($model->experiment__id);
$this->breadcrumbs=array(
    //'Trials'=>array('index'),
    $experiment->title => array('/experiments/'.$model->experiment__id),	
    'Add Document',
);

?>

<h1>Update Document</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'experiment_id'=>$model->experiment__id, 'trial_id'=>$model->trial__id)); ?>