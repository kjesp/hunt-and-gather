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

     function CheckForm(){
	var checked=false;
	var elements = document.getElementsByName("check_list[]");
	for(var i=0; i < elements.length; i++){
		if(elements[i].checked) {
			checked = true;
		}
	}
	if (!checked) {
		alert('Please select at least one allergen.');
	}
	return checked;
}
     
     

window.onload = function(){
    //alert("onload");
    if($("view_meal_or_rest") !== null){
        $("view_meal_or_rest").onchange = showMealOrRestDiv;
    }
    
};


        
        



