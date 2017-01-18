<h2>Activation did not work</h2>


<?php if($error == -1) echo 'The user is already activated'; ?>
<?php if($error == -2) echo 'Wrong activation Key'; ?>
<?php if($error == -3) echo 'Profile found, but no associated user. Possible database inconsistency. Please contact the System administrator with this error message, thank you'; ?>
