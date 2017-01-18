<?php

class WebUser extends CWebUser
{
    private $_data = null;
    private $_fields = null;
    private $_exp = null;


    /**
     * Load model
     * @return boolean successful load or not
     */
    private function loadData()
    {
        if (!$this->isGuest && $this->_data === null){
            $this->_data = Yii::app()->db2->createCommand()
                ->select('id, role, email, lastname, firstname')
                ->from(User::model()->tableName())
                ->where('id=:id',array(':id'=>$this->id))->queryRow();
            if ( !is_array( $this->_data ) ) return false;
        }
        return true;
    }

    /**
     * Get current experiment with access level
     * @return mixed array [experiment_id][user_id] => level
     */
    /* private function getFields() */
    /* { */
    /*     if ( ( $this -> _fields === null ) && $this -> loadData() ) { */
    /*         $fields = AccessGrants::model()->findAll(array( */
    /*             'select' => 'level, experiment__id, user__id', */
    /*             'condition' => 'organization__id=:condition', */
    /*             'params' => array( */
    /*                 ':condition' => $this->_data['organization__id'], */
    /*             ), */
    /*             'with'=>array( */
    /*                 'user' => array( */
    /*                     'select' => 'organization__id', */
    /*                 ), */
    /*             ), */
    /*         )); */

    /*         $this->_fields = array(); */
    /*         foreach( $fields as $field ) { */
    /*             $this->_fields[$field->experiment__id][$field->user__id] = $field->level; */
    /*         } */
    /*     } */

    /*     return $this -> _fields; */
    /* } */

    /* public function getShowFields() */
    /* { */
    /*     if ($this -> getFields()) return $this -> getFields(); */
    /* } */

    public function getInvitation($exp_id)
    {
        if ($this -> getFields()) {
            foreach($this -> _fields as $exp=>$user){
                foreach($user as $key=>$val) {
                    $users[] = $key;
                }
            }
            $experiment = Experiments::model()->findByPk($exp_id);
            if($experiment != null && in_array($experiment->user__id, $users)) {

                if(Yii::app()->user->role == User::ADMIN_ROLE || Yii::app()->user->role == User::MANAGER_ROLE) {
                    return true;
                } else
                    return false;
            } else
                return false;
        } else
            return false;
    }

    /**
     * Get access on view experiment data
     * @return boolean true or false
     */
    /* public function getCanView($exp_id, $user_id) */
    /* { */
    /*     if($this->getInvitation($exp_id)) { */
    /*         return true; */
    /*     } elseif(isset($this -> _fields[$exp_id][$user_id]) && in_array($this -> _fields[$exp_id][$user_id], array(AccessGrants::ADMINISTRATOR_LEVEL, AccessGrants::COLLABORATOR_LEVEL, AccessGrants::REVIEWER_LEVEL))) { */
    /*         return true; */
    /*     } else */
    /*         return false; */
    /* } */

    /**
     * Get access on edit experiment data
     * @return boolean true or false
     */
    public function getCanEdit($exp_id, $user_id)
    {
        if ($this -> getFields()) {
            if($this->getInvitation($exp_id)) {
                return true;
            } elseif(isset($this -> _fields[$exp_id][$user_id]) && in_array($this -> _fields[$exp_id][$user_id], array(AccessGrants::ADMINISTRATOR_LEVEL, AccessGrants::COLLABORATOR_LEVEL))) {
                return true;
            } else
                return false;
        } else
            return false;
    }

    /**
     * Get access on administrate experiment data
     * @return boolean true or false
     */
    public function getCanAdministrate($exp_id, $user_id)
    {
        if ($this -> getFields()) {
            if($this->getInvitation($exp_id)) {
                return true;
            } elseif(isset($this -> _fields[$exp_id][$user_id]) && in_array($this -> _fields[$exp_id][$user_id], array(AccessGrants::ADMINISTRATOR_LEVEL))) {
                return true;
            } else
                return false;
        } else
            return false;
    }

    /**
     * Get access on create new experiment
     * @return boolean true or false
     */
    public function getCanCreateExp()
    {
        /* if ($this -> getFields()) { */

        /*    if($this->availableExperiments() > count($this -> _fields)) { */
        /*        return true; */
        /*    } else */
        /*        return false; */
        /* } else */
        /*     return true; */
        return true;
    }

    /**
     * Get role
     * @return mixed return current role, else - null
     */
    public function getRole()
    {
        if ( $this -> loadData() ) return $this->_data['role'];
        return null;
    }

    /**
     * Get admin email
     * @return mixed return current admin email of organization, else - null
     */
    public function getAdminEmail()
    {
        if ( $this -> loadData() ) {
            $model = Yii::app()->db2->createCommand()
                ->select('email')
                ->from(User::model()->tableName())
                ->where('organization__id=:id AND role=:role',array(':id'=>$this->_data['organization__id'], ':role'=>User::ADMIN_ROLE))->queryRow();
            return $model['email'];
        }
        return null;
    }


    /**
     * Get Organization
     * @return integer return current organization_id, else - null
     */
    public function getOrganization()
    {
        if ( $this -> loadData() ) return $this->_data['organization__id'];
        return null;
    }

}
