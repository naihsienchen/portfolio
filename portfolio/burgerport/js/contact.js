window.onload=function(){
    //alert("hello");
    //Validate form name, email
    //set variables
    var formHandle = document.forms.inquiryForm;
    
    //when form is submitted, trigger function
    formHandle.onsubmit = function(){
        //If field is null or empty string, turn field red and focus cursor
       //regex email format
        var emailFormat = /^([\w\.\-\_]+)@(\w+)\.(\w{2,3})/;
        if(formHandle.name.value===""||formHandle.name.value===null){
            formHandle.name.style.background="red";
            formHandle.name.focus();
            return false;
        }
        //else, return to white and continue validation
        else{
            formHandle.name.style.background="white";
        }
        //If field is null or empty string, turn field red and focus cursor
        if(formHandle.email.value===""||formHandle.email.value===null||!emailFormat.test(formHandle.email.value)){
            formHandle.email.style.background="red";
            formHandle.email.focus();
            return false;
        }
         //else, return to white and continue validation
        else{
            formHandle.email.style.background="white";
        }
        //If field is null or empty string, turn field red and focus cursor
        if(formHandle.inquiryText.value===""||formHandle.inquiryText.value===null||formHandle.inquiryText.value==="Type your inquiry here"){
            formHandle.inquiryText.style.background="red";
            formHandle.inquiryText.focus();
            return false;
        }
         //else, return to white and submit form. 
        else{
            formHandle.inquiryText.style.background="white";
            
            //set variables for thank you message 
            var thxMsg = document.getElementById("thxMsg");
            var inquirySubmitted = document.getElementById("inquirySubmitted");
            var otherInquiries = document.getElementById("otherInquiries");
            var otherInqTitle = document.getElementById("otherInqTitle");
            
            //write inner html for thank you message
            thxMsg.innerHTML="Thanks for your inquiry, "+formHandle.name.value+"! We will get back to you as soon as possible."
            
            //Remove the form from view and display the thank you message
            formHandle.style.display="none";
            otherInqTitle.style.display="none";
            inquirySubmitted.style.display="block";
            
            
            return false;
        }
    }
}