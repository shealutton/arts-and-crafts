<html>
    <head>
        <title>Registration for a Peri Labs account</title>
        <meta content = "text/html"  charset = "utf-8" http-equiv = "Content-Type" />
    </head>
    <body>
        
        <p>Thanks for registering with Peri Labs.</p>
        <p>
            Login: <?php echo CHtml::value($model, 'username');?><br />
            Password: <?php echo CHtml::value($model, 'userPassword');?><br />
        </p>

        <p>To confirm your E-Mail address, please visit</p>
        <?php echo CHtml::link(Yii::app()->createAbsoluteUrl('user/activation', array('key'=>$model->activationKey)), Yii::app()->createAbsoluteUrl('user/activation', array('key'=>$model->activationKey))); ?>
    </body>
</html>
