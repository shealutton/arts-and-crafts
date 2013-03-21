<?php
$breadcrumbs = array(
    'Experiments'=>array('//experiments/index'),
	$experiment->title => array('/experiments/'.$experiment->experiment_id),
);
if ($trial) $breadcrumbs[$trial->title] = array('/trials/'.$trial->trial_id);
array_push($breadcrumbs, $model->file_name);
$this->breadcrumbs = $breadcrumbs;
?>
<h1>Document: <?php echo CHtml::encode($model->file_name); ?>
<?php echo CHtml::link('Edit', array('update', 'id'=>$model->document_id), array('class'=>'btn btn-info pull-right')) ?>
</h1>
<div class="row">
    <div class="span8">
        <?php 
            $p = new CHtmlPurifier();
            $text = $p->purify(file_get_contents($path));
            echo "<div class='document-contents'>{$text}</div>";
        ?>
    </div>
</div>