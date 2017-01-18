<?php
$this->breadcrumbs=array(
	'Experiments',
);
?>

<h1>Experiments

	<?php
		echo CHtml::link(
			'+ Create Experiment',
			array('create'),
			array('class'=>'btn btn-primary', 'style'=>'float: right;')
		);
	?></h1>
	<?php CHtml::link('Create Experiment', 'create', array('class'=>'btn btn-primary')); ?>

<?php
$user = User::model()->findByPk(Yii::app()->user->id);
$experiments = array();

foreach($user->organizations as $organization) {
# TODO: refactor into recursive function
  $model = $organization->experiments();
?>
        <h3>Organization: <?php echo $organization->name ?></h3>
<?php
        if(sizeof($model) == 0) {
                echo '<p>There are currently no experiments under this organization.</p>';
        }

        $i = 1;

        foreach($model as $data) {
            $margin = 0;
            $experiments[] = $data->experiment_id;

            if($data->parent_id == NULL) {
                $no = NULL;
                $this->renderPartial('_view', array('data'=>$data, 'margin'=>$margin, 'no'=>$no));
                
                //if isset child items, than:
                $no = NULL;
                $margin = 50;
                $exps = Experiments::childrenExperiments($model, $data->experiment_id, $margin, $no);

                foreach($exps as $exp) {
                    $this->renderPartial('_view', array('data'=>$exp['data'], 'margin'=>$exp['margin'], 'no'=>$exp['no']));
                }
                $i++;

                Experiments::$childExp = array();
            }
        }
}
?>
<h3>Invited Experiments</h3>
<?php 
foreach($user->access_grants_experiments() as $experiment):
        if(!in_array($experiment->experiment_id, $experiments)) {
                $this->renderPartial('_view', array('data'=>$experiment, 'margin'=>0, 'no'=>NULL));
        }
endforeach;
?>

