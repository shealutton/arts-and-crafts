<?php
$this->breadcrumbs=array(
	$model->experiment->title => array('/experiments/'.$model->experiment__id),
	$model->title,
);
?>
<h1>Trial: <?php echo CHtml::encode($model->title); ?></h1>
<div class="row">
<div class="span6">
        <h6>Variables:</h6>
        <ul>
        <?php 
        foreach($model->experiment->variables as $variable): 
        ?>
          <li><?php echo $variable->title ?>: <?php echo $model->value_for_variable($variable) ?></li>
        <?php endforeach; ?>
        </ul>
        <?php
		if(AccessControl::canWriteTrial($model->trial_id)) {
            $this->renderPartial('//results/_ajax_form', array('trial'=>$model, 'model'=>new Results));
		}
        ?>
</div>
<div class="span4">
	<h3>Documents</h3>
        <?php $this->renderPartial('//documents/_list', array("documents" => $model->documents)); ?>
		<?php if(AccessControl::canWriteTrial($model->trial_id)):?>
	    
	    <a href='#' id='popover-upload' rel='popover' title='Upload' data-content='Uploading a file attaches it to this trial. Great for attaching tools and notes.'><input class='floatLeft' name="trial_file_upload" name="Filedata" id="trial_file_upload" type="file" ></input></a>
	    <a href='#' id='popover-parse' rel='popover' title='Upload and Parse' data-content='Parsing a file adds its data to your experiment. If you want to add results to your experiment, download the Data Templates below, add your data, then use the Upload and Parse tool.'><input name="trial_file_parse" name="Filedata" id="trial_file_parse" type="file" ></input></a>
            <script type="text/javascript">
                    $(document).ready(function() {
                            $('#trial_file_upload').uploadify({
                                    scriptAccess: 'always',
                                    buttonText: 'Attach files',
                                    hideButton: true,
                                    wmode: 'transparent',
                                    height: 31,
                                    width: 70,
                                    uploader: '<?php echo Yii::app()->baseUrl.'/images/uploadify.swf' ?>',
                                    script: '<?php echo $this->createUrl('/trials/upload/' . $model->trial_id) ?>',
                                    cancelImg: '<?php echo Yii::app()->baseUrl.'/images/cancel.png' ?>',
                                    scriptData: {'PHPSESSID': '<?php echo session_id() ?>'},
                                    auto: true,
                                    onComplete: function(event, ID, fileObj, response, data) {
                                            $.ajax({
                                                    url: "<?php echo $this->createUrl('/trials/documentlist/'.$model->trial_id) ?>",
                                                    success: function(data) {
                                                            $('#document-list').replaceWith(data);
                                                    }
                                            });
                                    }
                            });

                            $('#trial_file_parse').uploadify({
                                    scriptAccess: 'always',
                                    buttonText: 'Process Data From Template',
                                    hideButton: true,
                                    wmode: 'transparent',
                                    height: 31,
                                    width: 130,
                                    uploader: '<?php echo Yii::app()->baseUrl.'/images/uploadify.swf' ?>',
                                    script: '<?php echo $this->createUrl('/trials/upload/' . $model->trial_id . '?parse=true') ?>',
                                    cancelImg: '<?php echo Yii::app()->baseUrl.'/images/cancel.png' ?>',
                                    fileExt: '*.csv;*.xls',
                                    fileDesc: '.CSV or .XLS files',
                                    scriptData: {'PHPSESSID': '<?php echo session_id() ?>'},
                                    auto: true,
                                    onComplete: function(event, ID, fileObj, response, data) {
                                            $.ajax({
                                                    url: "<?php echo $this->createUrl('/trials/documentlist/'.$model->trial_id) ?>",
                                                    success: function(data) {
                                                            $('#document-list').replaceWith(data);
                                                    }
                                            });
                                            $.ajax({
                                                    url: "<?php echo $this->createUrl('/trials/resultlist/'.$model->trial_id) ?>",
                                                    success: function(data) {
                                                            $('#results-section').replaceWith(data);
                                                    }
                                            });
                                    }
                            });
                    });
            </script>
		<?php endif;?>
                <h3>Data Templates:</h3>
                <ul>
                <li><a href="<?php echo $this->createUrl('trials/template/'.$model->trial_id) ?>">Excel (xls)</a></li>
                <li><a href="<?php echo $this->createUrl('trials/template/'.$model->trial_id.'?type=csv') ?>">Comma Separated Value (csv)</a></li>
                </ul>
</div>
</div>
<script>$(function () { $("#popover-upload").popover({placement:'left'}); });</script>
<script>$(function () { $("#popover-parse").popover({placement:'left'}); });</script>
<?php
$this->renderPartial('_result_list', array('listData' => $listData, 'model'=>$model));
Yii::app()->bootstrap->registerModal();
?>
