<?php

class UserController extends Controller
{
    /**
        * Declares class-based actions.
        */
    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl',
        );
    }
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('admin', 'index', 'update', 'create', 'delete', 'view'),
                'roles'=>array('admin'),
            ),
            array('allow',
                'actions'=>array('registration','activation'),
                'users'=>array('*'),
            ),
            array('allow',
                'actions'=>array('captcha','recovery', 'changePassword'),
                'users'=>array('*'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    /**
    * This is the default 'index' action that is invoked
    * when an action is not explicitly requested by users.
    */

    public function actionIndex()
    {
        $this->redirect(Yii::app()->createUrl('user/admin'));
    }


    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        $this->render('view',array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
            $user = $this->loadModel($id);

            $model = new UserForm('update');
            $model->unsetAttributes();  // clear any default values

            $model->attributes = $user->getAttributes();
            $data = Yii::app()->request->getParam('UserForm');

            if($data) {
                $model->attributes=$data;
                if($model->validate()) {
                    $user->attributes = $model->getAttributes();
                    if($model->newPassword != NULL) {
                        $user->userPassword = $model->newPassword;
                        $user->password = $model->newPassword;
                    }
                    if($user->save()) {
                        $user->handleMemberships();
                        MailHelper::sendCustomMail(Yii::app()->params["adminEmail"], $user->email, 'Update account', 'user_update_msg', array('model' => $user));
                        $this->redirect($this->createUrl('user/admin'));
                    }
                }
            }

            $this->render('update',array(
                'model'=>$model,
                'user'=>$user,
            ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'admin' page.
     */
    public function actionCreate()
    {
        $user = new User();
        $model = new UserForm('create');


        $data = Yii::app()->request->getParam('UserForm');
        if($data) {
            $model->attributes = $data;
            if($model->validate()) {
                $user->attributes = $model->getAttributes();
                $user->userPassword = $model->password;

                if($user->save()) {
                    $user->handleMemberships();
                    MailHelper::sendCustomMail(Yii::app()->params["adminEmail"], $user->email, 'Registration account', 'registration_msg', array('model' => $user));
                    $this->redirect($this->createUrl('user/admin'));
                }
            }
        }
        $this->render('create', array('model'=>$model, 'user'=>$user));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
                // we only allow deletion via POST request
                $model = $this->loadModel($id);
                $model->status = User::STATUS_INACTIVE;
                $model->save();
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }
    
    public function actionRegistration()
    {
        $session = Yii::app()->getSession();
        $regForm = new RegistrationForm();
        $regForm->unsetAttributes();  // clear any default values

		    if (isset($_GET['plan'])) {
			    $regForm->plan = $_GET['plan'];
		    }
        $user = new User();
        $org = new Organizations();
        $membership = new Memberships();
        if($session->get('invite_token') != null) {
            $invite = Invitations::model()->find('token=:token', array(':token' => $session->get('invite_token')));
            if($invite->organization__id != null) {
                    $regForm->organization = $invite->organization->name;
            }
        }

        $data = Yii::app()->request->getParam('RegistrationForm');

        if($data) {
            $regForm->attributes = $data;
            if($regForm->validate()) {
                    if(isset($invite) and $invite->organization__id != null) {
                            $create_organization = false;
                    } else {
                            $create_organization = true;
                    }

                    $user->attributes = $regForm->getAttributes();
                    $user->userPassword = $regForm->password;
                    $session = Yii::app()->getSession();
                    if($create_organization) {
                            $org->name = $regForm->organization;
                            $org->plan = $regForm->plan;
                    }

                    if(!HOSTED) {
                            $org->plan = 'huge';
                    } 
 
                    if($create_organization) {
                            $valid = $org->validate() && $user->validate();
                    } else {
                            $valid = $user->validate();
                    }
                    if($valid) {
                            $user->save();
                            if($create_organization) {
                                    $org->save();
                                    $level = 'manager';
                            } else {
                                    $org = $invite->organization;
                                    $level = $invite->level;
                                    $invite->invited__id = $user->id;
                                    $invite->save();
                            }

                            if(isset($invite) and $invite->experiment__id != null) {
                                    $grant = new AccessGrants();
                                    $grant->experiment__id = $invite->experiment__id;
                                    $grant->user__id = $user->id;
                                    $grant->level = $invite->level;
                                    $grant->save();
                                    $invite->invited__id = $user->id;
                                    $invite->save();
                            }
                                            
                            $membership->organization__id = $org->organization_id;
                            $membership->user__id = $user->id;
                            $membership->level = $level;
                            $membership->save();

                            MailHelper::sendCustomMail(Yii::app()->params["adminEmail"], $user->email, 'Registration account', 'registration_msg', array('model' => $user));
                            $this->redirect($this->createUrl('/site/confirmemail'));
                    }
            }
        }
        $this->render('//registration/registration', array('model'=>$regForm, 'user'=>$user, 'org'=>$org));
    }
    
    public function actionActivation()
    {
        $key = Yii::app()->request->getParam('key');
        if($key) {
            $model = User::model()->find('"t"."activationKey"=:key', array(':key'=>$key));

            if ($model === null)
                throw new CHttpException('404', 'The requested page does not exist.');

            $model->setAttributes(array(
                'activationKey' => null,
                'status' => 1,
            ));
            if($model->save()) {
                $this->render('//registration/activation_success');

		// INSERT DEMO EXPERIMENT FOR NEW USERS.
		$user_id = $model->id;
                $connection = Yii::app()->db2;
                $sql ="SELECT organization_id FROM organizations WHERE organization_id IN (SELECT organization__id FROM memberships WHERE user__id = $user_id) LIMIT 1;";
                $command = $connection->createCommand($sql);
                $org_id = $command->queryRow();
                $exp = $connection->createCommand()
                ->insert('experiments', array(
                        'title'=>'My sample experiment',
                        'goal'=>'People prefer chocolate chips to raisins in oatmeal cookies.',
                        'locked'=>'1',
                        'organization__id'=>$org_id["organization_id"],
                        'user__id'=>$user_id));
		$sql ="SELECT experiment_id FROM experiments WHERE user__id = $user_id ORDER BY date_created DESC;";
		$command = $connection->createCommand($sql);
                $exp_id = $command->queryRow();
		$access = $connection->createCommand()
		->insert('access_grants', array(
			'level'=>'owner',
			'user__id'=>$user_id,
			'experiment__id'=>$exp_id["experiment_id"]));
		$c1 = $connection->createCommand()
                ->insert('constants', array(
                        'title'=>'Baking temp: 350 degrees',
                        'description'=>'Constant temp for the whole baking period', 
                        'experiment__id'=>$exp_id["experiment_id"]));
		$c2 = $connection->createCommand()
                ->insert('constants', array(
                        'title'=>'Baking time: 12 minutes',
                        'description'=>'Always pulled at 12 minutes.',
                        'experiment__id'=>$exp_id["experiment_id"]));
		$c3 = $connection->createCommand()
                ->insert('constants', array(
                        'title'=>'Same oven was used for all trials',
                        'description'=>'GE oven.',
                        'experiment__id'=>$exp_id["experiment_id"]));
		$c4 = $connection->createCommand()
                ->insert('constants', array(
                        'title'=>'Same cookie recipe was used except for chips/raisins.',
                        'description'=>'All ingredients were the same except for the chocolate chips and raisins. Flour, sugar, oats, eggs, salt, butter, and crisco were constant.',
                        'experiment__id'=>$exp_id["experiment_id"]));
		$v1 = $connection->createCommand()
                ->insert('variables', array(
                        'title'=>'Chips/Raisins: 1.5 cups',
                        'data_type__id'=>'4',
                        'experiment__id'=>$exp_id["experiment_id"]));
		$m1 = $connection->createCommand()
                ->insert('metrics', array(
                        'title'=>'Cookie rating: 1-10 scale',
                        'data_type__id'=>'2',
                        'experiment__id'=>$exp_id["experiment_id"]));
		$m2 = $connection->createCommand()
                ->insert('metrics', array(
                        'title'=>'Age',
                        'data_type__id'=>'2',
                        'experiment__id'=>$exp_id["experiment_id"]));
		$m3 = $connection->createCommand()
                ->insert('metrics', array(
                        'title'=>'Notes',
                        'data_type__id'=>'4',
                        'experiment__id'=>$exp_id["experiment_id"]));
		$con1 = $connection->createCommand()
                ->insert('conclusions', array(
                        'description'=>'On average people like chocolate chips and raisin cookies equally.',
                        'experiment__id'=>$exp_id["experiment_id"]));
		$con2= $connection->createCommand()
                ->insert('conclusions', array(
                        'description'=>'HOWEVER, the older you are, the more likely you are to like oatmeal raisin cookies. Younger people prefer oatmeal chocolate chip cookies.',
                        'experiment__id'=>$exp_id["experiment_id"]));
                $con3= $connection->createCommand()
                ->insert('conclusions', array(
                        'description'=>'You can see the trend clearly if you graph age (x axis) and cookie rating (y axis).',
                        'experiment__id'=>$exp_id["experiment_id"]));
                $sql ="SELECT variable_id FROM variables WHERE experiment__id = $exp_id[experiment_id]";
                $command = $connection->createCommand($sql);
                $var_id = $command->queryRow();
		$var_text1 = $connection->createCommand()
                ->insert('variables_text', array(
                        'value'=>'Chocolate Chips',
                        'variable__id'=>$var_id["variable_id"]));
		$var_text2 = $connection->createCommand()
                ->insert('variables_text', array(
                        'value'=>'Raisins',
                        'variable__id'=>$var_id["variable_id"]));
                //TRIAL 1 FIRST RESULT
		$t1 = $connection->createCommand()
                ->insert('trials', array(
                        'title'=>'Chocolate Chips',
                        'experiment__id'=>$exp_id["experiment_id"]));
                $sql ="SELECT trial_id FROM trials WHERE experiment__id = $exp_id[experiment_id] AND title = 'Chocolate Chips'";
                $command = $connection->createCommand($sql);
                $trial_id_choc = $command->queryRow();
		$sql ="SELECT metric_id FROM metrics WHERE experiment__id = $exp_id[experiment_id] AND title = 'Cookie rating: 1-10 scale'";
                $command = $connection->createCommand($sql);
                $metric_rate = $command->queryRow();
		$sql ="SELECT metric_id FROM metrics WHERE experiment__id = $exp_id[experiment_id] AND title = 'Age'";
                $command = $connection->createCommand($sql);
                $metric_age = $command->queryRow();
		$v_text = $connection->createCommand()
                ->insert('v_text', array(
			'trial__id'=>$trial_id_choc["trial_id"],
			'value'=>'Chocolate Chips',
			'variable__id'=>$var_id["variable_id"]));
		//TRIAL 2 FIRST RESULT
		$t1 = $connection->createCommand()
                ->insert('trials', array(
                        'title'=>'Raisins',
                        'experiment__id'=>$exp_id["experiment_id"]));
		$sql ="SELECT trial_id FROM trials WHERE experiment__id = $exp_id[experiment_id] AND title = 'Raisins'";
                $command = $connection->createCommand($sql);
                $trial_id_rais = $command->queryRow();
		$v_text = $connection->createCommand()
                ->insert('v_text', array(
                        'trial__id'=>$trial_id_rais["trial_id"],
                        'value'=>'Raisins',
                        'variable__id'=>$var_id["variable_id"]));
		//INSERT MASS VALUES
		$trial1rate = array("1000" => "6", "1001"=>"10", "1002"=>"7", "1003"=>"7", "1004"=>"10", "1005"=>"7", "1006"=>"8", "1007"=>"5", "1008"=>"7", "1009"=>"10", "1010"=>"10", "1011"=>"5", "1012"=>"7", "1013"=>"4", "1014"=>"6", "1015"=>"4", "1016"=>"5", "1017"=>"4", "1018"=>"9", "1019"=>"8", "1020"=>"8", "1021"=>"3", "1022"=>"10", "1023"=>"9", "1024"=>"6", "1025"=>"7", "1026"=>"5", "1027"=>"5", "1028"=>"8", "1029"=>"9", "1030"=>"9", "1031"=>"10", "1032"=>"5", "1033"=>"7", "1034"=>"4", "1035"=>"7", "1036"=>"6", "1037"=>"3", "1038"=>"9", "1039"=>"7", "1040"=>"9", "1041"=>"7", "1042"=>"4", "1043"=>"9", "1044"=>"5", "1045"=>"5", "1046"=>"7", "1047"=>"9", "1048"=>"6", "1049"=>"6", "1050"=>"8", "1051"=>"10", "1052"=>"10", "1053"=>"6", "1054"=>"6", "1055"=>"6", "1056"=>"7", "1057"=>"6", "1058"=>"4", "1059"=>"6", "1060"=>"3", "1061"=>"7", "1062"=>"7", "1063"=>"8", "1064"=>"4", "1065"=>"9", "1066"=>"6", "1067"=>"4", "1068"=>"6", "1069"=>"9", "1070"=>"6", "1071"=>"10", "1072"=>"5", "1073"=>"8", "1074"=>"6", "1075"=>"5", "1076"=>"7", "1077"=>"7", "1078"=>"6", "1079"=>"9", "1080"=>"5", "1081"=>"6", "1082"=>"6", "1083"=>"6", "1084"=>"5", "1085"=>"8", "1086"=>"4", "1087"=>"8", "1088"=>"8", "1089"=>"8", "1090"=>"8", "1091"=>"6", "1092"=>"5", "1093"=>"8", "1094"=>"5", "1095"=>"10", "1096"=>"4", "1097"=>"6", "1098"=>"6", "1099"=>"6");
		$trial1ages = array("1000" => "34", "1001"=>"19", "1002"=>"60", "1003"=>"71", "1004"=>"35", "1005"=>"58", "1006"=>"21", "1007"=>"53", "1008"=>"43", "1009"=>"55", "1010"=>"40", "1011"=>"44", "1012"=>"72", "1013"=>"52", "1014"=>"18", "1015"=>"65", "1016"=>"72", "1017"=>"50", "1018"=>"35", "1019"=>"30", "1020"=>"23", "1021"=>"70", "1022"=>"31", "1023"=>"56", "1024"=>"21", "1025"=>"65", "1026"=>"27", "1027"=>"73", "1028"=>"40", "1029"=>"31", "1030"=>"31", "1031"=>"28", "1032"=>"35", "1033"=>"70", "1034"=>"31", "1035"=>"62", "1036"=>"32", "1037"=>"31", "1038"=>"71", "1039"=>"70", "1040"=>"18", "1041"=>"56", "1042"=>"44", "1043"=>"30", "1044"=>"64", "1045"=>"57", "1046"=>"32", "1047"=>"48", "1048"=>"64", "1049"=>"69", "1050"=>"24", "1051"=>"42", "1052"=>"47", "1053"=>"57", "1054"=>"65", "1055"=>"28", "1056"=>"72", "1057"=>"36", "1058"=>"63", "1059"=>"29", "1060"=>"71", "1061"=>"20", "1062"=>"34", "1063"=>"69", "1064"=>"47", "1065"=>"43", "1066"=>"46", "1067"=>"57", "1068"=>"35", "1069"=>"59", "1070"=>"61", "1071"=>"42", "1072"=>"72", "1073"=>"62", "1074"=>"59", "1075"=>"62", "1076"=>"21", "1077"=>"29", "1078"=>"71", "1079"=>"40", "1080"=>"37", "1081"=>"53", "1082"=>"48", "1083"=>"39", "1084"=>"57", "1085"=>"21", "1086"=>"35", "1087"=>"65", "1088"=>"27", "1089"=>"41", "1090"=>"53", "1091"=>"70", "1092"=>"44", "1093"=>"56", "1094"=>"35", "1095"=>"19", "1096"=>"44", "1097"=>"43", "1098"=>"26", "1099"=>"25");
		$counter = 1000;
		while ($counter < 1100) {
			$r1 = $connection->createCommand()
                	->insert('results', array(
                        	'trial__id'=>$trial_id_choc["trial_id"],
                        	'title'=>$counter));
                	$sql ="INSERT INTO m_int (result__id, value, metric__id) VALUES ((SELECT result_id FROM results WHERE trial__id = '$trial_id_choc[trial_id]' AND title = '$counter'), '$trial1rate[$counter]', '$metric_rate[metric_id]');";
                	$command = $connection->createCommand($sql);
	                $m_int = $command->execute();
                        $sql ="INSERT INTO m_int (result__id, value, metric__id) VALUES ((SELECT result_id FROM results WHERE trial__id = '$trial_id_choc[trial_id]' AND title = '$counter'), '$trial1ages[$counter]', '$metric_age[metric_id]');";
                        $command = $connection->createCommand($sql);
                        $m_int = $command->execute();
			$counter = $counter + 1;
			};
		$trial2rate = array("2000" => "6", "2001"=>"8", "2002"=>"8", "2003"=>"8", "2004"=>"9", "2005"=>"6", "2006"=>"5", "2007"=>"6", "2008"=>"6", "2009"=>"4", "2010"=>"9", "2011"=>"5", "2012"=>"10", "2013"=>"10", "2014"=>"2", "2015"=>"3", "2016"=>"8", "2017"=>"7", "2018"=>"9", "2019"=>"4", "2020"=>"6", "2021"=>"6", "2022"=>"9", "2023"=>"7", "2024"=>"9", "2025"=>"5", "2026"=>"7", "2027"=>"6", "2028"=>"10", "2029"=>"6", "2030"=>"7", "2031"=>"8", "2032"=>"5", "2033"=>"7", "2034"=>"8", "2035"=>"9", "2036"=>"6", "2037"=>"8", "2038"=>"4", "2039"=>"5", "2040"=>"7", "2041"=>"8", "2042"=>"6", "2043"=>"8", "2044"=>"6", "2045"=>"10", "2046"=>"5", "2047"=>"9", "2048"=>"8", "2049"=>"5", "2050"=>"6", "2051"=>"4", "2052"=>"5", "2053"=>"7", "2054"=>"7", "2055"=>"10", "2056"=>"10", "2057"=>"9", "2058"=>"9", "2059"=>"9", "2060"=>"7", "2061"=>"6", "2062"=>"5", "2063"=>"4", "2064"=>"6", "2065"=>"6", "2066"=>"9", "2067"=>"6", "2068"=>"9", "2069"=>"7", "2070"=>"3", "2071"=>"5", "2072"=>"6", "2073"=>"7", "2074"=>"3", "2075"=>"7", "2076"=>"7", "2077"=>"6", "2078"=>"6", "2079"=>"9", "2080"=>"6", "2081"=>"5", "2082"=>"5", "2083"=>"8", "2084"=>"8", "2085"=>"7", "2086"=>"4", "2087"=>"6", "2088"=>"9", "2089"=>"8", "2090"=>"10", "2091"=>"8", "2092"=>"9", "2093"=>"8", "2094"=>"4", "2095"=>"5", "2096"=>"6", "2097"=>"6", "2098"=>"9", "2099"=>"9");
                $trial2ages = array("2000" => "34", "2001"=>"70", "2002"=>"20", "2003"=>"56", "2004"=>"43", "2005"=>"36", "2006"=>"31", "2007"=>"49", "2008"=>"45", "2009"=>"17", "2010"=>"62", "2011"=>"43", "2012"=>"71", "2013"=>"64", "2014"=>"33", "2015"=>"45", "2016"=>"45", "2017"=>"42", "2018"=>"41", "2019"=>"34", "2020"=>"52", "2021"=>"54", "2022"=>"29", "2023"=>"64", "2024"=>"72", "2025"=>"45", "2026"=>"49", "2027"=>"73", "2028"=>"65", "2029"=>"58", "2030"=>"29", "2031"=>"30", "2032"=>"44", "2033"=>"20", "2034"=>"61", "2035"=>"55", "2036"=>"72", "2037"=>"33", "2038"=>"26", "2039"=>"35", "2040"=>"64", "2041"=>"40", "2042"=>"21", "2043"=>"34", "2044"=>"69", "2045"=>"53", "2046"=>"24", "2047"=>"35", "2048"=>"72", "2049"=>"27", "2050"=>"72", "2051"=>"35", "2052"=>"31", "2053"=>"23", "2054"=>"25", "2055"=>"49", "2056"=>"54", "2057"=>"59", "2058"=>"41", "2059"=>"71", "2060"=>"42", "2061"=>"31", "2062"=>"36", "2063"=>"46", "2064"=>"20", "2065"=>"60", "2066"=>"33", "2067"=>"64", "2068"=>"18", "2069"=>"32", "2070"=>"45", "2071"=>"38", "2072"=>"64", "2073"=>"66", "2074"=>"31", "2075"=>"72", "2076"=>"59", "2077"=>"59", "2078"=>"46", "2079"=>"64", "2080"=>"71", "2081"=>"27", "2082"=>"22", "2083"=>"62", "2084"=>"30", "2085"=>"22", "2086"=>"37", "2087"=>"55", "2088"=>"71", "2089"=>"60", "2090"=>"49", "2091"=>"66", "2092"=>"55", "2093"=>"75", "2094"=>"44", "2095"=>"56", "2096"=>"71", "2097"=>"28", "2098"=>"21", "2099"=>"73");
		$counter = 2000;
                while ($counter < 2100) {
                        $r1 = $connection->createCommand()
                        ->insert('results', array(
                                'trial__id'=>$trial_id_rais["trial_id"],
                                'title'=>$counter));
                        $sql ="INSERT INTO m_int (result__id, value, metric__id) VALUES ((SELECT result_id FROM results WHERE trial__id = '$trial_id_rais[trial_id]' AND title = '$counter'), '$trial2rate[$counter]', '$metric_rate[metric_id]');";
                        $command = $connection->createCommand($sql);
                        $m_int = $command->execute();
                        $sql ="INSERT INTO m_int (result__id, value, metric__id) VALUES ((SELECT result_id FROM results WHERE trial__id = '$trial_id_rais[trial_id]' AND title = '$counter'), '$trial2ages[$counter]', '$metric_age[metric_id]');";
                        $command = $connection->createCommand($sql);
                        $m_int = $command->execute();
                        $counter = $counter + 1;
                        };

		}
        } else
            throw new CHttpException('404', 'The requested page does not exist.');
    }

    /**
    * Recovery password
    */
    public function actionRecovery()
    {
        $model = new RecoveryForm('recovery');
        $data = Yii::app()->request->getParam('RecoveryForm');

        if ($data) {
            $model->attributes = $data;

            if ($model->validate()) {
                $user = User::model()->find('email=:cond OR username=:cond', array(':cond' => $data["login_or_email"]));
                if ($user !== null) {

                    $user->attributes = $model->getAttributes(array(
                        'activationKey',
                        'status'
                    ));

                    if($user->save()) {
                        MailHelper::sendCustomMail(Yii::app()->params["adminEmail"], $user->email, 'Recovery password', 'recovery_password_msg', array('model' => $user));
                        Yii::app()->user->setFlash('success', 'Please check your mail for further instructions.');
                        $this->redirect(Yii::app()->createUrl('user/recovery'));
                    }
                } else {
                        $model->addError('login_or_email', "We couldn't find that user in our site. Are you sure your email or username is correct?");
                }
            }
        }
        $this->render('//registration/recovery', array('model' => $model));
    }

    /**
     * Change password
     */
    public function actionChangePassword()
    {
        $key = Yii::app()->request->getParam('key');
        if(isset($_REQUEST['RecoveryForm'])) {
                $data = $_REQUEST['RecoveryForm'];
        } else {
                $data = NULL;
        }

        if($key) {
            $user = User::model()->find('"activationKey"=:key', array(':key'=>$key));
            if ($user != null) {
                $model = new RecoveryForm('change');
                if($data) {
                    $model->attributes = $data;
                    if($model->validate()) {

                        $user->attributes = $model->getAttributes(array(
                            'activationKey',
                            'status',
                            'lastpasswordchange',
                            'password',
                        ));

                        $user->userPassword = $model->password;

                        if($user->save()) {
                            Yii::app()->user->setFlash('success', 'The new password has been saved.');
                            $this->redirect(Yii::app()->createUrl('site/login'));
                        }
                        $this->render('//registration/change_password', array('model' => $model));
                        Yii::app()->end();
                    }
                }
                $this->render('//registration/change_password', array('model' => $model));
            } else
                throw new CHttpException('404', 'The requested page does not exist.');
        } else
            throw new CHttpException('404', 'The requested page does not exist.');
    }

    public function actionAdmin()
    {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

        $this->render('admin', array('model'=>$model));

    }
    
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                    echo $error['message'];
            else
                    $this->render('error', $error);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model=User::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

}
