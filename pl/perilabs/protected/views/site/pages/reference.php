<?php
$this->pageTitle=Yii::app()->name . ' - Experiment Design Reference';
$this->breadcrumbs=array(
	'Experiment Design Reference',
);?>

<div class="container-fluid">
	<div class="margintop">

<h1>Experiment Design</h1>
<p>Experiments are run in order to discover new information. When the results observed in an experiment can be explained in more than one way, it is much harder to draw a conclusion. For example if a cookie recipe was tested, did participants love the new recipe or did they simply grow to like all cookies more during the experiment? Alternative explanations are seen as threats to an experiments validity.</p>

<p>Good experiment designs attempt to limit or exclude any possible alternate explanations for the behavior observed during an experiment. The table below includes several experiment designs with explanations of the ways they may be affected by alternative explanations.</p>

<h1 class="margintop">Threats to Experiment Validity</h1>
</br>

<table class="span12 table table-condensed table-bordered table-striped experiment-trials-grid">
  <thead>
	<tr>
        <th>&nbsp;</th>
<th colspan="8" class="center ref"><a href="#" class="thead" id="internal" rel="popover" title="Internal Validity" data-content="In scientific research design and experimentation, validity refers to whether a study is able to scientifically answer the questions it is intended to answer.</br></br>
Internal validity refers to controlling the structural variables that are created by the experiment process itself. Any of the following variables could confound the effects of the controlled experimental treatment.">Internal Validity</a></th>
        <th colspan="4" class="center ref"><a href="#" class="thead" id="external" rel="popover" title="External Validity" data-content="In scientific research design and experimentation, validity refers to whether a study is able to scientifically answer the questions it is intended to answer.</br></br>
External validity refers to the ability to generalize the conclusions of the experiment.">External Validity</a></th>
        </tr>

        <tr>
        <th class="center" style="width: 35%">Hover for hints!</th>
	<th><a href="#" class="thead" id="popover" rel="popover" title="History" data-content="Events that occur outside of the experiment or between observations of the experimental variable may affect participants' responses. These events could be large scale natural disasters or political changes or even smaller or local changes. If the event affects participants' attitudes and behaviors, it may be impossible to determine whether any change in observed metrics is due to the historical event or the experimental variable.">History</a></th>
	<th><a href="#" class="thead" id="popover" rel="popover" title="Maturation" data-content="Subjects may change in the course of the experiment or between repeated observations due to the passage of time. Some of these changes are permanent (e.g., biological aging), while others are temporary (e.g., hunger or boredom). Between two observations subjects may change in ways that are simply due to maturation and not because of the experimental variable. ">Maturation</a></th>
	<th><a href="#" class="thead" id="popover" rel="popover" title="Testing" data-content="This threat only occurs in pre-post experiment designs. If the initial observation teaches or primes the subject for the second observation, then it can interfere with the effects of the experimental variable. This applies to human and nonhuman subjects alike. For example computers often 'cache' information, making it much faster the second time it is retrieved.">Testing</a></th>
	<th><a href="#" class="thead" id="popover" rel="popover" title="Instrumentation" data-content="This threat only applies in pre-post experiment designs. If there is any change in the measurements, tools, methods, or administration of the experiment, it may cause the observed change instead of the experimental variable. Instrument threats are particularly problematic if the instrument making the observations is a human. The observer may become tired, hungry, bored, or suffer any number of other human afflictions that may alter the resulting observations. The observer may also become better or more accurate due to practice. ">Instrumentation</a></th>
	<th><a href="#" class="thead" id="popover" rel="popover" title="Regression" data-content="Statistical regression is the phenomenon whereby retest results tend to regress toward the mean. When subjects in a study are selected because they scored extremely high or extremely low on some other test or experiment, if they were to retake that test, their scores would almost always produce a different (more normal) range of results than the first test. Consider for example a group of students who received a perfect score on a test. Some students may always receive nearly perfect scores while other students might have simply been lucky. If all the people with perfect scores were given the test again, the range of scores would most likely be lower as their luck runs out.">Regression</a></th>
	<th><a href="#" class="thead" id="popover" rel="popover" title="Selection" data-content="Selecting the groups that become your control and experimental groups can lead to serious problems. If a group is composed of individuals who are similar in some way, it may alter the results you observe in your metrics. The difference you observe may be due to the groups makeup instead of the experimental variables. The best defense against selection problems is to use a true random selection to form groups. ">Selection</a></th>
	<th><a href="#" class="thead" id="mortality" rel="popover" title="Mortality" data-content="When the composition of a group changes because people drop out of the experiment between the observations, it may cause the observations to be skewed. If you enroll students in a math program and several of the weaker students drop out along the way, the posttest results could be higher because the low scoring students were removed instead of any learning from the math program.</br></br>
Removing the pretest results for the dropout students may not solve the problem because it leads to regression validity issues (see Regression). Regression may cause the scores of the previous high performers to drop, distorting the effects of the experimental variable. When mortality is an issue, the researcher can often gauge the degree of the problem by comparing the dropout group against the control group on pretest measures. If there are no major differences, it may be reasonable to assume that mortality was happening for the whole sample and is not biasing results significantly. If the differences are large, mortality may be introducing error into the experiment.">Mortality</a></th>
	<th><a href="#" class="thead" id="sel-mat" rel="popover" title="Selection and Maturation" data-content="A selection-maturation threat results from differential rates of normal growth between pretest and posttest for the groups. If the control group matured at a different rate than the experimental group and observations were one week apart, the results for the experimental group would be affected by both maturation and the experimental variable.">Interaction of Selection and Maturation, etc.</a></th>
	<th><a href="#" class="thead" id="testing" rel="popover" title="Testing and X" data-content="The interaction between taking a pretest and the treatment itself may effect the results of the experimental group. In some cases it is preferable to use a design which does not use a pretest.">Interaction of Testing and X</a></th>
	<th><a href="#" class="thead" id="selection" rel="popover" title="Selection and X" data-content="Selection bias is controlled for by randomly assigning subjects into experimental and control groups. However if the population that the groups are selected from have different characteristics than other populations, conclusions drawn from your experiment may not apply to the other populations. Experimenters should take care to describe the population that groups were selected from.">Interaction of Selection and X</a></th>
	<th><a href="#" class="thead" id="reactive" rel="popover" title="Reactive Arrangements" data-content="Being a participant in an experiments causes individuals to act differently than they normally do. Participants may give more or less effort or perform better or worse than they otherwise would if they are aware of the experiment. In some cases, integrating the experiment into participants daily routine (to the extent possible) can help to reduce the effects of participation. Experimenters must be aware of ethical responsibilities of conducting experiments.">Reactive Arrangements</a></th>
	<th><a href="#" class="thead" id="multiple" rel="popover" title="Multiple-X Interference" data-content="Interference from multiple experimental variables occurs because exposure to variables is usually not erasable. In designs with multiple experimental variables, the effects of variables will compound with later observations.">Multiple-X Interference</a></th>
        </tr>
  </thead>
  <tbody>
	<tr>
	<td colspan="13"><a href="#" id="popover" rel="popover" title="Pre-Experimental Designs" data-content="Pre-experiments are the simplest form of research design. In a pre-experiment either a single group or multiple groups are observed after being exposed to an experimental variable.
Without comparing what happens to a group with a particular treatment against what happens to a similar group without that treatment, you cannot really be sure that the desired treatment produced an effect on the observed result. True experimental designs offer much greater ability to measure the effect of a treatment.</br></br>

Pre-experimental designs still have value. They require less time to run than true experimental designs. The greater the contrast in your results, the more confident you can be that your treatment is the cause. However extreme caution should be taken in interpreting and generalizing the results from pre-experimental studies.">Pre-Experimental Designs:</a></td>
	</tr>
	<tr>
	<td><a href="#" id="popover" rel="popover" title="One-Shot Case Study" data-content="A treatment is applied to a group and an observation is made. The experimenter is hoping the results are in a given range.</br></br>

Acceptable for simple experiments where a clear yes/no outcome is expected and certainly the least time consuming design. In most cases other designs are recommended.">1. One-Shot Case Study</a></br>
	<div class="row-fluid">
		<div class="span3">&nbsp;</div>
		<div class="span3">&nbsp;</div>
		<div class="span3">X</div>
		<div class="span3">O</div>
	</div>
	</td>
	<td class="center">&ndash;</td>
	<td class="center">&ndash;</td>
	<td></td>
	<td></td>
	<td></td>
	<td class="center">&ndash;</td>
	<td class="center">&ndash;</td>
	<td></td>
	<td></td>
	<td class="center">&ndash;</td>
	<td></td>
        <td></td>
	</tr>

	<tr>
        <td><a href="#" id="popover" rel="popover" title="One Group Pretest-Posttest" data-content="An observation is made, a treatment applied, and another observation is made. No control group or random assignment is employed.</br></br>

A benefit of this design is the inclusion of a pre-treatment observation to determine baseline scores. It allows you to quantify the change in your metrics. It is not possible to tell if the change would have occurred even without the application of the treatment however.  It is possible that the passage of time or the experience of the pretest caused the change results and not the treatment.">2. One Group Pretest-Posttest</a></br>
	<div class="row-fluid">
		<div class="span3">&nbsp;</div>
                <div class="span3">O</div>
                <div class="span3">X</div>
                <div class="span3">O</div>
        </div>
	</td>
        <td class="center">&ndash;</td>
        <td class="center">&ndash;</td>
        <td class="center">&ndash;</td>
        <td class="center">&ndash;</td>
        <td class="center">?</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">&ndash;</td>
        <td class="center">&ndash;</td>
        <td class="center">&ndash;</td>
        <td class="center">?</td>
        <td></td>
        </tr>
	
        <tr>
        <td><a href="#" id="popover" rel="popover" title="Static Group Comparison" data-content="This design has a control group but falls short in relation to showing if a change has occurred. Two groups are chosen, only one of which receives the treatment. A posttest score is then determined to measure the difference, after treatment, between the two groups. There is no pre-testing so the difference between the two groups prior to the study cannot be determined.">3. Static Group Comparison</a></br>
	<div class="row-fluid">
		<div class="span3">&nbsp;</div>
		<div class="span3">&nbsp;</div>
                <div class="span3">X</div>
                <div class="span3">O</div>
	</div>
	<div class="row-fluid">
		<div class="span3">&nbsp;</div>
		<div class="span3">&nbsp;</div>
                <div class="span3">&nbsp;</div>
                <div class="span3">O</div>
        </div>
	</td>
        <td class="center">+</td>
        <td class="center">?</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">&ndash;</td>
        <td class="center">&ndash;</td>
        <td class="center">&ndash;</td>
        <td></td>
        <td class="center">&ndash;</td>
        <td></td>
        <td></td>
        </tr>

	<tr>
	 <td colspan="13"><a href="#" id="popover" rel="popover" title="Static Group Comparison" data-content="True experimental designs have a control group and use random selection. Random selection of participants prevents bias from being introduced when the experimenter selects participants or forms groups. Using a control group and an experimental group allows for a direct comparison between a groups that is exposed to the experimental treatment and one that is not. Control groups protect experimenter from drawing a biased conclusion or by assuming or preferring an outcome.">True Experimental Designs:</a></td>
	</tr>

	<tr>
	<td><a href="#" id="popover" rel="popover" title="Pretest-Posttest Control Group" data-content="This design is one of the best and most practical to assess the impact of an experimental variable on one randomized group and one randomized control group.">4. Pretest-Posttest Control Group</a></br>
        <div class="row-fluid">
                <div class="span3">R</div>
                <div class="span3">O</div>
                <div class="span3">X</div>
                <div class="span3">O</div>
        </div>
        <div class="row-fluid">
                <div class="span3">R</div>
                <div class="span3">O</div>
                <div class="span3">&nbsp;</div>
                <div class="span3">O</div>
        </div>
	</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">&ndash;</td>
        <td class="center">?</td>
        <td class="center">?</td>
        <td></td>
        </tr>

        <tr>
        <td><a href="#" id="internal" rel="popover" title="Solomon Four-Group" data-content="This design is similar to the Pretest-Posttest Control Group but contains two extra control groups, which serve to identify if the pretest itself has an influence on the participants. It is a time consuming design but very thorough.">5. Solomon Four-Group</a></br>
        <div class="row-fluid">
                <div class="span3">R</div>
                <div class="span3">O</div>
                <div class="span3">X</div>
                <div class="span3">O</div>
        </div>
        <div class="row-fluid">
                <div class="span3">R</div>
                <div class="span3">O</div>
                <div class="span3">&nbsp;</div>
                <div class="span3">O</div>
        </div>
        <div class="row-fluid">
                <div class="span3">R</div>
                <div class="span3">&nbsp;</div>
                <div class="span3">X</div>
                <div class="span3">O</div>
        </div>
        <div class="row-fluid">
                <div class="span3">R</div>
                <div class="span3">&nbsp;</div>
                <div class="span3">&nbsp;</div>
                <div class="span3">O</div>
        </div>
	</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">?</td>
        <td class="center">?</td>
        <td></td>
        </tr>

        <tr>
        <td><a href="#" id="internal" rel="popover" title="Posttest Only Control Group" data-content="This design is simple and easy like design 3, but produces significantly more valid results since it uses random assignment to eliminate several sources of interference.">6. Posttest Only Control Group</a></br>
        <div class="row-fluid">
                <div class="span3">R</div>
                <div class="span3">&nbsp;</div>
                <div class="span3">X</div>
                <div class="span3">O</div>
        </div>
        <div class="row-fluid">
                <div class="span3">R</div>
                <div class="span3">&nbsp;</div>
                <div class="span3">&nbsp;</div>
                <div class="span3">O</div>
        </div>
	</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">?</td>
        <td class="center">?</td>
        <td></td>
        </tr>

        <tr>
         <td colspan="13"><a href="#" id="internal" rel="popover" title="Quasi-Experimental Designs" data-content="A quasi-experimental designs are similar to true experimental designs but lack random assignment of participants to groups. In most cases these designs are used when random assignment is not possible or ethical.">Quasi-Experimental Designs:</a></td>
        </tr>

        <tr>
        <td><a href="#" id="internal" rel="popover" title="Time Series" data-content="Making several observations before and after exposure to the experimental variable establishes a baseline of results. It is useful if groups cannot be randomly assigned. A variation of this design where a control group is added makes the design much stronger.">7. Time Series</a></br>
        <div class="row-fluid">
                <div class="span1">&nbsp;</div>
                <div class="span11">O O O OXO O O O</div>
        </div>
	</td>
        <td class="center">&ndash;</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">?</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">&ndash;</td>
        <td class="center">?</td>
        <td class="center">?</td>
        <td></td>
        </tr>

        <tr>
        <td><a href="#" id="internal" rel="popover" title="Equivalent Time Samples" data-content="This design is useful if the effects of the experimental variable are suspected to be temporary. Exposing participants to X0 (the control) and X1 (the experimental variable) repeatedly allows researchers to test the lasting effects of the experimental variable. In actual practice, do not simply alternate X1 (intervention) with X0 (control); instead X1 or X0 should be picked randomly.">8. Equivalent Time Samples</a></br>
	<div class="row-fluid">
                <div class="span1">&nbsp;</div>
                <div class="span11">X<sub>1</sub>O X<sub>0</sub>O X<sub>1</sub>O X<sub>0</sub>O ...</div>
        </div>
	</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">&ndash;</td>
        <td class="center">?</td>
        <td class="center">&ndash;</td>
        <td class="center">&ndash;</td>
        </tr>

        <tr>
        <td><a href="#" id="internal" rel="popover" title="Equivalent Materials Samples" data-content="This design is very similar to the Equivalent Time Samples design. If the effects of the experimental variable are enduring (IE. cannot be unlearned/forgotten) then new materials must be used for every exposure.">9. Equivalent Materials Samples</a></br>
	<div class="row-fluid">
                <div class="span12">M<sub>a</sub>X<sub>1</sub>O M<sub>b</sub>X<sub>0</sub>O M<sub>c</sub>X<sub>1</sub>O M<sub>d</sub>X<sub>0</sub>O ...</div>
        </div>
	</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">&ndash;</td>
        <td class="center">?</td>
        <td class="center">?</td>
        <td class="center">&ndash;</td>
        </tr>

        <tr>
        <td><a href="#" id="internal" rel="popover" title="Counterbalanced Design" data-content="This design is often referred to as a Latin-square design and it is useful if the effect of the experimental variables vary with the order of presentation.">10. Counterbalanced Design</a></br>
	<div class="row-fluid">
                <div class="span3">X<sub>1</sub>O X<sub>2</sub>O X<sub>3</sub>O X<sub>4</sub>O</div>
                <div class="span3">X<sub>2</sub>O X<sub>4</sub>O X<sub>1</sub>O X<sub>3</sub>O</div>
                <div class="span3">X<sub>3</sub>O X<sub>1</sub>O X<sub>4</sub>O X<sub>2</sub>O</div>
                <div class="span3">X<sub>4</sub>O X<sub>3</sub>O X<sub>2</sub>O X<sub>1</sub>O</div>
	</div>
	</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">+</td>
        <td class="center">?</td>
        <td class="center">?</td>
        <td class="center">?</td>
        <td class="center">?</td>
        <td class="center">&ndash;</td>
        </tr>
  </tbody>
</table>

<table class="span5 table table-condensed table-bordered table-striped experiment-trials-grid">
  <thead>
        <tr>
        <th colspan="2" class="center ref">Group Key</th>
        </tr>
        <tr>
        <th>Symbol</th>
        <th>Description</th>
        </tr>
  </thead>
  <tbody>
        <tr>
        <td class="center">R</td>
        <td>A random assignment of participants to different groups.</td>
        </tr>
        <tr>
        <td class="center">O</td>
        <td>An observation where data is collected for the experiments metrics. The observation may be before or after exposure to the experimental variable.</td>
        </tr>
        <tr>
        <td class="center">X</td>
        <td>The experimental variable is applied to a group.</td>
        </tr>
        <tr>
        <td class="center">M</td>
        <td>Specific materials that are being tested. Useful when materials are enduring and must be different for each exposure.</td>
        </tr>
  </tbody>
</table>
<table class="span5 table table-condensed table-bordered table-striped experiment-trials-grid">
  <thead>
        <tr>
        <th colspan="2" class="center ref">Validity Key</th>
        </tr>
        <tr>
        <th>Symbol</th>
        <th>Description</th>
        </tr>
  </thead>
  <tbody>
        <tr>
        <td class="center">&ndash;</td>
        <td>Indicates that this is a weakness of this design.</td>
        </tr>
        <tr>
        <td class="center">+</td>
        <td>Indicates that this design successfully controls for this threat to validity.</td>
        </tr>
        <tr>
        <td class="center">?</td>
        <td>Indicates a source of concern. The experimenter should think through possible threats to validity.</td>
        </tr>
        <tr>
        <td class="center">&nbsp;</td>
        <td>A blank space indicates that this threat to validity is not relevant to the design. </td>
        </tr>
  </tbody>
</table>


                </div>
        </div>
</div>

</br></br></br>
<script>$(function () { $("#internal").popover({placement:'bottom'}); });</script>
<script>$(function () { $("#external").popover({placement:'bottom'}); });</script>
<script>$(function () { $("#selection").popover({placement:'left'}); });</script>
<script>$(function () { $("#reactive").popover({placement:'left'}); });</script>
<script>$(function () { $("#multiple").popover({placement:'left'}); });</script>

