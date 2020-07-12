<?php
session_start();
session_destroy();
session_start();

include("config.php");

if(isset($_POST['pwd'])) {
    if(strip_tags($_POST['pwd']) == $pwd) {
        $_SESSION['backend'] = true;
        header("Location: backend.php");
        exit;
    } else {
        echo "<script>alert('Sorry, the password you entered isn\'t correct.\\n\\nPlease try again.');</script>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>SB DJ</title>
    <link rel="stylesheet" href="css/fonts.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/flexboxgrid.min.css" type="text/css">
    <link rel="stylesheet" href="icofont/icofont.min.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div id="login-wrap">
    <div id="login-form">
        <form action="login.php" method="POST">
            <input type="password" placeholder="Password" name="pwd"><br />
            <input type="submit" value="login">
        </form>
    </div>
</div>

<?php include("footer.php"); ?>

</body>
</html>