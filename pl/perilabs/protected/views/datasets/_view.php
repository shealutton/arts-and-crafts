<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('dataset_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->dataset_id), array('view', 'id'=>$data->dataset_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('result__id')); ?>:</b>
	<?php echo CHtml::encode($data->result__id); ?>
	<br />


</div>