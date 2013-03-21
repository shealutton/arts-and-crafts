<html>
    <head>
        <title>Update account on Peri Labs</title>
        <meta content = "text/html"  charset = "utf-8" http-equiv = "Content-Type" />
    </head>
    <body>
        
        <p>Your account is changed or activated by Admin.</p>
        <p>
            Login: <?php echo CHtml::value($model, 'username');?><br />
            Password: <?php echo CHtml::value($model, 'userPassword');?><br />
            Role: <?php echo CHtml::value($model, 'role');?><br />
            Status: <?php echo CHtml::value($model, 'status');?><br />
        </p>

        <?php echo CHtml::link('Check your account now', Yii::app()->createAbsoluteUrl('user/login')); ?>

    </body>
</html>
