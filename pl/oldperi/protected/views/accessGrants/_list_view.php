<?php $user = User::model()->findByPk($model->user__id);?>
<?php if($user !== NULL):?>
    <li id="accessgrant-<?php echo $model->access_grant_id ?>"><?php echo CHtml::encode($user->firstname) . ' ' . CHtml::encode($user->lastname) . ' - ' . ucwords($model->level) ?>
    <?php if(AccessControl::canWriteAccessGrant($model->access_grant_id)):?>
        <a href="<?php echo $this->createUrl('/accessGrants/update/' . $model->access_grant_id) ?>" data-remote="true">
            <img src="<?php echo  Yii::app()->baseUrl ?>/images/pencil.png" />
        </a>
        <a href="<?php echo $this->createUrl('/accessGrants/delete/' . $model->access_grant_id) ?>" data-method="post" data-remote="true" data-confirm="Are you sure you want to remove this collaborator from your project?">
            <img src="<?php echo Yii::app()->baseUrl ?>/images/remove.png" />
        </a>
    </li>
    <?php endif; ?>
<?php endif; ?>
