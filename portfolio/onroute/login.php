<?php
    use OnRoute\models\{Database, User};
    require_once 'vendor/autoload.php';
    require_once 'library/functions.php';
    require_once 'models/Mailer.php';

    //Add unqiue css files here
    $css = array('styles/login.css');
    require_once './views/header.php';
    require_once 'models/Database.php';
    require_once 'models/User.php';


    $dbcon = Database::getDB();
    $user = new User($dbcon);

    $invalid = "";

    //Checks to see if a user is logged in
    if (isset($_SESSION['userID'])) {
        Header('Location: index.php');
    }

    //Registration
    if (isset($_POST['submit'])) {
        //Gets a list of registered user emails
        $email = $_POST['email'];

        //Checks to see if posted email is unique
        $emailExists = $user->checkIfEmailIsUnique($email);

        if ($emailExists) {
            //Change this to something useful
            echo 'Email already exists';
        } else {
            $hashedPass = md5($_POST['pass']);
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $pnumber = $_POST['pnumber'];
            $subject = "Registration successful";
            $body = "You are now registered bla bla bla yeah have fun";
            $u = $user->addUser($email, $hashedPass, $fname, $lname, $pnumber);
            send_email($email, $fname.' '.$lname, $subject, $body);
            $newID = $user->getUserIdByEmail($email);
            $_SESSION['userID'] = $newID->id;
            $_SESSION['userEmail'] = $email;
            $_SESSION['userFirstName'] = $fname;
            $_SESSION['userLastName'] = $lname;
            header('Location: index.php');
        }
    }
    
    //Login
    if (isset($_POST['login'])) {
        //Add validation here
        $email = $_POST['in_email'];
        $hashedPass = md5($_POST['in_pass']);

        $u = $user->getUser($email, $hashedPass);

        if (!$u == null) {
            $_SESSION['userID'] = $u->id;
            $_SESSION['userEmail'] = $u->email;
            $_SESSION['userFirstName'] = $u->firstname;
            $_SESSION['userLastName'] = $u->lastname;
            $_SESSION['userPhone'] = $u->phonenumber;
            header('Location: Flights.php');
        } else {
            //Change this to something useful
            $invalid = "<p>Invalid username and/or password</p>";
        }
    }
?>
<script type="text/javascript" src="library/userValidation.js"></script>
<main>
    <div class="formContainer">
        <form action="login.php" method="post" id="loginForm">
            <h2>Login</h2>
            <div class="formContainer__form">
                <div class="formContainer__form_input">
                    <label for="in_email">Email: </label>
                    <input type="text" name="in_email" required/>
                </div>
                <div class="formContainer__form_input">
                    <label for="in_pass">Password: </label>
                    <input type="password" name="in_pass" required/>
                    <?= $invalid ?>
                </div>
                <div class="formContainer__form_input">
                <a href="forgotPassword.php" class="forgotPassBtn">Forgot your password?</a>
                </div>
                <input class="loginBtn" type="submit" value="Login" name="login">
            </div>
        </form>
    </div>
    <div class="formContainer">
        <form action="login.php" method="post" id="registerForm">
            <h2>Don't Have An Account?<br>Register Here</h2>
            <div class="formContainer__form">
                <div class="formContainer__form_input">
                    <label for="email">Email:</label> 
                    <input type="text" name="email" id="inEmail" required/>
                </div>
                <div class="formContainer__form_input">
                    <label for="pass">Password:</label>
                    <input type="password" name="pass" id="inPass" required/>
                </div>
                <div class="formContainer__form_input">
                <label for="passConfirm">Confirm Password:</label><input type="password" name="passConfirm" id="inPassConfirm" required/>
                </div>
                <div class="formContainer__form_input">
                    <label for="fname">First Name:</label>  
                    <input type="text" name="fname" id="inFName" required/>
                </div>
                <div class="formContainer__form_input">
                    <label for="lname">Last Name:</label> 
                    <input type="text" name="lname" id="inLName" required/>
                </div>
                <div class="formContainer__form_input">
                    <label for="pnumber">Phone Number: </label> 
                    <input type="text" name="pnumber" id="inPNumber" required/>
                </div>
                <input class="loginBtn" type="submit" name="submit" value="Register">
            </div>
        </form>
    </div>
</main>

<?php
    require_once 'views/footer.php';
?>