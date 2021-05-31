window.onload = function(){
    //variables for ticket selection
    var selectInput = document.getElementById("numTickets")
    var optionText="";
    //FILL IN FORM SELECT FIELD WITH OPTIONS INT 1-99
    for(var i=1; i<100; i++){
        optionText+= "<option value="+i+">"+i+"</option>"
    }
    //console.log(optionText)
    //Write the options in html
    selectInput.innerHTML = optionText;
    
    //set variables for live subtotal display 
    var formHandle = document.forms.purchaseTickets;
    var subtotal = document.getElementById("subTotal")
    var tickX$5 = formHandle.numTickets.value * 5
    subtotal.innerHTML = "$"+tickX$5;
    var numTickets = formHandle.numTickets.value
    
    //display subtotal that changes when ticket number changes 
    formHandle.numTickets.onchange = function(){
        var tickX$5 = formHandle.numTickets.value * 5
        subtotal.innerHTML = "$"+tickX$5;
    }
    
    //Define variables for validation and thank you message 
    var mainContent = document.getElementById("pageContainer")
    var purchaseConfirm = 
    document.getElementById("purchaseConfirm")
    var thxMsg = document.getElementById("thxMsg")
    var name = formHandle.name.value
    var email = formHandle.email.value
    var oldTicketDiv=document.getElementById("tickets")
    //WHEN FORM IS SUBMITTED TRIGGER FUNCTION
    formHandle.onsubmit = function(){
        //VALIDATE FORM INPUTS
        //regex email format
        var emailFormat = /^([\w\.\-\_]+)@(\w+)\.(\w{2,3})/;
        //if null or empty box turns red and focus cursor
        if(formHandle.name.value==="" || formHandle.name.value===null){
            formHandle.name.style.background ="red";
            formHandle.name.focus();
            return false;
        }
        //else return to white color and continue validation
        else{
            formHandle.name.style.background="white";
        }
        //if null or empty box turns red and focus cursor
        if(formHandle.email.value==="" || formHandle.email.value===null||!emailFormat.test(formHandle.email.value)){
            formHandle.email.style.background ="red";
            formHandle.email.focus();
            return false;
        }
    
        //else return to white color and continue validation
        else{
            formHandle.email.style.background="white";
        }
        //if null or empty box turns red and focus cursor
        if(formHandle.card.value==="" || formHandle.card.value===null){
            formHandle.card.style.background ="red";
            formHandle.card.focus();
            return false;
        }
        //else return to white color and continue validation
        else{
            formHandle.card.style.background="white";
        }
        //if null or empty box turns red and focus cursor
        if(formHandle.cvv.value==="" || formHandle.cvv.value===null){
            formHandle.cvv.style.background ="red";
            formHandle.cvv.focus();
            return false;
        }
        //else return to white color and continue validation
        else{
            formHandle.cvv.style.background="white";
        }
        //if expiry is null or empty
        if(formHandle.expiry.value==="" || formHandle.expiry.value===null){
            formHandle.expiry.style.background ="red";
            formHandle.expiry.focus();
            return false;
        }
        //else return to white color, submit, and thank you message display
        else{
            formHandle.cvv.style.background="white";
            
            //have user confirm purchase 
            confirm("You are about to purchase "+formHandle.numTickets.value+" tickets. Press OK to confirm.");
            //hide main page 

            formHandle.style.display="none";

            thxMsg.innerHTML="Thank you for purchasing "+numTickets+" tickets, "+formHandle.name.value+"! A confirmation email with your reciept has been sent to " + formHandle.email.value+".";
            //remove old background image
            oldTicketDiv.style.background='none'
            //display thank you message
            purchaseConfirm.style.display="block";
            //do not allow page to refresh
            return false;
        }
        
    }
}