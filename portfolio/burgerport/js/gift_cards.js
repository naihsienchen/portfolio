//Access form
window.onload = function(){

    var purchaseFormHandle = document.forms.buy_gc;
        
    //Sets function to occer when form submission is set
    purchaseFormHandle.onsubmit = processPurchaseForm;

    //Function to validate inputs and display success message
    function processPurchaseForm(){

        //Assign variables for each input, as well as corresponding validation formats
        var amountInput = document.getElementById("amountInput");
        var nameInput = document.getElementById("nameInput");
        var emailInput = document.getElementById("emailInput");
        var senderInput = document.getElementById("senderInput");
        var dateInput = document.getElementById("deliveryDateInput");
        var fullDateInput = dateInput.value;
        var timeNow = new Date();
        var dateSelected = new Date(fullDateInput + 'T23:59:59');
        var messageInput = document.getElementById("message");
  

        //REGEX formatting
        var stringFormat = /^[A-Za-z]+\s?[A-Za-z]+$/i;
        var intFormat = /^([1-9][0-9]*)\.?(\d{2})?$/;
        var emailFormat = /^([\w\.\-\_]+)@(\w+)\.(\w{2,3})/;
        
        //Validates form fields
        if(!intFormat.test(amountInput.value)){ 
            amountInput.style.background = "red";
            amountInput.focus();
            return false;
        }
        else{
            amountInput.style.background = "white";
        }
        
        if(!stringFormat.test(nameInput.value)){ 
            nameInput.style.background = "red";
            nameInput.focus();
            return false;
        }
        else{
            nameInput.style.background = "white";
        }
        
        if(!emailFormat.test(emailInput.value)){ 
            emailInput.style.background = "red";
            emailInput.focus();
            return false;
        }
        else{
            emailInput.style.background = "white";
        }

        if(!stringFormat.test(senderInput.value)){ 
            senderInput.style.background = "red";
            senderInput.focus();
            return false;
        }
        else{
            senderInput.style.background = "white";
        }

        if (dateSelected < timeNow || dateInput.value === ""){
            dateInput.style.background = "red";
            dateInput.focus();
            return false;
        }
        else{
            dateInput.style.background = "white";
        }

        //Gets HTML elements for displaying thanks message
        var thanksMsg = document.getElementById("thanksMsg");
        var buyGCForm = document.getElementById("buyGCForm");
        var buyGCTitle = document.getElementById("buyGCTitle")

        var buyerName = document.getElementById("buyerName");
        var gcAmount = document.getElementById("gcAmount");
        var gcEmail = document.getElementById("gcEmail");
        var sendDate = document.getElementById("sendDate");
        var customerMsg = document.getElementById("customerMsg");

        //Displays thanks message
        buyGCTitle.style.display = "none";
        buyGCForm.style.display = "none";
        thanksMsg.style.display = "inherit";

        customerMsg.innerText = messageInput.value;
        buyerName.innerText = nameInput.value;
        gcAmount.innerText = '$' + amountInput.value;
        gcEmail.innerText = emailInput.value;
        sendDate.innerText = fullDateInput;

        //Prevents form from fully submitting, for project purposes
        return false;
    }
       
    
    //Refresh button to reset inputs
    var refreshBtn1 = document.getElementsByClassName("refreshBtn")[0];
    refreshBtn1.onclick = refreshPage;

    function refreshPage(){
        location.reload();
    }
        

    //Similar set up as before, but for the Check Giftcard Balance form
    var checkFormHandle = document.forms.check_gc;
    
    checkFormHandle.onsubmit = processCheckForm;

    function processCheckForm(){
        var gcNumberInput = document.getElementById("gcNumberInput");
        var pinInput = document.getElementById("gcPinInput");

        var gcNumberFormat = /^\d{16}$/;
        var pinFormat = /^\d{4}$/;

        if(!gcNumberFormat.test(gcNumberInput.value)){ 
            gcNumberErr = document.getElementById("gcNumberErr");
            gcNumberErr.innerHTML = "Must be a 16-digit number";
            gcNumberInput.style.background = "red";
            gcNumberInput.focus();
            return false;
        }
        else{
            gcNumberInput.style.background = "white";
            gcNumberErr.innerHTML = "";
        }
        
        if(!pinFormat.test(pinInput.value)){
            gcPinErr = document.getElementById("gcPinErr");
            gcPinErr.innerHTML = "Must be a 4-digit number"; 
            pinInput.style.background = "red";
            pinInput.focus();
            return false;
        }
        else{
            pinInput.style.background = "white";
        }

        var balanceMsg = document.getElementById("balanceMsg");
        var checkGCForm = document.getElementById("checkGCForm");
        var checkGCTitle = document.getElementById("checkGCTitle");

        var gcNumberDisplay = document.getElementById("gcNumberDisplay");
        var gcAmountBalance = document.getElementById("gcAmountBalance");

        checkGCTitle.style.display = "none";
        checkGCForm.style.display = "none";
        balanceMsg.style.display = "inherit";

        gcNumberDisplay.innerText = gcNumberInput.value;
        //Generates a random balance (between 1-99) for any combination of 16 digit GC # and a 4 digit pin
        gcAmountBalance.innerText = "$" + Math.floor(Math.random() * 100);
        
        return false;
    }

    //Second refresh button which uses the same refreshPage function as before
    var refreshBtn2 = document.getElementsByClassName("refreshBtn")[1];
    refreshBtn2.onclick = refreshPage;
}