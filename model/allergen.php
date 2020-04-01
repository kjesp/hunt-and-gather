<?php

class Allergen {
    private $id,$name;

    public function __construct($id,$name) {
        
        $this->id = $id;
        $this->name = $name;
            }

            function getId() {
                return $this->id;
            }

            function getName() {
                return $this->name;
            }


}