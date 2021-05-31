<?php
session_start();
if(isset($_POST['login'])){
    //get values from form and assign to local variable
    $user = $_POST['uname'];
    $pass = $_POST['password'];

    //connect to xml file to retrive username and password
    $xml = simplexml_load_file("xml/users.xml");

    //create s session it credential is valid
    foreach ($xml->user as $xmluser) {
        if ($user == $xmluser->username && $pass == $xmluser->pswd && $xmluser->attributes() == 'staff'){
            $_SESSION['username'] = $user;
            $_SESSION['role'] = 'staff';
            $_SESSION['userid'] = $xmluser->userid->__tostring();
            header('Location: list-tickets.php');
            //exit();
        } elseif ($user == $xmluser->username && $pass == $xmluser->pswd && $xmluser->attributes() == 'client') {
            $_SESSION['username'] = $user;
            $_SESSION['role'] = 'client';
            $_SESSION['userid'] = $xmluser->userid->__tostring();
            header('Location: list-tickets.php');
            //exit();
        } else {
            echo "Invalid credentials";
        }
    }
}
include 'views/header.php';

?>
    <div class="container">    
        <div id="title">
            <h1 class="text-center text-white bg-info">Help Desk</h1>
            <h2 class="text-center">Login</h2>
        </div>
        <div class="d-flex p-2 justify-content-center">
            <form method="post" action="index.php">
                <div class="form-group">    
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="uname" />
                </div>
                <div class="form-group">    
                    <label for="username">Password:</label>
                    <input type="password" class="form-control" name="password" />
                <input type="submit" name="login" value="Login" />
                </div>
            </form>
        </div>
    </div>
<?php
    include 'views/footer.php';
?>