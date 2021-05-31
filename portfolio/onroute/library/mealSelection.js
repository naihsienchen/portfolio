window.onload = function(){

    var radioButtons = document.getElementsByClassName("radioButton");
    var selectionRows = document.getElementsByClassName("selection_row");
    var mealSelection = document.getElementsByClassName("mealSelection")[0];
    var mealConfirmation = document.getElementsByClassName("mealConfirmation")[0];
    var formHandle = document.forms.mealSelection_form;

    //On radio button click change styling 

    var Row = [];
     for(var i = 0; i<radioButtons.length; i++){
        Row.push(selectionRows[i]);
        console.log(Row);
        radioButtons[i].onclick = function(){
            myFunction(Row[i])
        };
        
        function myFunction(Row){
            console.log(Row);
            Row.classList.add("selected")
    } 
    } 
}
