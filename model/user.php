<?php

class User {
    private $id,$user_role_id, $email, $pw,  
            $city, $state, $zip;

    public function __construct($id,$user_role_id, $email, $pw, 
            $city, $state, $zip) {
        
        $this->id = $id;
        $this->user_role_id = $user_role_id;
        $this->email = $email; 
        $this->pw = $pw;
        $this->city = $city;
        $this->state = $state; 
        $this->zip = $zip; 
//        $this->registration_date = $registration_date;
            }

            function getId() {
                return $this->id;
            }
            function getUser_role_id() {
                return $this->user_role_id;
            }

            function setUser_role_id($user_role_id) {
                $this->user_role_id = $user_role_id;
            }
            
            function getZip() {
                return $this->zip;
            }

            function setZip($zip) {
                $this->zip = $zip;
            }

            function getEmail() {
                return $this->email;
            }

            function getPw() {
                return $this->pw;
            }

            function getCity() {
                return $this->city;
            }

            function getState() {
                return $this->state;
            }

            function setId($id) {
                $this->id = $id;
            }

            
            function setEmail($email) {
                $this->email = $email;
            }

            function setPw($pw) {
                $this->pw = $pw;
            }


            function setCity($city) {
                $this->city = $city;
            }

            function setState($state) {
                $this->state = $state;
            }
      }