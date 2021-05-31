window.onload = function(){

    //Script that changes the form display dependant on the users choice of flight, accommodation, or vechile rentals
    var flightLink = document.getElementsByClassName("formNav__link")[0];
    var accommodationLink = document.getElementsByClassName("formNav__link")[1];
    var vehicleLink = document.getElementsByClassName("formNav__link")[2];

    var initialForm = document.getElementsByClassName("initialForm")[0];
    var flightForm = document.getElementsByClassName("tripFrom")[0];
    var accommodationForm = document.getElementsByClassName("tripFrom")[1];
    var vehicleForm = document.getElementsByClassName("tripFrom")[2];

    function flightAppear(){
        initialForm.style.display = "none";
		flightForm.style.display = "block";
        accommodationForm.style.display = "none";
		vehicleForm.style.display = "none";
	}

    function accomodationAppear(){
        initialForm.style.display = "none";
		flightForm.style.display = "none";
        accommodationForm.style.display = "block"
		vehicleForm.style.display = "none";
	}

    function vehicleAppear(){
        initialForm.style.display = "none";
		flightForm.style.display = "none";
        accommodationForm.style.display = "none"
		vehicleForm.style.display = "block";
	}

    flightLink.onclick = flightAppear;
    accommodationLink.onclick = accomodationAppear;
    vehicleLink.onclick = vehicleAppear;


}