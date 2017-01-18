<html>
    <head>
        <title>You are invited to collaborate on a PeriLabs.com Experiment</title>
        <meta content = "text/html"  charset = "utf-8" http-equiv = "Content-Type" />
    </head>
    <body>

    <p>Hi,</p>

    <p>You've been invited to collaborate on the experiment <?php echo $model->experiment->title; ?>.</p>

    <p>To accept the invitation, visit this url in your browser: <?php echo CHtml::link(Yii::app()->createAbsoluteUrl('invitations/view', array('token'=>$model->token)), Yii::app()->createAbsoluteUrl('invitations/view', array('token'=>$model->token))); ?></p>

    <p>
    Thanks,<br/>
    The PeriLabs Team
    </p>

    </body>
</html>
