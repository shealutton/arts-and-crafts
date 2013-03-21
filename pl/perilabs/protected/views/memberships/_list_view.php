<li id="membership-<?php echo $model->membership_id ?>">
  <a href="mailto:<?php echo $model->user->email ?>">
    <?php echo $model->user->firstname ?> <?php echo $model->user->lastname ?>
  </a> - <?php echo $model->level ?></a>
  <a href="<?php echo $this->createUrl('/memberships/delete/' . $model->membership_id) ?>" data-method="post" data-remote="true" data-confirm="Are you sure you want to remove this member from your organization?">
     <img src="<?php echo Yii::app()->baseUrl ?>/images/remove.png" />
   </a>
</li>
