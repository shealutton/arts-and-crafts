<?php
$this->pageTitle = 'Password recovery';

$this->breadcrumbs=array(
    'Login' => Yii::app()->createUrl('/site/login'),
    'Restore'
);
?>
<?php $flashes = Yii::app()->user->getFlashes();?>
<?php if(!empty($flashes)):?>
<div id="flash-messages">
    <?php foreach($flashes as $flashKey=>$flashMsg):?>
    <div class="flash-message <?php echo $flashKey;?>">
        <?php echo $flashMsg; ?>
    </div>
    <?php endforeach;?>
</div>
<?php else: ?>
    <h2> Password recovery </h2>

    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($model); ?>
    <?php echo CHtml::activeTextField($model,'login_or_email') ?>
    <p class="hint">Please enter the email address you registered with or your username.</p>
    <?php echo CHtml::submitButton('Restore'); ?>
    <?php echo CHtml::endForm(); ?>
    </div><!-- form -->
<?php endif; ?>
