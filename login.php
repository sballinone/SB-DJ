<?php
session_start();
session_destroy();
session_start();

include("config.php");
include("multilanguage.php");

if(isset($_POST['pwd'])) {
    if(strip_tags($_POST['pwd']) == $pwd) {
        $_SESSION['backend'] = true;
        header("Location: backend.php");
        exit;
    } else {
        echo "<script>alert('".$output['passwordIncorrect']."');</script>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>SB DJ</title>
    <link rel="stylesheet" href="css/fonts.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="external/flexboxgrid.min.css" type="text/css">
    <link rel="stylesheet" href="external/icofont/icofont.min.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div id="login-wrap">
   <div id="login-form">
        <form action="login.php" method="POST">
            <input type="password" placeholder="<?=$output['password'];?>" name="pwd">&nbsp;&nbsp;&nbsp;
            <input type="submit" value="<?=$output['login'];?>">
        </form>
    </div>
</div>

<div id="login-footer">
    <?php include("footer.php"); ?>
</div>

</body>
</html>