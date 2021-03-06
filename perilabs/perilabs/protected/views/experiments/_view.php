<?php if(!isset($margin)) { $margin = 0; } ?>

<div class="view <?php echo (true)? 'experiment-list-entry':'experiment-list-entry-reviewer';?>" style="min-width: 40em; position: relative; margin-left: <?php echo $margin;?>px">
  <h3 style="margin-bottom: 0; padding-bottom: 0; width: 32em;"><?php echo CHtml::link(CHtml::encode($data->title), array('view', 'id'=>$data->experiment_id)); ?>
  <?php if($data->locked): ?>
    <img src="<?php echo Yii::app()->createUrl('/') ?>/images/lock.png" />
  <?php endif ?>
  </h3>
	<div class="exp-updated" style="position: absolute; top: 0; right: 0; padding: .9em; font-size: 85%;">Updated: <?php echo CHtml::encode(date("M jS, Y", strtotime($data->last_updated))); ?></div>
	<div class="exp-created" style="font-style: italic; border-bottom: 1px solid lightgrey; padding-bottom: .125em; margin-bottom: .35em;">
		Created on <?php echo CHtml::encode(date("M jS, Y", strtotime($data->date_created))); ?>
		<?php if(isset($data->users)):?>by <?php echo CHtml::encode($data->users->firstname . ' ' . $data->users->lastname);?> <?php endif;?>
	</div>

	<div class="row">
		<div class="span8">
		<b><?php echo CHtml::encode($data->getAttributeLabel('goal')); ?>:</b>
		<?php echo CHtml::encode($data->goal); ?><br />

		<?php // CONSTANTS
		$constant_strings = array();
		?>
		<b>Constants: </b>

		<?php foreach ($data->constants as $constant) {
			$constant_strings[] = $constant->title;
		} // /foreach
		echo implode(', ', $constant_strings) . "<br />";
		?>
		<?php //}// end if $constantCount > 0 ?>

		<?php // VARIABLES
		$variable_strings = array();
		?>
		<b>Variables:</b>
		<?php foreach ($data->variables as $variable) {
			$variable_strings[] = $variable->title;
		} // /foreach
		echo implode(', ', $variable_strings) . "<br />";
		?>
		<?php //}// end if $variableCount > 0 ?>

		<?php // METRICS
		$metric_strings = array();
		?>
		<b>Metrics:</b>
		<?php foreach ($data->metrics as $metric) {
			$metric_strings[] = $metric->title;
		} // /foreach
		echo implode(', ', $metric_strings) . "<br />";
		?>
		<?php //}// end if $metricCount > 0 ?>

		<?php $conclusion_strings = array(); ?>
		<b>Conclusions:</b>
		<?php foreach ($data->conclusions as $conclusion) {
                        $conclusion_strings[] = $conclusion->description;
                } // /foreach
                echo implode(', ', $conclusion_strings);
                ?>
                <?php //}// end if $metricCount > 0 ?>

		</div> <!--/span8-->

		<div class="pull-right">
			<?php echo CHtml::link('View', array('view','id'=>$data->experiment_id), array('class'=>'btn btn-mini btn-info pull-right', 'style'=>'margin-left: 1em;')); ?>
			<?php if(AccessControl::canCopyExperiment($data->experiment_id)):?>
            <?php echo CHtml::link('Copy', array('copy','id'=>$data->experiment_id), array('class'=>'btn btn-mini btn-info pull-right', 'style'=>'margin-left: 1em;')); ?>
			<?php endif;?>

      <?php if(AccessControl::canDesignExperiment($data->experiment_id)):?>
				<?php echo CHtml::link('Edit', array('update','id'=>$data->experiment_id), array('class'=>'btn btn-mini btn-success pull-right', 'style'=>'margin-left: 1em;')); ?>
      <?php endif; ?>

      <?php if (AccessControl::canDeleteExperiment($data->experiment_id)): ?>
				<a href="<?php echo $this->createUrl('/'.Yii::app()->controller->id.'/delete/'.$data->experiment_id); ?>" input type="submit" value="Delete" class="btn btn-mini btn-danger pull-right" style="margin-left: 1em;" >Delete</a>
			<?php endif;?>
		</div><!--/-->

	</div> <!--/row-->


</div>
