"use strict";

var $ = function(id){
    return document.getElementById(id);
};

var showMealOrRestDiv = function() {
    var div = $("view_meal_or_rest").value;

    if(div === "Meals"){
        $("meal_div").style.display = "block";
        $("rest_div").style.display = "none";
    }
    else{
        $("meal_div").style.display = "none";
        $("rest_div").style.display = "block";
    }
};

window.onload = function(){
    $("view_meal_or_rest").onchange = showMealOrRestDiv;
};


        
        



