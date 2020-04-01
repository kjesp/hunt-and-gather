<?php

class Review {
    private $id, $end_user_id, $restaurant_id, $meal_id, $comment, 
            $rating, $registration_date;

    public function __construct($id, $end_user_id, $restaurant_id, $meal_id, $comment, 
            $rating, $registration_date) {
        
        $this->id = $id;
        $this->end_user_id = $end_user_id;
        $this->restaurant_id = $restaurant_id;
        $this->meal_id = $meal_id;
        $this->comment = $comment;
        $this->rating = $rating;
        $this->registration_date = $registration_date;
            }
            function getId() {
                return $this->id;
            }

            
            function getRestaurant_id() {
                return $this->restaurant_id;
            }

            function getMeal_id() {
                return $this->meal_id;
            }

            function getComment() {
                return $this->comment;
            }

            function getRating() {
                return $this->rating;
            }

            function getRegistration_date() {
                return $this->registration_date;
            }

            function setId($id) {
                $this->id = $id;
            }
            function getEnd_user_id() {
                return $this->end_user_id;
            }

            function setEnd_user_id($end_user_id) {
                $this->end_user_id = $end_user_id;
            }

                        function setRestaurant_id($restaurant_id) {
                $this->restaurant_id = $restaurant_id;
            }

            function setMeal_id($meal_id) {
                $this->meal_id = $meal_id;
            }

            function setComment($comment) {
                $this->comment = $comment;
            }

            function setRating($rating) {
                $this->rating = $rating;
            }

            function setRegistration_date($registration_date) {
                $this->registration_date = $registration_date;
            }


}