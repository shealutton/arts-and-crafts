<?php
$this->pageTitle=Yii::app()->name . ' - Pricing';
$this->breadcrumbs=array(
	'Pricing',
);?>

<div class="container-fluid centered">
	<img alt="Pricing Image" id="pricing-image" src="<?php echo Yii::app()->baseUrl; ?>/images/pricing.jpg">
	<h1 class="margintop">Pricing</h1></br>
	<div class="row-fluid">
		<div class="span12">
		<table class="table table-striped table-bordered">
		<thead>
			<tr>
			<th></th>
			<th class="price">Unlimited</th>
			<th class="price">Large</th>
			<th class="price">Medium</th>
			<th class="price">Small</th>
			<th class="price">Free</th>
			</tr>
			</thead>
		<tbody>
			<tr>
			<td><strong>Experiments</strong></td>
			<td class="price">Unlimited</td>
			<td class="price">500</td>
			<td class="price">150</td>
			<td class="price">50</td>
			<td class="price">2</td>
			</tr>
			<tr>
			<td><strong>Storage</strong></td>
			<td class="price">100 GB</td>
			<td class="price">45 GB</td>
			<td class="price">20 GB</td>
			<td class="price">5 GB</td>
			<td class="price">10 MB</td>
			</tr>
			<tr>
			<td><strong>Price</strong></td>
			<td class="price">$249/mo</td>
			<td class="price">$129/mo</td>
			<td class="price">$69/mo</td>
			<td class="price">$39/mo</td>
			<td class="price">- NA -</td>
			</tr>
			<tr>
			<td><strong>Sign up</strong></td>
			<td class="price"><?php echo CHtml::link("Unlimited", array('register/registration?plan=huge'), array('class'=>"btn btn-primary")) ?></td>
			<td class="price"><?php echo CHtml::link("Large", array('register/registration?plan=large'), array('class'=>"btn btn-primary")) ?></td>
			<td class="price"><?php echo CHtml::link("Medium", array('register/registration?plan=medium'), array('class'=>"btn btn-primary")) ?></td>
			<td class="price"><?php echo CHtml::link("Small", array('register/registration?plan=small'), array('class'=>"btn btn-primary")) ?></td>
			<td class="price"><?php echo CHtml::link("Free", array('register/registration?plan=free'), array('class'=>"btn btn-primary")) ?></td>
			</tr>
		</tbody>
		</table>
			<div class="frontpage">
				<h3>Every account includes: </h3>
				<p>Unlimited users, bank-grade security (SSL), and daily backups of your data.</p>
			</div>
		</div>
	</div>

	<div class="frontpage well margintop">
		<div class="row-fluid">
			<div class="span12">
				<h2>Answers to common questions:</h2>
			</div>
		</div>
		<div class="row-fluid margintop">	
			<div class="span6">
				<h3>Is there a free trial?</h3>
                                <p>There sure is. You are welcome to use Peri Labs for free for your first two experiments. If you need more than that it is easy to upgrade your account.</p>
				<h3>How do I install the software?</h3>
				<p>There is no software to install. Peri Labs runs on our servers in a secure cloud so you don’t have to worry about software upgrades, security patches, or configuration. Just log in and start running experiments.</p>
				<h3>Is there an enterprise version I can run at my office?</h3>			
				<p>If you need our enterprise software we would be happy to create a quote for you. <a href="mailto:sales@perilabs.com">Contact our sales team</a>.</p>
				<h3>Do I need to sign a contract?</h3>			
				<p>No contract required. Our plans are pay as you go and you can cancel or downgrade as your needs change.</p>
				<h3>Is my data safe?</h3>			
				<p>Yes! Peri Labs goes to great lengths to make sure your data is secured and backed up. We run backups every hour so even your most recent data is protected. Our servers are kept in secure, world-class data centers.</p>
			</div>
			<div class="span6">
				<h3>Who owns my data?</h3>
				<p>Your own your data, Peri Labs just keeps it organized.</p>
				<h3>Can I take my research with me if I leave?</h3>
				<p>We make it easy to download your complete history or if you have a slow network connection we can mail it to you. <a href="mailto:sales@perilabs.com">Contact us for complete details.</a></p>
				<h3>Do you look at my research?</h3>
				<p>Your research is your business and not ours. We never look at the data in your account. Our job is to keep your data safe and keep your trust. Check out our <?php echo CHtml::link("Privacy Policy", array('site/page', 'view'=>'privacy')) ?> for more details.</p>
				<h3>Have more questions? </h3>
				<p>Drop us at line, we would love to hear from you. <a href="mailto:support@perilabs.com">support@perilabs.com</a></p>
			</div>
		</div>
	</div>
</div>
</br></br></br>
