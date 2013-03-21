<html>
    <head>
        <title>You are invited to collaborate on a PeriLabs.com Experiment</title>
        <meta content = "text/html"  charset = "utf-8" http-equiv = "Content-Type" />
    </head>
    <body>

    <p>Hi,</p>

    <?php if($model->experiment__id != null) { ?>
    <p>You've been invited to collaborate on the experiment <?php echo $model->experiment->title; ?>.</p>
    <?php } ?>

    <?php if($model->organization__id != null) { ?>
    <p>You've been invited to join the organization <?php echo $model->organization->name; ?>.</p>
    <?php } ?>

    <p>To accept the invitation, visit this url in your browser: <?php echo CHtml::link(Yii::app()->createAbsoluteUrl('invitations/view', array('token'=>$model->token)), Yii::app()->createAbsoluteUrl('invitations/view', array('token'=>$model->token))); ?></p>

    <p>
    Thanks,<br/>
    The PeriLabs Team
    </p>

    </body>
</html>
