<?php $this->pageTitle=Yii::app()->name; ?>

<div class="container-fluid centered frontpage">
		<div style="float: left;">
			<?php echo CHtml::link("Free Trial Account", array('site/page', 'view'=>'pricing'), array('class'=>"btn btn-primary")) ?>	
		</div>
		<div style="float: right;">
			<h2>Call us today: (224) 999-0640</h2>
		</div>
	<div class="margintop">
		<img src="./ImageRotator.php" alt="Peri Labs Image" />
	</div>
		<div class="row-fluid">
			<div class="span4 margintop">
				<h1>Why use Peri Labs?</h1>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span8">
				<p>Peri Labs experiment management software allows your company to operate more efficiently. It gathers data, models experiments, and shares results. It makes research more effective, so you can take your business further in less time.</br><?php echo CHtml::link("More info...", array('site/page', 'view'=>'whyPeriLabs')) ?></p>
				<h2>How does it work?</h2>
				<p>Store all your data in one place and scale when you need it. See how easy it can be to run experiments and share results. <?php echo CHtml::link("How it works...", array('site/page', 'view'=>'howitworks')) ?></p>
			</div>
			<div class="span3 well">
				<p><?php echo CHtml::link("Try it with a Free Account", array('site/page', 'view'=>'pricing'), array('class'=>"btn btn-primary")) ?></br></br>There is no obligation to pay and no credit card is required.</p>
			</div>
		</div>

	<!-- BEST PRACTICES -->
	<img class="margintop" alt="pagebreak" id="page break" src="<?php echo Yii::app()->baseUrl; ?>/images/page.break.jpg">
	<div class="margintop">
	        <div class="row-fluid">
	                <div class="span8">
	                        <h2>Best Practices</h2>
				<p>Peri Labs records data and keeps your past experiments organized. Scientists are trained to meticulously keep records so they can determine successes and build from their previous trials. Using Peri Labs, you can track your experiments, methods, and ideas. Identify your organization’s best practices and grow from them.<p>
	                	<h2 class="margintop">You gain:</h2>
				<div class="row-fluid">
					<div class="span4">
					<h3>Methods</h3>
					<p>By tracking iterations of experiments, Peri Labs can help you identify and reuse the most successful research methods.</p>
					</div>
					<div class="span4">
					<h3>History</h3>
					<p>Your history of previous experiments is kept with Peri Labs. Our software makes it easy to search and recall any previous experiment.</p>
					</div>
					<div class="span4">
					<h3>IP Protection</h3>
					<p>Retain your IP after employees leave by keeping their research history easily accessible.</p>
	                                </div>
				</div>
			</div>
		        <div class="span4">
				<!-- START BEST PRACTICES Modal -->
				<p><a data-toggle="modal" href="#modalOrganize" ><img alt="Organize Image" id="organize-image" src="<?php echo Yii::app()->baseUrl; ?>/images/organize.small.png"></a></p>
				<?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'modalOrganize')); ?>
				<div class="modal-header">
					<a class="close" data-dismiss="modal">&times;</a>
					<h3>Your dashboard shows the latest status on experiments</h3>
				</div>
				<div class="modal-body">
					<img alt="Organize Image" id="organize-image" src="<?php echo Yii::app()->baseUrl; ?>/images/organize.wide.png">
				</div>
				<div class="modal-footer">
					<h4>Find research from across your organization quickly.</h4>
					<a href="#" class="btn" data-dismiss="modal" >Close</a>
				</div>
				<?php $this->endWidget(); ?> 
				<!-- FINISH Organize Modal -->

			</div>
		</div>
	</div>
	<div class="centerblock">
		<?php echo CHtml::link("Try it with a Free Account", array('site/page', 'view'=>'pricing'), array('class'=>"btn btn-primary")) ?>
	</div>

	<!-- EFFICIENCY -->
	<img class="margintop" alt="pagebreak" id="page break" src="<?php echo Yii::app()->baseUrl; ?>/images/page.break.jpg">
	<div class="margintop">
	        <div class="row-fluid">
			<div class="span4">
				<!-- START EFFICIENCY Modal -->
                                <p><a data-toggle="modal" href="#modalGather" ><img alt="Gather Image" id="gather-image" src="<?php echo Yii::app()->baseUrl; ?>/images/gather.small.png"></a></p>
                                <?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'modalGather')); ?>
                                <div class="modal-header">
                                        <a class="close" data-dismiss="modal">&times;</a>
                                        <h3>Stay organized with all your results in one place</h3>
                                </div>
                                <div class="modal-body">
                                        <img alt="Gather Image" id="gather-image" src="<?php echo Yii::app()->baseUrl; ?>/images/gather.wide.png">
                                </div>

                                <div class="modal-footer">
                                        <h4>Save millions of results per trial!</h4>
                                        <a href="#" class="btn" data-dismiss="modal" >Close</a>
                                </div>
                                <?php $this->endWidget(); ?>
				<!-- FINISH EFFICIENCY Modal -->
                        </div>
	                <div class="span8">
				<h2>Efficiency</h2>
				<p>Peri Labs will help your organization run more efficiently. We make it easy to organize data, share results and experiments, and reuse IP. Users can invite peers to review, collaborate on, or administer experiments, so entire teams work seamlessly.<p>
	                        <div class="row-fluid margintop">
	                                <div class="span4">
					<h3>Communication</h3>
					<p>Invite peers within the company or team to review, collaborate on, or administer your experiment. Share data and results faster, and allow management to quickly and easily see what their team is doing.</p>
	                                </div>
	                                <div class="span4">
					<h3>Search</h3>
					<p>Peri Labs makes finding data easy, whether it is from your experiment or your coworkers. Search across variables, metrics, constants, goals and supporting documents.</p>
	                                </div>
					<div class="span4">
					<h3>Scheduling</h3>
					<p>Eliminate unnecessary employee hours by increasing efficiency and communication. Share experiments within a group to eliminate duplication of efforts.</p>
	                                </div>
	                        </div>
				<h3>Innovation</h3>
				<p>Peri Labs helps you take advantage of discovery and innovation by getting the information to the people who need it. Spread great ideas to the people who need them faster than ever before.</p>
	                </div>
	        </div>
	</div>
	<div class="centerblock">
		<?php echo CHtml::link("Try it with a Free Account", array('site/page', 'view'=>'pricing'), array('class'=>"btn btn-primary")) ?>
	</div>

	<!-- VALIDATE -->
	<img class="margintop" alt="pagebreak" id="page break" src="<?php echo Yii::app()->baseUrl; ?>/images/page.break.jpg">
	<div class="margintop">
	        <div class="row-fluid">
	                <div class="span8">
	                        <h2>Validate</h2>
	                        <p>Mistakes can be extremely costly and come from unverified results. Peri Labs makes it simple for someone to view another person’s results and the steps taken to get there, making fact-checking simple and painless.</p>
	                        <div class="row-fluid margintop">
	                                <div class="span4">
					<h3>Conclusions</h3>
					<p>Verify that conclusions are sound by quickly and easily reviewing its data and analysis. Reviewers can “look but not touch” to verify the experiment was done correctly, without making changes.</p>			
	                                </div>
	                                <div class="span4">
					<h3>Decisions</h3>
					<p>Ensure that actionable decisions are correct by viewing the conclusions that led to that decision. Decision makers can easily review conclusions and experiments to check that their actions are well-supported.</p>
	                                </div>
	                                <div class="span4">
	                                <h3>Backups and Security</h3>
	                                <p>Your data is backed up every hour for safety.  Our servers are hosted in world-class data centers with strict security.</p>
	                                </div>
	                        </div>
	                </div>
	                <h3></h3>
	                <p></p>
	                <div class="span4">
				<!-- START Share Modal -->
                                <p><a data-toggle="modal" href="#modalShare" ><img alt="Share Image" id="share-image" src="<?php echo Yii::app()->baseUrl; ?>/images/share.small.png"></a></p>
                                <?php $this->beginWidget('bootstrap.widgets.BootModal', array('id'=>'modalShare')); ?>
                                <div class="modal-header">
                                        <a class="close" data-dismiss="modal">&times;</a>
                                        <h3>Invite collaborators from inside or outside your organization with permissions you control</h3>
                                </div>
                                <div class="modal-body">
                                        <img alt="Share Image" id="share-image" src="<?php echo Yii::app()->baseUrl; ?>/images/share.wide.png">
                                </div>
                                <div class="modal-footer">
                                        <h4>Modify access rights quickly and easily.</h4>
                                        <a href="#" class="btn" data-dismiss="modal" >Close</a>
                                </div>
                                <?php $this->endWidget(); ?>
                                <!-- FINISH Share Modal -->
	                </div>
	        </div>
	</div>
	<div class="centerblock">
		<?php echo CHtml::link("Try it with a Free Account", array('site/page', 'view'=>'pricing'), array('class'=>"btn btn-primary")) ?>
	</div>
</div>
<div class="centered">
	<img class="margintop" alt="pagebreak" id="page break" src="<?php echo Yii::app()->baseUrl; ?>/images/page.break.jpg">
</div>

<!-- FOOTER -->
<div class="container margintop">
	<div class="row">
                <div class="span2 offset2"><h4>Legal</h4></div>
                <div class="span2"><h4>Support</h4></div>
                <div class="span2"><h4>Community</h4></div>
                <div class="span2"><h4>Contact</h4></div>
	</div>
	<div class="row">
                <div class="span2 offset2"><?php echo CHtml::link("Privacy Policy", array('site/page', 'view'=>'privacy')) ?></div>
                <div class="span2"><?php echo CHtml::link("How it Works", array('site/page', 'view'=>'howitworks')) ?></div>
                <div class="span2"><a href="http://www.linkedin.com/company/2513003">Linked In</a></div>
                <div class="span2"><?php echo CHtml::link("Contact Us", array('/site/contact')) ?></div>
        </div>
        <div class="row">
                <div class="span2 offset2"><?php echo CHtml::link("Security Policy", array('site/page', 'view'=>'security')) ?></div>
                <div class="span2"><?php echo CHtml::link("Design of Experiments", array('site/page', 'view'=>'design')) ?></div>
                <div class="span2"><a href="https://twitter.com/#!/PeriLabs">Twitter</a></div>
                <div class="span2"><?php echo CHtml::link("About Us", array('site/page', 'view'=>'about')) ?></div>
        </div>
        <div class="row">
                <div class="span2 offset2"><?php echo CHtml::link("Terms of Service", array('site/page', 'view'=>'tos')) ?></div>
                <div class="span2"><?php echo CHtml::link("Experiment Design Chart", array('site/page', 'view'=>'reference')) ?></div>
                <div class="span2"><?php echo CHtml::link("&nbsp;", array('site/page', 'view'=>'comingsoon')) ?></div>
                <!--<div class="span2"><?php //echo CHtml::link("Blog", array('site/page', 'view'=>'comingsoon')) ?></div>-->
                <div class="span2"><?php echo CHtml::link("We're Hiring", array('site/page', 'view'=>'hiring')) ?></div>
        </div>
	<div class="row">
		<div class="span2 offset4"><?php echo CHtml::link("Enterprise Software", array('site/page', 'view'=>'prp')) ?></div>
		<div class="span2 offset2">
		<span id="siteseal"><script type="text/javascript" src="https://seal.starfieldtech.com/getSeal?sealID=4KGZAmi9BGBGrKVyetUzfkkIbKXT5A84dGqdYprjtyyDOsFPlCFgm"></script><br/><a style="font-family: arial; font-size: 9px" href="http://www.starfieldtech.com" target="_blank"></a></span>
		</div>
	</div>
</div>
</div>

<br>


