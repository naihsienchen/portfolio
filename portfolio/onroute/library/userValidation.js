window.onload = function () {
    var formHandler = document.forms.registerForm;
    var inPass = document.getElementById('inPass');
    var inPassConfirm = document.getElementById('inPassConfirm');

    formHandler.onsubmit = processForm;

    function processForm() {
        if (inPass.value.length >= 3 && inPass.value.length <= 15) {
            if (inPass.value === inPassConfirm.value) {

            } else {
                console.log('Passwords do not match');
                return false;
            }
        } else {
            console.log('Too short');
            return false;
        }
    }
}