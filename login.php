<?php

require_once "dbconnect.php";

session_start();

if(isset($_REQUEST['btn_login']))
{
    $email		=strip_tags($_REQUEST["txt_email"]);
    $password	=strip_tags($_REQUEST["txt_password"]);

    if(empty($email)){
        $errorMsg[]="please enter email";
    }
    else if(empty($password)){
        $errorMsg[]="please enter password";
    }
    else
    {
        try
        {
            $select_stmt=$db->prepare("SELECT * FROM customers WHERE email=:uemail");
            $select_stmt->execute(array(':uemail'=>$email));
            $row=$select_stmt->fetch(PDO::FETCH_ASSOC);

            if($select_stmt->rowCount() > 0)
            {
                if($email==$row["email"])
                {
                    if(password_verify($password, $row["password"]))
                    {
                        $_SESSION["user_login"] = $row["user_id"];
                        $loginMsg = "Successfully Login...";
                        header("refresh:2; index.php");
                    }
                    else
                    {
                        $errorMsg[]="wrong password";
                    }
                }
                else
                {
                    $errorMsg[]="wrong  email";
                }
            }
            else
            {
                $errorMsg[]="wrong email";
            }
        }
        catch(PDOException $e)
        {
            $e->getMessage();

        }
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body class="background">

<style>
    .reg_style{
        width:30rem;
        height: auto;
        background-color: #8CC0DE;
        margin-top: 100px;
    }
    .top_border{
        display: flex;
        background-image: url("images/b.jpg");
        background-blend-mode: multiply;
        background-size: cover;
        padding-bottom: 30px;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        height:100px;

    }

    .border_text_style{
        color:#15133C;
        font-family:montserrat, sans-serif;
        text-align:left;
        font-style: bold;
	    width: 900px;
	    margin: auto;

        font-size: 50px;
    } 
    .text_color{
        
        font-weight: bold;
        font-family: "Berlin Sans FB Demi";
        color: #6d6875;
    }

    .text_body{
        text-align:center;
        color: #6d6875;
        font-weight: bold;
    }
    .background{
        background-image: url("images/fıs1.jpg");
        background-repeat:no-repeat;
        background-position:center;
        background-attachment:fixed;
        background-size:cover;
        opacity:0.9;
        overflow-x: hidden;
    }
    .btn{
        background-color:orange;
    }
</style>



<div class="top_border">

<img class="logo" src="images/moonlight.jpg" width="95" height="95">
    <p class="border_text_style">MoonLight Store</p>
</div>
<?php
if(isset($errorMsg))
{
    foreach($errorMsg as $error)
    {
        ?>
        <div class="alert alert-secondary">
            <strong><?php echo $error; ?></strong>
        </div>
        <?php
    }
}
if(isset($loginMsg))
{
    ?>
    <div class="alert alert-success">
        <strong><?php echo $loginMsg; ?></strong>
    </div>
    <?php
}
?>

<div class="row">

    <div class="col"></div>
    <div class="col">

        <div class="card reg_style">

            <div class="card-header card-header-color text_color" align="center">
                <H4 style="font-size: 20px; font-weight:bold;" >LOGIN</H4>
            </div>

            <div class="card-body card-body-color text_body">
                <form  method = "post">
                    <div class="form-group">
                        <label for="email" style="background-color:#F9CEEE;">E-mail</label>
                        <input style="background-color:#F9CEEE;" class="form-control" type="email"  name="txt_email">
                    </div>

                    <div class="form-group">
                        <label for="pass" style="background-color:#F9CEEE;">Password</label>
                        <input style="background-color:#F9CEEE;" class="form-control" type="password"   name="txt_password">
                    </div>
                    <div align="center">
                        <input type="submit" name="btn_login" class="btn btn-success" value="Login">
                    </div>

                </form>
            </div>


            <div style="font-size: 15px; font-weight:bold;" class="card-footer card-footer-color" align="center" >
                You don't have a account <a href="register.php"> register </a> here ?
                <div style="font-size: 15px; font-weight:bold;" style="font-size: 30px; font-weight:bold;">Are you an  <a href="login_admin.php">admin </a> ?</div>
            </div>

        </div>
    </div>

    <div class="col-4"></div>

</div>

</div>

</body>

</html>>



