<table id="<?php echo $html_id ?>" class="table table-bordered table-striped results-grid">

	<thead>
		<tr>
			<th>Title</th>
<?php foreach($listData['metrics'] as $metric): ?>
			<th><?php echo $metric->title ?></th>
<?php endforeach; ?>
		<?php if(AccessControl::canGatherExperiment($model->experiment__id)):?>
			<th>Actions</th>
		<?php endif;?>
		</tr>
	</thead>

	<tbody>
	<?php 
	foreach ($listData['results'] as $result): 
	
		$this->renderPartial('//results/_row_view', array('result'=>$result, 'metrics'=>$listData['metrics'], 'experiment_id'=>$model->experiment__id));
		
	endforeach;
	?>
	</tbody>
</table>
