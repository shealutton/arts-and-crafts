<?php
$this->pageTitle=Yii::app()->name . ' - For Entrepreneurs';
$this->breadcrumbs=array(
	'For Entrepreneurs',
);?>

<div class="container-fluid centered">
   <div class="row-fluid">
      <div style="float: left;">
         <?php echo CHtml::link("Free Trial Account", array('site/page', 'view'=>'pricing'), array('class'=>"btn btn-primary")) ?>
      </div>
      <div style="float: right;">
         <h2>Call us today: (224) 999-0640</h2>
      </div>
   </div>
   <img class="margintop" alt="pagebreak" id="page break" src="<?php echo Yii::app()->baseUrl; ?>/images/page.break.jpg">
   
	
   <div class="frontpage margintop">
      <div class="row-fluid">
         <div class="span8">
         <h1>Are You Following The Lean Startup Model?</h1>
         <p>If you are starting a business, the most important thing you can do is test your business concepts.</p>
	    <ul>
	       <li>Do people <b>Need</b> your product?</li>
	       <li>Will people <b>Pay</b> for your product?</li>
	    </ul>
         </br>
         <h2>Peri Labs can help you run critical experiments</h2>
         <p>Peri Labs lets you run experiments on your target markets and validate your business assumptions.</p>
         <div class="row-fluid margintop">
         <div class="span4">
            <h3>Are people Excited?</h3>
            <p>It is critically important that your customers are excited by your concept. Peri Labs can help you pivot until your average excitement scores are 8 out of 10 or better.</p>
         </div>
         <div class="span4">
            <h3>Target your Sales!</h3>
            <p>Rank your potential customers by their excitement and ability to make purchasing decisions. Target the people who are high in both categories.</p>
         </div>
         <div class="span4">
            <h3>Know when to Pivot!</h3>
            <p>Passion is great, but don't let it get in the way. Review your customer scores and be prepared to pivot if your scores are too low in any category.</p>
         </div>
         </div>
      </div>
      <div class="span4">
         <!-- START Metrics Modal -->
         <p><a data-toggle="modal" href="#modalOrganize" ><img alt="Organize Image" id="organize-image" src="<?php echo Yii::app()->baseUrl; ?>/images/Trials.small.jpg"></a></p>
         <?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'modalOrganize')); ?>
         <div class="modal-header">
            <a class="close" data-dismiss="modal">&times;</a>
            <h1>See Metrics That Are Important To Your Business</h1>
         </div>
         <div class="modal-body">
            <img alt="Organize Image" id="organize-image" src="<?php echo Yii::app()->baseUrl; ?>/images/Trials.big.jpg">
         </div>
         <div class="modal-footer">
            <h4>See data that matters as you decide to pivot or proceed with your plans</h4>
            <a href="#" class="btn" data-dismiss="modal" >Close</a>
         </div>
         <?php $this->endWidget(); ?>
         <!-- FINISH Metrics Modal -->
      </div>
   </div>

   <div class="centerblock">
      <?php echo CHtml::link("Try It With A Free Account", array('site/page', 'view'=>'pricing'), array('class'=>"btn btn-primary")) ?>
   </div>

   <!-- GRAPHING -->
   <img class="margintop" alt="pagebreak" id="page break" src="<?php echo Yii::app()->baseUrl; ?>/images/page.break.jpg">
   <div class="margintop">
      <div class="row-fluid">
         <div class="span4">
            <!-- START Graphing Modal -->
            <p><a data-toggle="modal" href="#modalGather" ><img alt="Gather Image" id="gather-image" src="<?php echo Yii::app()->baseUrl; ?>/images/Graphing.small.jpg"></a></p>
            <?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'modalGather')); ?>
            <div class="modal-header">
               <a class="close" data-dismiss="modal">&times;</a>
               <h2>Track The Progress Of Your Startup</h2>
            </div>
            <div class="modal-body">
               <img alt="Gather Image" id="gather-image" src="<?php echo Yii::app()->baseUrl; ?>/images/Graphing.big.jpg">
            </div>
            <div class="modal-footer">
               <h4>See charts and graphs of your data in real time as you find a business model that works!</h4>
               <a href="#" class="btn" data-dismiss="modal" >Close</a>
            </div>
            <?php $this->endWidget(); ?>
            <!-- FINISH Gather Modal -->
         </div>

      <div class="span8 margintop">
      <h1>Share critical feedback with founders and your team</h1>
      <div class="row-fluid margintop">
         <div class="span4">
            <h3>Get out of the Office</h3>
            <p>Peri Labs lets you see your data on iPads, mobile devices, and laptops from anywhere. Peri Labs makes it easy to gather your experiment data outside the office.</p>
         </div>
         <div class="span4">
            <h3>Graphs and Stats</h3>
            <p>See graphs of your experiment results and statistics instantly. See how your new pitch compares to your old pitch. Test variables in your presentation to craft the perfect presentation.</p>
         </div>
         <div class="span4">
            <h3>Test your Presentation</h3>
            <p>Is your presentation as good as it could be? Change parts of your presentation and scientifically test the reaction. Craft the perfect presentation with science.</p>
         </div> 
      </div>
      <h2>Ready to get started? Peri Labs can put you on the right track by managing your critical experiments.</h2>
   </div>
   </div>
   <div class="centerblock">
      <?php echo CHtml::link("Start Today For Free", array('site/page', 'view'=>'pricing'), array('class'=>"btn btn-primary")) ?>
   </div>
   <img class="margintop" alt="pagebreak" id="page break" src="<?php echo Yii::app()->baseUrl; ?>/images/page.break.jpg">

</div>

</br></br></br>
