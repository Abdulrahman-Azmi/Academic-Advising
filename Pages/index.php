<!DOCTYPE html>
<?php 
    session_start();

    // Connect to the database
    require_once 'includes/db_connect.php';

    // Load functions
    require_once 'includes/functions.php';

    if (logged_in()) {
        if (isset($_SESSION['advid'])) {
            header("location: advisor_home.php");
        }
        elseif(isset($_SESSION['studentid'])){
            header("location: form.php");
        }else{
            header("location: Admin_Home.php");
        }
    }

    // Login using the connection set up in db_connect.php
    login($connection);


    // set error messages to null if no errors
    $usernameErr = "";
    $passwordErr = "";
    $username = "";
    
    if (isset($_SESSION['usernameErr'])) {
        $usernameErr = $_SESSION['usernameErr'];
        unset($_SESSION['usernameErr']);
    }
    if (isset($_SESSION['passwordErr'])) {
        $passwordErr = $_SESSION['passwordErr'];
        $username = $_SESSION['username'];
        unset($_SESSION['passwordErr']);
        unset($_SESSION['username']);
    }
?>

<html>
    <head>
   
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Academic Advising | Login</title>
        <link rel="shortcut icon" href="img/Academic_Advising_favicon.ico" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
       
        
    </head>
    <body >
        <div class="container">
            <div class="row">
               
                <h1 class="title text-center">Academic Advsing <img src="img/logo.png" alt="Logo"  width="80px" height="60px"></h1>
                
            </div>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4 form">
<!--htmlspecialchars replaces characters with special meaning in HTML with &-escaped entities.
 So, for example, ' becomes &#039;. It doesn't turn %22 into &quot;, however, because %22 has no special meaning in HTML, 
 so it's safe to display it without modification.!-->                    
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <fieldset class="form-group">
                            <label for="user">E-mail</label>  
                            <input type="text" id="user" class="form-control" name="user" placeholder="Enter E-mail" value="<?php if (!empty($username)) { echo $username; } ?>" required>
                            <?php echo $usernameErr; ?>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="pass">Password</label>  
                            <input type="password" id="pass" class="form-control" name="password" placeholder="Enter Password" required>
                            <?php echo $passwordErr; ?>
                        </fieldset>
                        
                            <?php echo $passwordErr; ?>
                        </fieldset>
                        <button type="submit" class="btn-lg btn-primary">Login</button>
                    </form>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <div class="row text-center">
                <p class="signup">If you do not have an account yet, <a class="link" href="onboard.php">click here</a></p>
            </div>
            <div class="row">  
                <div class="text-center">
                    <?php include_once "footer.php"; ?>
                </div>
            </div>
        </div>
    </body>   
</html>
