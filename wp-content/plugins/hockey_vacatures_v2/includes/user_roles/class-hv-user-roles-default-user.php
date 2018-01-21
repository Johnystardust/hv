<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class HV_User_Roles_Default_User {

    protected $user_data;
    protected $id;

    public function __construct(){
    }

    public function register(){
        $this->id = 10;
        return $this;
    }

    public function get_id(){
        return $this->id;
    }

}