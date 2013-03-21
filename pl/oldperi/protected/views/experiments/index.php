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

foreach($user->organizations as $organization) {
# TODO: refactor into recursive function
  $model = $organization->experiments();
?>
        <h3><?php echo $organization->name ?></h3>
<?php
        if(sizeof($model) == 0) {
                echo '<p>There are currently no experiments under this organization.</p>';
        }

        $i = 1;

        foreach($model as $data) {
            $margin = 0;

            if($data->parent_id == NULL) {
                $no = $i.'.0';
                $this->renderPartial('_view', array('data'=>$data, 'margin'=>$margin, 'no'=>$no));
                
                //if isset child items, than:
                $no = $i;
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
