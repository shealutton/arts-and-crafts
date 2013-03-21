<?php
$this->breadcrumbs=array(
	'Experiments'=>array('index'),
	$model->title,
);
?>
<div class="row-fluid experiment-details">
    <div class="span8">
        <h2><?php echo CHtml::encode($model->title);?></h2>
    </div>
	<div class="span4">
        <?php if(AccessControl::canDesignExperiment($model->experiment_id)) {
                echo CHtml::link(
                    'Edit Experiment',
                    array('update', 'id'=>$model->experiment_id),
                    array('class'=>'btn btn-info')
                );
                echo "<a href='#' id='popover-edit' rel='popover' title='Edit an experiment' data-content='Use this edit button to change the Title and Goal of your experiment.'><img src='/images/help.png' alt='Help popover'/></a>";
        }?>
		<?php if(AccessControl::canLockExperiment($model->experiment_id)) {
            echo CHtml::link(
                    $model->locked ? "Unlock Experiment" : "Lock Experiment",
                    array('togglelock', 'id'=>$model->experiment_id),
                    array('class'=>'btn btn-info dropdown-toggle')
            );
			if ($model->locked){
                echo "<a href='#' id='popover-unlock' rel='popover' title='Unlocking an experiment' data-content='Need to go back and fix a design mistake? You can unlock your experiment but any results you collected will be useless. You may want to copy this experiment and start a new one instead.'><img src='/images/help.png' alt='Help popover'/></a>";
                echo "<a href='#' id='popover-lock' rel='popover' title='Locking an experiment' data-content='Are you ready to run this experiment? Lock your design and you can start entering results. Remember that you need at least one variable and one metric before you can lock your experiment.'><img src='/images/help.png' alt='Help popover'/></a>";
            }
		}?>
	</div>

	<div class="row-fluid">
		<div class="span8 exp-created">
			Created on <?php echo CHtml::encode(date("M jS, Y", strtotime($model->date_created))); ?>
		</div>
		<div class="span4 exp-updated">
			Updated: <?php echo CHtml::encode(date("M jS, Y", strtotime($model->last_updated))); ?>
		</div>
	</div>
</div>
<div style="font-style: italic; border-bottom: 1px solid lightgrey; padding-bottom: .125em; margin-bottom: .35em;"></div>

<!--    <b><?php //echo CHtml::encode($model->getAttributeLabel('validity_average')); ?>:</b>
        <?php //echo CHtml::encode($model->validity_average); ?>
        <br />

        <b><?php //echo CHtml::encode($model->getAttributeLabel('value_average')); ?>:</b>
        <?php //echo CHtml::encode($model->value_average); ?>
        <br />
COMMENTED OUT UNTIL WE MAKE USE OF THIS FEATURE -->

<div class="row-fluid">
	<div class="span8">
		<!-- GOALS -->
		<h3><?php echo CHtml::encode($model->getAttributeLabel('goal')); ?>:</h3>
		<p><?php echo CHtml::encode($model->goal); ?></p>
		<!-- CONSTANTS -->
		<?php $constantCount = $model->constantCount;?>
        <h3>Constants
        <?php if(AccessControl::canDesignExperiment($model->experiment_id) and !$model->locked):?>
                    <?php echo CHtml::link(
                            '<b>+</b> Add Constants',
                            $this->createUrl('/constants/create?experiment_id='.$model->experiment_id.'#create-constant-form'),
                            array('data-toggle'=>'collapse', 'class'=>'btn btn-small', 'data-remote'=>'true', 'style'=>'line-height: 12px; padding: 3px 5px;')
                    ); ?>
                    <a href="#" id="popover-left" rel="popover" title="Add constants" data-content="Constants are the elements of your experiment that will not change. If you are testing the quality of cookies by adjusting the baking time, then the temperature of the oven, the brand and model of the oven, and the number of chocolate chips in the recipe will all be constants. Listing constants leads to better experiments and helps others reproduce your work."><img src="/images/help.png" alt="Help popover"/></a>
        <?php endif;?>
        </h3>
        <?php $this->renderPartial("//constants/_ajax_form", array("model"=> new Constants(), "experiment_id" => $model->experiment_id)) ?>
        <ul id="constants-list">
        <?php foreach ($model->constants as $constant):
                $this->renderPartial("//constants/_list_view", array("model" => $constant, "experiment_id" => $model->experiment_id));
                endforeach;
        ?>
        </ul>

		<!-- VARIABLES -->
		<h3 class="vars">Variables
        <?php if(AccessControl::canDesignExperiment($model->experiment_id) and !$model->locked): ?>
                <?php echo CHtml::link(
                    '<b>+</b> Add Variables',
                    $this->createUrl('/variables/create?experiment_id='.$model->experiment_id.'#create-variable-form'),
                    array('data-toggle'=>'collapse', 'class'=>'btn btn-small', 'data-remote'=>'true', 'style'=>'line-height: 12px; padding: 3px 5px;')
                ); ?>
                <a href="#" id="popover" rel="popover" title="Add variables" data-content="Variables are the element of your experiment that you intend to change. If you are testing the baking time of cookies, baking time is your variable. You can have multiple variables but each additional variable adds complexity to your experiment."><img src="/images/help.png" alt="Help popover"/></a>
        <?php endif;?>
		</h3>

	<?php $this->renderPartial("//variables/_ajax_form", array("model"=> new Variables(), "experiment_id" => $model->experiment_id)) ?>
        	<ul id="variables-list">
        		<?php
				foreach ($model->variables as $variable):
				$this->renderPartial("//variables/_list_view", array("model" => $variable, "experiment_id" => $model->experiment_id));
				endforeach;
			?>
		</ul>

		<!-- METRICS -->
	<?php $metricCount = $model->metricCount;?>
	<h3 class="metrics">Metrics
    <?php if(AccessControl::canDesignExperiment($model->experiment_id) and !$model->locked): ?>
            <?php echo CHtml::link(
                '<b>+</b> Add Metrics',
                $this->createUrl('/metrics/create?experiment_id='.$model->experiment_id.'#create-metric-form'),
                array('data-toggle'=>'collapse', 'class'=>'btn btn-small', 'data-remote'=>'true', 'style'=>'line-height: 12px; padding: 3px 5px;')
            ); ?>
            <a href="#" id="popover" rel="popover" title="Add metrics" data-content="Metrics are the way you measure your experiment. Often called 'dependent variables' by scientists, metrics are the data you record as you run your experiment. If you are testing the quality of cookies by adjusting the baking time, then your metrics are the way you gauge that quality. You may be interested in measuring their rating of a cookie. You might prefer to measure if they eat the entire cookie or ask for a second serving. You can have as many metrics as you want."><img src="/images/help.png" alt="Help popover"/></a>
    <?php endif;?>
    </h3>
	<?php $this->renderPartial("//metrics/_ajax_form", array("model"=> new Metrics(), "experiment_id" => $model->experiment_id)) ?>
	<ul id="metrics-list">
		<?php foreach ($model->metrics as $metric):
			$this->renderPartial("//metrics/_list_view", array("model" => $metric, "experiment_id" => $model->experiment_id));
			endforeach;
		?>
	</ul>
</div>

<div class="span4">
	<h3>Documents</h3>
            <?php $this->renderPartial('//documents/_list', array("documents" => $model->documents, "experiment_id" => $model->experiment_id)); ?>
    <?php if(AccessControl::canUploadDocumentToExperiment($model->experiment_id)):?>
			<input name="experiment_file_upload" name="Filedata" id="experiment_file_upload" type="file" ></input>
			<?php
				echo CHtml::link(
					'Create',
					array('//documents/create', 'experiment_id'=>$model->experiment_id),
					array('class'=>'btn btn-info')
				);
				echo "<a href='#' id='popover-create' rel='popover' title='Creating Documents' data-content='You can create documents with research notes, conclusions, methodologies, or anything else from inside your experiment.'><img src='/images/help.png' alt='Help popover'/></a>";
			?>
			<script type="text/javascript">
					$(document).ready(function() {
							$('#experiment_file_upload').uploadify({
									scriptAccess: 'always',
									buttonText: 'Upload',
									height: 31,
									hideButton: true,
									wmode: 'transparent',
									width: 70,
									uploader: '<?php echo Yii::app()->baseUrl.'/images/uploadify.swf' ?>',
									script: '<?php echo $this->createUrl('/experiments/upload/' . $model->experiment_id) ?>',
									cancelImg: '<?php echo Yii::app()->baseUrl.'/images/cancel.png' ?>',
									scriptData: {'PHPSESSID': '<?php echo session_id() ?>'},
									auto: true,
									onComplete: function(event, ID, fileObj, response, data) {
											$.ajax({
													url: "<?php echo $this->createUrl('/experiments/documentlist/'.$model->experiment_id) ?>",
													success: function(data) {
															$('#document-list').replaceWith(data);
													}
											});
									}
							});
					});
			</script>
  <?php endif; ?>
</div>
</div>

<div> 
	<?php if(AccessControl::canLockExperiment($model->experiment_id) and !$model->locked) {
		echo ('<p class="margintop">When you are done documenting Constants, Variables, and Metrics, lock your experiment and the trials will be generated.</p>');
    }
	?>
</div>
<?php if($model->locked) { ?>
	<h3>Trials</h3>
	<?php $this->renderPartial("//trials/_grid", array("experiment" => $model)); ?>
<?php } ?>

<script>$(function () { $("#popover-edit").popover({placement:'bottom'}); });</script>
<script>$(function () { $("#popover-lock").popover({placement:'left'}); });</script>
<script>$(function () { $("#popover-unlock").popover({placement:'bottom'}); });</script>
<script>$(function () { $("#popover-upload").popover({placement:'left'}); });</script>
<script>$(function () { $("#popover-create").popover({placement:'left'}); });</script>
