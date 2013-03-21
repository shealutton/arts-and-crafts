<?php
$this->breadcrumbs=array(
	'Experiments'=>array('index'),
	'Create',
);
?>

<h1>Create a new Experiment</h1>

<?php echo $this->renderPartial('_create-form', array('model'=>$model)); ?>

<!--

INSERT TEMPLATE SELECTION CODE HERE

-->

</br></br></br>
<h2>Tips for Designing Experiments</h2>
<h4><q>"By experiment we refer to that portion of research in which variables are manipulated and their effects upon other variables are observed." <sup>1</sup></q></h4>
</br>

<p>
Designing an experiment can be a complicated business. Hundreds of books have been written with lots of math to go with it. Lets simplify.</br>
 To start, create a <b>Title</b> or a name for your experiment. Make it something descriptive so you can find it later. Here are some examples:</br>
 <ol>
   <li>New business concept testing: Facebook for Iguanas</li>
   <li>Software performance testing, single v. multi threaded feed handlers</li>
   <li>Building a better cookie, seeking the right ratio of chocolate to dough</li>
 </ol>

 For your <b>Hypothesis or Goal</b>, think of a single statement to be tested. Good examples include:</br>
 <ol>
   <li>Consumers have strong demand (better than 8 out of 10 average) for our product concept.</li>
   <li>My new software has 15% lower latency than the older version.</li>
   <li>Consumers prefer cookies with more than 20 chocolate chips per 4 grams of dough.</li>
 </ol>
</p>

<h2>Tips</h2>
<p>Don't get too hung up on what you are testing. Take a guess if you don't know. Peri Labs makes it easy to copy your experiment so you can revise your ideas and keep making progress quickly.</p>

</br></br></br>
<h4>References</h4>
<cite>1. Campbell, D. and Stanley J. Experimental and quasi-experimental designs for research and teaching. Chicago: Rand McNally and Co., 1963.</cite>
