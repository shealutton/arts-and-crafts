<?php 
if($model->result_id == null) {
  $url = $this->createUrl("/results/create?trial_id=$trial->trial_id");
  $id = "create-result-form";
  $subheading = "<h3>Create a New Result</h3>";
  $callback = "function(data){
    $('#variables-list').append(data);
    $('#$id')[0].reset();
    return false;
  }";
} else {
  $url = $this->createUrl('/results/update/'.$model->result_id);
  $id = "result-$model->result_id";
  $subheading = "<h3>Edit Result</h3>";
  $callback = "function(data){
    $('#$id').replaceWith(data);
    return false;
  }";
}
?>

<form action="<?php echo $url ?>" method="POST" id="<?php echo $id ?>" data-remote="true" style="clear: both" >
        <div class="well">
                <?php echo $subheading ?>

                <?php $this->renderPartial('//results/_form_fields', array('trial'=>$trial, 'model'=>$model)); ?>
		<script>$("#inputfocus").focus()</script>
                <input type="submit" value="Save" class="btn btn-info" />
        </div>
</form>
