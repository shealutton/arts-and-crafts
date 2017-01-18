<tr id="result-<?php echo $result->result_id; ?>" class="result">
	<td class="result-title" id="result-<?php echo $result->result_id; ?>-title"><?php echo $result->title; ?></td>
<?php foreach($metrics as $metric): ?>
	<?php unset($value_metric);
	$value_metric = $result->value_for_metric($metric);
	if (isset($value_metric)) { ?>
		<td class="metric-value" id="metric-<?php echo $metric->metric_id; ?>-value"><?php echo $value_metric ?></td>
	<?php } else { ?>
		<td class="metric-value metric-error" id="metric-<?php echo $metric->metric_id; ?>-value"><a href='#' id='popover-missingdata' rel='popover' title='Missing Data' data-content='Data is missing from this entry.'><img alt="Exclamation Image" src="<?php echo Yii::app()->baseUrl; ?>/images/exclamation.png"></a></td> 
	<?php } ?>
<?php endforeach; ?>
	<?php if(AccessControl::canWriteResult($result->result_id)):?>
	<td class="edit-links" id="result-<?php echo $result->result_id; ?>-edit-links">
		<a href="<?php echo $this->createUrl('/results/update/' . $result->result_id); ?>" data-remote="true" class="btn btn-mini btn-info" title="Edit Data">Edit</a>
		<a href="<?php echo $this->createUrl('/results/delete/'.$result->result_id) ?>" class="btn btn-mini btn-danger" title="Delete Data" >Delete</a>
	</td>
	<?php endif;?>
</tr>
