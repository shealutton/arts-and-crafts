<div class="form">
        <?php $activeform = $this->beginWidget('CActiveForm', array(
        'id'=>'create-form',
        'enableAjaxValidation'=>true,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $activeform->errorSummary($model); ?>
    <?php echo $activeform->errorSummary($user); ?>

    <?php echo $activeform->hiddenField($model, 'plan', array('value'=>(Yii::app()->user->plan)? Yii::app()->user->plan:'free')); ?>

    <?php
    echo $activeform->labelEx($model,'username');
    echo $activeform->textField($model,'username');
    ?>

    <?php
    echo $activeform->labelEx($model,'firstname');
    echo $activeform->textField($model,'firstname');
    ?>

    <?php
    echo $activeform->labelEx($model,'lastname');
    echo $activeform->textField($model,'lastname');
    ?>

    <?php
    echo $activeform->labelEx($model,'email');
    echo $activeform->textField($model,'email');
    ?>
    <?php if(Yii::app()->controller->getAction()->getId() == 'create'):?>
        <?php echo $activeform->labelEx($model,'password').'<p>Passwords require 8 characters and must contain at least 1 number</p>'; ?>
        <?php echo $activeform->passwordField($model,'password'); ?>
    <?php else:?>
        <?php echo $activeform->labelEx($model,'newPassword').'<p>Passwords require 8 characters and must contain at least 1 number</p>'; ?>
        <?php echo $activeform->passwordField($model,'newPassword'); ?>
    <?php endif;?>
    <?php echo $activeform->labelEx($model,'verifyPassword'); ?>
    <?php echo $activeform->passwordField($model,'verifyPassword'); ?>

    <?php if($model->id != Yii::app()->user->id):?>
        <?php echo $activeform->labelEx($model,'role'); ?>
        <?php echo $activeform->dropDownList($model,'role', array(User::USER_ROLE=>'user', User::MANAGER_ROLE=>'manager')); ?>
        <?php if($model->getScenario() == 'update'):?>
            <br/>
            <?php echo $activeform->labelEx($model,'status'); ?>
            <?php echo $activeform->dropDownList($model,'status', array(User::STATUS_ACTIVE=>'active', User::STATUS_BANNED=>'banned', User::STATUS_INACTIVE=>'inactive')); ?>
        <?php endif;?>
    <?php endif;?>
    <br/>

    <?php echo CHtml::submitButton((Yii::app()->controller->getAction()->getId() == 'create') ? 'Create':'Update'); ?>

    <?php $this->endWidget(); ?>
</div><!-- form -->
