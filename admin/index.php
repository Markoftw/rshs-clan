<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <?php
		ini_set('display_errors',"1");
        session_start();
        if ($_GET['p'] == 'logout'){
            unset($_SESSION['admin']);
        }
        if ($_POST['pass'] == 'password1' || $_POST['pass'] =='password2' ){
            $_SESSION['admin'] = $_POST['pass'];
            header('Location: index.php');
            exit;
        }
        if (!empty($_SESSION['admin'])){
            header('Location: admincp.php');
        }
        ?>
        <form method="post">Password:
            <input type="password" name="pass">
            <input type="submit" value="Login">
        </form>
    </body>
</html>
