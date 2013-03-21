<?php

class AccessControl {

        public static function canShareOrganization($organization_id) {
                $organization = Organizations::model()->findByPk($organization_id);
                if($organization == null) {
                        return false;
                }

                if($organization->plan == 'free' and sizeof($organization->users) >= 3) {
                        return false;
                }

                if(Yii::app()->user->role == 'admin') {
                        return true;
                }

                $membership = Memberships::model()->find(
                        '"organization__id"=:organization_id AND "user__id"=:user_id',
                        array(":organization_id" => $organization_id, ":user_id" => Yii::app()->user->id)
                );
                if($membership != NULL and $membership->level == 'manager') {
                        return true;
                }
                return false;
        }

        public static function canDeleteMembership($membership_id) {
                $membership = Memberships::model()->findByPk($membership_id);
                return AccessControl::canShareOrganization($membership->organization__id);
        }


        // EXPERIMENTS
        // Admins, Oroganization Managers and Members, Experiment owners, collaborators, and reviewers
        public static function canReadExperiment($experiment_id) {
                $experiment = Experiments::model()->findByPk($experiment_id);
                if ($experiment == NULL) {
                        return false;
                }

                if(Yii::app()->user->role == 'admin') {
                        return true;
                }

                $membership = Memberships::model()->find(
                        '"organization__id"=:organization_id AND "user__id"=:user_id',
                        array(":organization_id" => $experiment->organization__id, ":user_id" => Yii::app()->user->id)
                );
                if($membership != NULL and in_array($membership->level, array('manager', 'member'))) {
                        return true;
                }

                $grant = AccessGrants::model()->find(
                        '"experiment__id"=:experiment_id AND "user__id"=:user_id',
                        array(":experiment_id" => $experiment_id, ":user_id" => Yii::app()->user->id)
                );
                if($grant != NULL and in_array($grant->level, array('owner', 'collaborator', 'reviewer'))) {
                        return true;
                }

                return false;
        }

        // Admins, Oroganization Managers and Members, Experiment owners and collaborators
        public static function canCopyExperiment($experiment_id) {
                $experiment = Experiments::model()->findByPk($experiment_id);
                if ($experiment == NULL) {
                        return false;
                }

                if(Yii::app()->user->role == 'admin') {
                        return true;
                }

                $membership = Memberships::model()->find(
                        '"organization__id"=:organization_id AND "user__id"=:user_id',
                        array(":organization_id" => $experiment->organization__id, ":user_id" => Yii::app()->user->id)
                );
                if($membership != NULL and in_array($membership->level, array('manager', 'member'))) {
                        return true;
                }

                return false;
        }

        // Admins, Organization Managers, Experiment owners and collaborators when experiment is not locked
        public static function canDesignExperiment($experiment_id) {
                $experiment = Experiments::model()->findByPk($experiment_id);
                if ($experiment == NULL) {
                        return false;
                }
                if ($experiment->locked) {
                        return false;
                }

                if(Yii::app()->user->role == 'admin') {
                        return true;
                }

                $membership = Memberships::model()->find(
                        '"organization__id"=:organization_id AND "user__id"=:user_id',
                        array(":organization_id" => $experiment->organization__id, ":user_id" => Yii::app()->user->id)
                );
                if($membership != NULL and in_array($membership->level, array('manager'))) {
                        return true;
                }

                $grant = AccessGrants::model()->find(
                        '"experiment__id"=:experiment_id AND "user__id"=:user_id',
                        array(":experiment_id" => $experiment_id, ":user_id" => Yii::app()->user->id)
                );
                if($grant != NULL and in_array($grant->level, array('owner', 'collaborator'))) {
                        return true;
                }

                return false;
        }

        // Admins, Organization Managers, Experiment owners and collaborators
        public static function canGatherExperiment($experiment_id) {
                $experiment = Experiments::model()->findByPk($experiment_id);
                if ($experiment == NULL) {
                        return false;
                }
                if (!$experiment->locked) {
                        return false;
                }

                if(Yii::app()->user->role == 'admin') {
                        return true;
                }

                $membership = Memberships::model()->find(
                        '"organization__id"=:organization_id AND "user__id"=:user_id',
                        array(":organization_id" => $experiment->organization__id, ":user_id" => Yii::app()->user->id)
                );
                if($membership != NULL and in_array($membership->level, array('manager'))) {
                        return true;
                }

                $grant = AccessGrants::model()->find(
                        '"experiment__id"=:experiment_id AND "user__id"=:user_id',
                        array(":experiment_id" => $experiment_id, ":user_id" => Yii::app()->user->id)
                );
                if($grant != NULL and in_array($grant->level, array('owner', 'collaborator'))) {
                        return true;
                }

                return false;
        }


        // Admins, Organization Managers, Experiment owners and collaborators
        public static function canUploadDocumentToExperiment($experiment_id) {
                $experiment = Experiments::model()->findByPk($experiment_id);
                if ($experiment == NULL) {
                        return false;
                }

                if(Yii::app()->user->role == 'admin') {
                        return true;
                }

                $membership = Memberships::model()->find(
                        '"organization__id"=:organization_id AND "user__id"=:user_id',
                        array(":organization_id" => $experiment->organization__id, ":user_id" => Yii::app()->user->id)
                );
                if($membership != NULL and in_array($membership->level, array('manager'))) {
                        return true;
                }

                $grant = AccessGrants::model()->find(
                        '"experiment__id"=:experiment_id AND "user__id"=:user_id',
                        array(":experiment_id" => $experiment_id, ":user_id" => Yii::app()->user->id)
                );
                if($grant != NULL and in_array($grant->level, array('owner', 'collaborator'))) {
                        return true;
                }

                return false;
        }
        
        // Admins, Organization Managers, Experiment owners
        public static function canShareExperiment($experiment_id) {
                $experiment = Experiments::model()->findByPk($experiment_id);
                if ($experiment == NULL) {
                        return false;
                }

                if ($experiment->organization->plan == 'free') {
                        return false;
                }

                if(Yii::app()->user->role == 'admin') {
                        return true;
                }

                $membership = Memberships::model()->find(
                        '"organization__id"=:organization_id AND "user__id"=:user_id',
                        array(":organization_id" => $experiment->organization__id, ":user_id" => Yii::app()->user->id)
                );
                if($membership != NULL and $membership->level == 'manager') {
                        return true;
                }

                $grant = AccessGrants::model()->find(
                        '"experiment__id"=:experiment_id AND "user__id"=:user_id',
                        array(":experiment_id" => $experiment_id, ":user_id" => Yii::app()->user->id)
                );
                if ($grant != NULL and $grant->level == 'owner') {
                        return true;
                }

                return false;
        }


        public static function canDeleteExperiment($experiment_id) {
                $experiment = Experiments::model()->findByPk($experiment_id);
                if ($experiment == NULL) {
                        return false;
                }

                if(Yii::app()->user->role == 'admin') {
                        return true;
                }

                $membership = Memberships::model()->find(
                        '"organization__id"=:organization_id AND "user__id"=:user_id',
                        array(":organization_id" => $experiment->organization__id, ":user_id" => Yii::app()->user->id)
                );
                if($membership != NULL and $membership->level == 'manager') {
                        return true;
                }

                $grant = AccessGrants::model()->find(
                        '"experiment__id"=:experiment_id AND "user__id"=:user_id',
                        array(":experiment_id" => $experiment_id, ":user_id" => Yii::app()->user->id)
                );
                if ($grant != NULL and $grant->level == 'owner') {
                        return true;
                }

                return false;
        }

        public static function canLockExperiment($experiment_id) {
                return AccessControl::canDeleteExperiment($experiment_id);
        }




        // VARIABLES
        public static function canReadVariable($variable_id) {
                $variable = Variables::model()->findByPk($variable_id);
                if($variable == null) {
                        return false;
                }
                return AccessControl::canReadExperiment($variable->experiment__id);
        }

        public static function canWriteVariable($variable_id) {
                $variable = Variables::model()->findByPk($variable_id);
                if($variable == null) {
                        return false;
                }
                return AccessControl::canDesignExperiment($variable->experiment__id);
        }

        public static function canDeleteVariable($variable_id) {
                return AccessControl::canWriteVariable($variable_id);
        }



        // CONSTANTS
        public static function canReadConstant($constant_id) {
                $constant = Constants::model()->findByPk($constant_id);
                if($constant == null) {
                        return false;
                }
                return AccessControl::canReadExperiment($constant->experiment__id);
        }

        public static function canWriteConstant($constant_id) {
                $constant = Constants::model()->findByPk($constant_id);
                if($constant == null) {
                        return false;
                }
                return AccessControl::canDesignExperiment($constant->experiment__id);
        }

        public static function canDeleteConstant($constant_id) {
                return AccessControl::canWriteConstant($constant_id);
        }



        // METRICS
        public static function canReadMetric($metric_id) {
                $metric = Metrics::model()->findByPk($metric_id);
                if($metric == null) {
                        return false;
                }
                return AccessControl::canReadExperiment($metric->experiment__id);
        }

        public static function canWriteMetric($metric_id) {
                $metric = Metrics::model()->findByPk($metric_id);
                if($metric == null) {
                        return false;
                }
                return AccessControl::canDesignExperiment($metric->experiment__id);
        }

        public static function canDeleteMetric($metric_id) {
                return AccessControl::canWriteMetric($metric_id);
        }


	// CONCLUSIONS
	public static function canReadConclusion($conclusion_id) {
                $conclusion = Conclusions::model()->findByPk($conclusion_id);
                if($conclusion == null) {
                        return false; 
                }
                return AccessControl::canReadExperiment($conclusion->experiment__id);
        }

        public static function canWriteConclusion($conclusion_id) {
                $conclusion = Conclusions::model()->findByPk($conclusion_id);
                if($conclusion == null) {
                        return false; 
                }
                return AccessControl::canGatherExperiment($conclusion->experiment__id);
        }

        public static function canDeleteConclusion($conclusion_id) {
                return AccessControl::canWriteConclusion($conclusion_id);
        }


        // TRIALS
        public static function canReadTrial($trial_id) {
                $trial = Trials::model()->findByPk($trial_id);
                if($trial == NULL) {
                        return false;
                }
                return AccessControl::canReadExperiment($trial->experiment__id);
        }

        public static function canWriteTrial($trial_id) {
                $trial = Trials::model()->findByPk($trial_id);
                if($trial == NULL) {
                        return false;
                }
                return AccessControl::canGatherExperiment($trial->experiment__id);
        }


        // RESULTS

        public static function canWriteResult($result_id) {
                $result = Results::model()->findByPK($result_id);
                if($result == NULL) {
                        return false;
                }
                return AccessControl::canWriteTrial($result->trial__id);
        }

        public static function canDeleteResult($result_id) {
                return AccessControl::canWriteResult($result_id);
        }


        // ACCESS GRANTS

        public static function canWriteAccessGrant($grant_id) {
                $access_grant = AccessGrants::model()->findByPk($grant_id);
                if($access_grant == NULL) {
                        return false;
                }
                return AccessControl::canShareExperiment($access_grant->experiment__id);
        }

        public static function canDeleteAccessGrant($grant_id) {
                return AccessControl::canWriteAccessGrant($grant_id);
        }

        // Invitations

        public static function canWriteInvitation($invitation_id) {
                $invitation = Invitations::model()->findByPk($invitation_id);
                if($invitation == NULL) {
                        return false;
                }
                if($invitation->experiment__id != null) {
                        return AccessControl::canShareExperiment($invitation->experiment__id);
                }
                if($invitation->organization__id != null) {
                        return AccessControl::canShareOrganization($invitation->organization__id);
                }
                return false;
        }

        public static function canDeleteInvitation($invitation_id) {
                return AccessControl::canWriteInvitation($invitation_id);
        }

        // DOCUMENTS
        public static function canReadDocument($document_id) {
                $document = Documents::model()->findByPk($document_id);
                if($document == NULL) {
                        return false;
                }
                if($document->experiment__id != null) {
                        return AccessControl::canReadExperiment($document->experiment__id);
                } else {
                        return AccessControl::canReadTrial($document->trial__id);
                }
        }

        public static function canWriteDocument($document_id) {
                $document = Documents::model()->findByPk($document_id);
                if($document == NULL) {
                        return false;
                }
                if($document->experiment__id != null) {
                        return (AccessControl::canGatherExperiment($document->experiment__id) or AccessControl::canDesignExperiment($document->experiment__id));
                } else {
                        return AccessControl::canWriteTrial($document->trial__id);
                }
        }

        public static function canDeleteDocument($document_id) {
                return AccessControl::canWriteDocument($document_id);
        }


}

?>
