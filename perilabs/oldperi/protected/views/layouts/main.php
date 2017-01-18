<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->

<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->

<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

  <title><?php echo CHtml::encode($this->pageTitle); ?></title>
  <?php
    $baseUrl = Yii::app()->baseUrl; 
    $cs = Yii::app()->getClientScript();
    $cs->registerScriptFile($baseUrl.'/js/rails.js');
    $cs->registerScriptFile($baseUrl.'/js/modernizr-2.5.3-respond-1.1.0.min.js');
    $cs->registerScriptFile($baseUrl.'/js/swfobject.js');
    $cs->registerScriptFile($baseUrl.'/js/jquery.uploadify.v2.1.4.min.js');
    $cs->registerScriptFile($baseUrl.'/js/ajax-scroll/jquery.ias.js');
    $cs->registerScriptFile($baseUrl.'/js/jquery-ui-1.8.20.custom.min.js');
    $cs->registerScriptFile($baseUrl.'/js/datepicker_time_addon.js');
    $cs->registerScriptFile($baseUrl.'/js/application.js');
    $cs->registerCssFile($baseUrl.'/css/jquery-ui-1.8.20.custom.css');
    $cs->registerCssFile($baseUrl.'/css/master.css');
  ?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-30090057-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>

<body>
<?php echo Yii::getPathOfAlias('upload'); ?>
<?php 

if (Yii::app()->user->isGuest) {
	$login_form = '<form class="navbar-login pull-right" action="'.$this->createUrl('/site/login').'" method="post">
				<input name="LoginForm[username]" id="YumUserLogin_username" type="text" placeholder="username" size="10" style="width: 10em; margin: 5px 0px 0px 0px;" />
				<input name="LoginForm[password]" id="YumUserLogin_password" type="password" placeholder="password" size="10" style="width: 10em; margin: 5px 0px 0px 0px;" />
                                <input name="returnUrl" value="/experiments" type="hidden" />
				<input type="submit" name="yt0" class="btn btn-primary" style="" value="Login" />
			</form>';
} else {
	$login_form = '<form class="pull-right navbar-login" action="'.$this->createUrl('/experiments/search').'" method="post">
				<input name="SearchForm[search_txt]" id="SearchForm_search_txt" type="text" placeholder="search" size="10" style="width: 10em; margin: 5px 0px 0px 0px;" />
				<input name="returnUrl" value="/experiments" type="hidden" />
				<input type="submit" name="yt0" class="btn btn-primary" style="" value="Search" />
			</form>';
}
if(isset($this->experiment) and $this->experiment != null) {
        $experiment_id = $this->experiment->experiment_id;
        $locked = $this->experiment->locked;
} else {
        $experiment_id = '';
        $locked = true;
}
$brand = '<img src="'.Yii::app()->baseUrl.'/images/RedLogoSmall.png" style="width: 167px; height: 40px;" alt="PeriLabs" />';
	$this->widget('bootstrap.widgets.BootNavbar',array(
	 'fixed' => true,
	 'brand' => $brand,
	 'form' => $login_form,
	 'brandUrl' => '/',
	 'collapse' => true,
	 'fluid' => true,
	 'items'=>array(
		array(
		'class'=>'bootstrap.widgets.BootMenu',
		'items' => array( //items chunk #1
          array('label'=>'Home', 'url'=>'/', 'visible'=>Yii::app()->user->isGuest),
          array('label'=>'Experiments', 'url'=>array('/experiments'), 'visible'=>!Yii::app()->user->isGuest,
          	'active'=> 
          		(Yii::app()->controller->id=='experiments') && (Yii::app()->controller->getAction()->getId()=='index') 
          			? true : false
          ),
          array('label'=>'>>', 'url'=>'', 'visible'=>!Yii::app()->user->isGuest && isset($this->experiment) && $this->experiment != null),
          array('label'=>($locked ? 'Gather' : 'Design'), 'url'=>array('/experiments/'.$experiment_id ), 'visible'=>!Yii::app()->user->isGuest && isset($this->experiment) && $this->experiment != null,
          	'active'=>
                (Yii::app()->controller->id=='experiments') |
                (Yii::app()->controller->id=='trials') 
          ),
          array('label'=>'Share', 'url'=>Yii::app()->createAbsoluteUrl('accessGrants/view', array('id'=>$experiment_id)),
            'visible'=>!Yii::app()->user->isGuest && isset($this->experiment) && $this->experiment != null,
            'active'=>Yii::app()->controller->id=='accessGrants'),
          array('label'=>'Analyze', 'url'=>array('/experiments/analyze?experiment_id='.$experiment_id), 'itemOptions'=>array('class'=>'disabled'), 'linkOptions'=>array('class'=>'disabled'), 'visible'=>!Yii::app()->user->isGuest && isset($this->experiment) && $this->experiment != null && $locked),
          array('label'=>'About Us', 'url'=>array('/site/page?view=about'), 'visible'=>Yii::app()->user->isGuest),
          array('label'=>'Contact', 'url'=>array('/site/contact'), 'visible'=>Yii::app()->user->isGuest),
          array('label'=>'Register', 'url'=>array('/user/registration'), 'visible'=>Yii::app()->user->isGuest),
          array('label'=>'Admin', 'url'=>array('/user/admin'), 'visible'=>Yii::app()->user->role == User::ADMIN_ROLE),
        ),//end items chunk #2
      ),
      array(
      	'class'=>'bootstrap.widgets.BootMenu',
      	'htmlOptions'=>array('class'=>'pull-right settings-dropdown-menu'),
      	'items'=>array(
      		array(
      			'label'=>'<span class="icon"></span>Settings', 
      			'url'=>'#', 
      			'items'=>array(
      				//array('label'=>'Preferences', 'url'=>''),
      				//'---',
      				array('label'=>'Logout', 'url'=>array('/site/logout')),
      			), 
      			'visible'=>!Yii::app()->user->isGuest,
      			'encodeLabel'=>false,
      		),
      	),
      ),
    ),
    )); ?>


  <div class="container-fluid">
  <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $content; ?>
  </div>
	<div class="subnav subnav-fixed">
		<?php if(isset($this->breadcrumbs)):?>
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
			)); ?><!-- breadcrumbs -->
		<?php endif?>
		<div class="copyright-notice">Copyright &copy; <?php echo date('Y'); ?> by PeriLabs.
		All Rights Reserved.</div>
	</div>

</body>
</html>

