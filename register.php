<?php

require_once "dbconnect.php";

if(isset($_REQUEST['btn_register']))
{
    $name	= strip_tags($_REQUEST['txt_name']);
    $lastname	= strip_tags($_REQUEST['txt_lastname']);
    $email		= strip_tags($_REQUEST['txt_email']);
    $password	= strip_tags($_REQUEST['txt_password']);

    if(empty($name)){
        $errorMsg[]="Please enter name";
    }
    if(empty($lastname)){
        $errorMsg[]="Please enter last name";
    }
    else if(empty($email)){
        $errorMsg[]="Please enter email";
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errorMsg[]="Please enter a valid email address";
    }
    else if(empty($password)){
        $errorMsg[]="Please enter password";
    }
    else if(strlen($password) < 6){
        $errorMsg[] = "Password must be at least 6 characters";
    }
    else
    {
        try
        {
            $select_stmt = $db->prepare("SELECT email FROM customers WHERE email=:uemail");
            $select_stmt->execute(array( ':uemail'=>$email));
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            
            if(is_array($row)){
                if($row["email"]==$email){
                    $errorMsg[]="Sorry email already exists";
                }
            }
             else if(!isset($errorMsg))
            {
                $new_password = password_hash($password, PASSWORD_DEFAULT);

                $insert_stmt=$db->prepare("INSERT INTO customers( name, lastname,email,password) VALUES (:uname,:ulastname,:uemail,:upassword)"); 		//sql insert query

                if($insert_stmt->execute(array(
                    ':uname'	=>$name,
                    ':ulastname'=>$lastname,
                    ':uemail'	=>$email,
                    ':upassword'=>$new_password))){

                    $registerMsg="Register Successfully..... Please Click On Login Account Link";
                }
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();

        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</head>


<style>
    .reg_style{
        width:25rem;
        height: auto;
        background-color: #8CC0DE;
        margin-top: 50px;
        margin-bottom:20px;
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

    .background{
        background-image: url("images/fıs1.jpg");
        background-color: #F4BFBF;
        background-repeat: no-repeat;
        background-attachment: fixed;
        position: absolute;
        top:0;
        width: 100%;
        height: 100%;
        background-position: center;
        background-size: cover;
        overflow-x: hidden;

    }
    .text_color{
        font-weight: bold;
        font-family: "Berlin Sans FB Demi";
        color: #6d6875;
    }
    .text_body{
        color: #6d6875;
        font-weight: bold;
    }
    .btn{
        background-color:orange;
    }


</style>

<body class="background">

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

        <div class="alert alert-secondary" role="alert">
            <strong>WRONG ! <?php echo $error; ?></strong>
        </div>
        <?php
    }
}
if(isset($registerMsg))
{
    ?>
    <div class="alert alert-secondary">
        <strong><?php echo $registerMsg; ?></strong>
    </div>
    <?php
}
?>
<div class="row">

    <div class="col"></div>
    <div class="col">

        <div class="card reg_style">

            <div class="card-header card-header-color  text_color" align="center" >
                <H4 style="font-size: 30px; font-weight:bold;">REGISTER PAGE</H4>
            </div>

            <div class="card-body card-body-color text_body" >
                <form  method = "post">
                    <div class="form-group" >
                        <label style="background-color:#F9CEEE;" for="name">Name</label>
                        <input style="background-color:#F9CEEE;" class="form-control" type="text"  name="txt_name">
                    </div>

                    <div class="form-group">
                        <label style="background-color:#F9CEEE;" for="surname">Surname</label>
                        <input style="background-color:#F9CEEE;" class="form-control" type="text"  name="txt_lastname">
                    </div>

                    <div class="form-group">
                        <label style="background-color:#F9CEEE;" for="exampleInputEmail1">Email Address</label>
                        <input style="background-color:#F9CEEE;" type="email" class="form-control"name = 'txt_email' aria-describedby="emailHelp">
                    </div>

                    <div class="form-group">
                        <label style="background-color:#F9CEEE;" for="pass">Password</label>
                        <input style="background-color:#F9CEEE;" class="form-control is invalid" type="password"  name="txt_password">
                    </div >
                    <div align="center">
                        <input type="submit"  name="btn_register" class="btn btn-success " value="Register"   >
                    </div>

                </form>
            </div>

            <div style="font-size: 15px; font-weight:bold;" class="card-footer card-footer-color" align="center">
                You have a account register here? <a href="login.php"><p class="text-info">Login Account</p></a>
            </div>

        </div>
    </div>

    <div class="col-4"></div>

</div>

</body>

</html>
