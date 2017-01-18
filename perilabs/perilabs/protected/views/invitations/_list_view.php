<li id="invitation-<?php echo $model->invitation_id ?>">
<?php echo $model->email_address; ?>: <?php echo $model->level; ?> 
        <span class="edit-links">
                <a href="<?php echo $this->createUrl('/invitations/delete', array('id' => $model->invitation_id)) ?>" data-remote="true" data-confirm="Are you sure you want to remove the invitation to <?php echo $model->email_address ?>?" data-method="POST">
                        <img src="<?php echo Yii::app()->baseUrl.'/images/remove.png' ?>" alt="delete" />
                </a>
        </span>
</li>
