<li id="invitation-<?php echo $model->invitation_id ?>">
<?php echo $model->email_address; ?>: <?php echo $model->level; ?> 
        <span class="edit-links">
                <a href="<?php echo $this->createUrl('/invitations/update/'.$model->invitation_id) ?>" data-remote="true" title="Update Invitation">
                        <img src="<?php echo Yii::app()->baseUrl . '/images/pencil.png' ?>" alt="edit" />
                </a>
                <a href="<?php echo $this->createUrl('/invitations/delete', array('id' => $model->invitation_id)) ?>">
                        <img src="<?php echo Yii::app()->baseUrl.'/images/remove.png' ?>" alt="delete" />
                </a>
        </span>
</li>
