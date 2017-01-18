<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('trial_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->trial_id), array('view', 'id'=>$data->trial_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('experiment__id')); ?>:</b>
	<?php echo CHtml::encode($data->experiment__id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('skip_f')); ?>:</b>
	<?php echo CHtml::encode($data->skip_f); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sequence_num')); ?>:</b>
	<?php echo CHtml::encode($data->sequence_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('locked_f')); ?>:</b>
	<?php echo CHtml::encode($data->locked_f); ?>
	<br />


</div>