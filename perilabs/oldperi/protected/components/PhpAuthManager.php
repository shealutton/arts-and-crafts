<?php

class PhpAuthManager extends CPhpAuthManager{
    public function init(){
        // Roles in auth.php
        if($this->authFile===null){
            $this->authFile=Yii::getPathOfAlias('application.config.auth').'.php';
        }
 
        parent::init();
 
        // Default role is guest.
        if(!Yii::app()->user->isGuest){
            $this->assign(Yii::app()->user->role, Yii::app()->user->id);
        }
    }
}