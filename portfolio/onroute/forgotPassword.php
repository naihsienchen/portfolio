<?php
    use ONROUTE\models\{Database, User};
    require_once 'vendor/autoload.php';
    require_once 'library/functions.php';
    require_once './Models/Mailer.php';

    //Add unqiue css files here
    $css = array('styles/login.css');
    require_once './views/header.php';

    //Redirects to home page if a user is logged in
    if (isset($_SESSION['userID'])) {
        header('Location: index.php');
    }
    
    $dbcon = Database::getDB();
    $user = new User($dbcon);

    if (isset($_POST['resetPassword'])) {
        //Grabs email from posted form
        $email = $_POST['in_email'];

        //Checks if the email exists
        $emailExists = $user->checkIfEmailIsUnique($email);
        if ($emailExists) {
            //Gets the id associated with the email
            $u = $user->getUserByEmail($email);

            //Calls functions to generate a random function
            $newPass = generateRandomPassword();

            //Hashes the new password
            $newPassHashed = md5($newPass);
            $user->ChangePassword($u->id, $newPassHashed);
            
            //Email variables
            $subject = "Password recovery";
            $body = "Your new password is: $newPass";
            $fname = $u->firstname;
            $lname = $u->lastname;

            //Sends email with new password
            send_email($email, $fname." ".$lname, $subject, $body);
            echo "A recovery email will be sent to you at: $email";
        } else {
            echo "A recovery email will be sent to you at: $email";
        }

    }

    //Generates a random password
    //Reference: https://www.w3docs.com/snippets/php/how-to-generate-a-random-string-with-php.html
    function generateRandomPassword(){
        $n = 10;
        $result = bin2hex(random_bytes($n));
        return $result;
    }
?>

<main>
    <div class="formContainer">
        <form action="forgotPassword.php" method="post" id="loginForm">
            <h2>Login</h2>
            <div class="formContainer__form">
                <div class="formContainer__form_input">
                    <label for="in_email">Email: </label>
                    <input type="text" name="in_email" required/>
                </div>
                <input class="loginBtn" type="submit" value="Reset Password" name="resetPassword">
            </div>
        </form>
    </div>
</main>


<?php
    require_once "./views/footer.php";
?>