<?php

class Meal {
    private $id,$name, $restaurant_id, $is_official;

    public function __construct($id,$name, $restaurant_id, $is_official) {
        
        $this->id = $id;
        $this->name = $name;
        $this->restaurant_id = $restaurant_id; //start with null
        $this->is_official = $is_official; // start with false (zero)
            }

            function getId() {
                return $this->id;
            }

            function getName() {
                return $this->name;
            }

            function getRestaurant_id() {
                return $this->restaurant_id;
            }
            

            function setId($id) {
                $this->id = $id;
            }

            function setName($name) {
                $this->name = $name;
            }

            function setRestaurant_id($restaurant_id) {
                $this->restaurant_id = $restaurant_id;
            }

           
            function getIs_official() {
                return $this->is_official;
            }

            function setIs_official($is_official) {
                $this->is_official = $is_official;
            }




}