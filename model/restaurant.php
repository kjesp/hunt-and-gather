<?php

class Restaurant {
    private $id, $name, $city, $state, $zip, $contact_first_name, 
            $contact_last_name, $phone, $is_registered, $registration_date;

    public function __construct($id, $name, $city, $state, $zip, $contact_first_name, 
            $contact_last_name, $phone, $is_registered, $registration_date) {
        
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
        $this->contactFirstName = $contact_first_name;
        $this->contactLastName = $contact_last_name;
        $this->phone = $phone;
        $this->isRegistered = $is_registered;
        $this->registration_date = $registration_date;
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
            function getZip() {
                return $this->zip;
            }

            function setZip($zip) {
                $this->zip = $zip;
            }

            
            function getState() {
                return $this->state;
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

            function getRegistration_date() {
                return $this->registration_date;
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

            function setRegistration_date($registration_date) {
                $this->registration_date = $registration_date;
            }



}