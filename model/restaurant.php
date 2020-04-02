<?php

class Restaurant {
    private $id, $name, $city, $state, $zip, $contact_first_name, 
            $contact_last_name, $phone, $is_registered;

    public function __construct($id, $name, $city, $state, $zip, $contact_first_name, 
            $contact_last_name, $phone, $is_registered) {
        
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
        $this->contact_first_name = $contact_first_name;
        $this->contact_last_name = $contact_last_name;
        $this->phone = $phone;
        $this->is_registered = $is_registered;
            }
           
            function getId() {
                return $this->id;
            }

            function getName() {
                return $this->name;
            }

            function getCity() {
                return $this->city;
            }

            function getState() {
                return $this->state;
            }

            function getZip() {
                return $this->zip;
            }

            function getContact_first_name() {
                return $this->contact_first_name;
            }

            function getContact_last_name() {
                return $this->contact_last_name;
            }

            function getPhone() {
                return $this->phone;
            }

            function getIs_registered() {
                return $this->is_registered;
            }

            function setId($id) {
                $this->id = $id;
            }

            function setName($name) {
                $this->name = $name;
            }

            function setCity($city) {
                $this->city = $city;
            }

            function setState($state) {
                $this->state = $state;
            }

            function setZip($zip) {
                $this->zip = $zip;
            }

            function setContact_first_name($contact_first_name) {
                $this->contact_first_name = $contact_first_name;
            }

            function setContact_last_name($contact_last_name) {
                $this->contact_last_name = $contact_last_name;
            }

            function setPhone($phone) {
                $this->phone = $phone;
            }

            function setIs_registered($is_registered) {
                $this->is_registered = $is_registered;
            }


            
}