<?php
    use ONROUTE\models\{Database, User};
    require_once 'vendor/autoload.php';
    require_once 'library/functions.php';
    require_once './Models/Mailer.php';

    //Add unqiue css files here
    $css = array('styles/login.css');
    
    require_once './views/header.php';

    //Redirects to home page if user is not logged in
    if (!$_SESSION['userID']) {
        header('Location: index.php');
    }
    
    $dbcon = Database::getDB();
    $user = new User($dbcon);

    if (isset($_POST['changeEmail'])) {
        //Grabs new email from form
        $email = $_POST['in_email'];

        //Checks if new email is different from current email
        if ($_SESSION['userEmail'] != $email) {
            $emailExists = $user->checkIfEmailIsUnique($email);
            if ($emailExists) {
                echo 'Email already exists';
            } else {
                //Calls method to change email and routes back to accounts page
                $user->UpdateUserEmail($_SESSION['userID'], $email);
                $_SESSION['userEmail'] = $email;
                header('Location: myAccount.php');
            }
        } else {
            echo 'That is your current email.';
        }
    }
?>

<main>
    <div class="formContainer">
        <form action="test.php" method="post">
            <div class="formContainer__form">
                <div class="formContainer__form_input">
                    <label for="in_email">New Email: </label>
                    <input type="text" name="in_email" required/>
                </div>
                <input class="loginBtn" type="submit" value="Change Email" name="changeEmail"/>
            </div>
        </form>
    </div>
    <div class="formContainer">
        <form action="test.php" method="post">
            <div class="formContainer__form">
                <div class="formContainer__form_input">
                    <label for="in_pass">Current Password: </label>
                    <input type="password" name="in_pass" required/>
                </div>
                <div class="formContainer__form_input">
                    <label for="in_passNew">New Password: </label>
                    <input type="password" name="in_passNew" required/>
                </div>
                <div class="formContainer__form_input">
                    <label for="in_passNewConfirm">Confirm Password: </label>
                    <input type="password" name="in_passNewConfirm" required/>
                </div>
                <input class="loginBtn" type="submit" value="Change Password" name="changePassword"/>
            </div>
        </form>
    </div>
</main>


<?php
    require_once "./views/footer.php";
?>