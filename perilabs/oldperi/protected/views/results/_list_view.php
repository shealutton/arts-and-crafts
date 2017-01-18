<li id="result-<?php echo $model->result_id; ?>" class="result"><strong><?php echo $html_id ?></strong>
<span class="title"><?php echo $model->title; ?></span>
<?php foreach($model->trial->experiment->metrics as $metric): ?>
<span class="metric-title"><?php echo $metric->title ?></span>
<span class="metric-value"><?php echo $model->value_for_metric($metric) ?></span>
<?php endforeach; ?>
<span class="edit-links">
        <a href="<?php echo $this->createUrl('/results/update/'.$model->result_id) ?>" data-remote="true" title="Delete Result">
                <img src="<?php echo Yii::app()->baseUrl . '/images/pencil.png' ?>" alt="edit" />
        </a>
        <a href="<?php echo $this->createUrl('/results/delete/'.$model->result_id) ?>" title="Delete Result" >
                <img src="<?php echo Yii::app()->baseUrl.'/images/remove.png' ?>" alt="delete" />
        </a>
</span>
</li>

