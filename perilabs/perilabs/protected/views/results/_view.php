<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('result_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->result_id), array('view', 'id'=>$data->result_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trial__id')); ?>:</b>
	<?php echo CHtml::encode($data->trial__id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />


</div>