<div class="modal fade" id ="<?php echo "result-edit-modal-{$model->result_id}" ?>">
    <form action="<?php echo $this->createUrl('/results/update/'.$model->result_id) ?>" method="POST" id="<?php echo "result-{$model->result_id}" ?>" data-remote="true">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>Edit Result</h3>
        </div>

        <div class="modal-body">
            <?php $this->renderPartial('//results/_form_fields', array('trial'=>$trial, 'model'=>$model)); ?>
        </div>
        <div class="modal-footer">
            <input type="submit" value="Save" class="btn btn-info" />
        </div>
    </form>
</div>
