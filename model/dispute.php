<?php

class Dispute {
    private $id, $allergen_id, $meal_id, $explanation, $email, $date_created;

    public function __construct($id, $allergen_id, $meal_id, $explanation, $email, $date_created) {
        
        $this->id = $id;
        $this->allergen_id = $allergen_id;
        $this->meal_id = $meal_id;
        $this->explanation = $explanation;
        $this->email = $email;
        $this->date_created = $date_created;
        }
        function getId() {
            return $this->id;
        }
        function getEmail() {
            return $this->email;
        }

        function setEmail($email) {
            $this->email = $email;
        }

        
        function getAllergen_id() {
            return $this->allergen_id;
        }

        function getMeal_id() {
            return $this->meal_id;
        }

        function getExplanation() {
            return $this->explanation;
        }

        function getDate_created() {
            return $this->date_created;
        }

        function setId($id) {
            $this->id = $id;
        }

        function setAllergen_id($allergen_id) {
            $this->allergen_id = $allergen_id;
        }

        function setMeal_id($meal_id) {
            $this->meal_id = $meal_id;
        }

        function setExplanation($explanation) {
            $this->explanation = $explanation;
        }

        function setDate_created($date_created) {
            $this->date_created = $date_created;
        }


}