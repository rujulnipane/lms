<?php


session_start();

if(!isset($_SESSION["username"])){
    header('Location: '. "../views/Login.php");
}
else{
    echo "Logged In successfully";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course</title>
</head>
<body>
<?php if(isset($_SESSION["username"])) : ?>
        WELCOME: <?php echo $_SESSION["username"]; ?>
    <?php endif; ?>
   

</body>
</html>