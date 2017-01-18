<html>
    <head>
        <title>Recovery password on Peri Labs</title>
        <meta content = "text/html"  charset = "utf-8" http-equiv = "Content-Type" />
    </head>
    <body>
        
        <p>Please ignore this letter if you received it by mistake!</p>
        <br/>
        <p>Go to the link if you want to recovery password:</p>
        <?php echo CHtml::link(Yii::app()->createAbsoluteUrl('user/changepassword?key=', array('key' => $model->activationKey)), Yii::app()->createAbsoluteUrl('user/changepassword', array('key' => $model->activationKey))); ?>

    </body>
</html>
