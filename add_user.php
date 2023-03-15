<?php

require_once "dbconnect.php";

if(isset($_REQUEST['btn_add']))
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
            $select_stmt = $db->prepare("SELECT email FROM admins WHERE email=:uemail");
            $select_stmt->execute(array( ':uemail'=>$email));
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if($row["email"]==$email){
                $errorMsg[]="Sorry email already exists";
            }
            else if(!isset($errorMsg)) //check no "$errorMsg" show then continue
            {
                $new_password = password_hash($password, PASSWORD_DEFAULT);

                $insert_stmt=$db->prepare("INSERT INTO admins( name, lastname,email,password) VALUES (:uname,:ulastname,:uemail,:upassword)");

                if($insert_stmt->execute(array(
                    ':uname'	=>$name,
                    ':ulastname'=>$lastname,
                    ':uemail'	=>$email,
                    ':upassword'=>$new_password))){

                    $registerMsg="Admin add succesful";
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
    <title>MoonLight Store </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</head>


<style>
    .top_border{
        margin-top: 0px;
        background-color: #FFE3A9;
        width: available;
        height:60px;

    }

    .basket_text_style:hover {
        text-align: right;
        font-size: 15px;
        font-weight: bold;
        color: #2E0249;
        vertical-align: center;
        height: 50px;
        border:1px solid blue;
        border-radius:12px;
        transition: color 1s , background-color 1s;
        background-color:#97C4B8;
    }
    .reg_style{
        margin-top: 50px;
        background-color: #FFE3A9;
        width: 35rem;
        height: auto;
    }

    .background{
        background-image: url("images/fıs1.jpg");
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

</style>

<body class="background">
<nav class="navbar top_border  justify-content-between">
    <button class="btn btn-sm basket_text_style" name = "btn_profile" onclick="location.href='admin_home.php'">Home</button>
    <button class="btn btn-sm basket_text_style" name = "btn_profile" onclick="location.href='add_user.php'">Add User</button>
    <button class="btn btn-sm basket_text_style" name = "btn_profile" onclick="location.href='add_product.php'">Add Product</button>
</nav>
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
                <H4 style="font-size: 30px; font-weight:bold;">Add User</H4>
            </div>

            <div class="card-body card-body-color text_body" >
                <form  method = "post">
                    <div class="form-group" >
                        <label for="name" style="background-color:#F9CEEE">Name</label>
                        <input class="form-control" type="text"  name="txt_name" style="background-color:#F9CEEE">
                    </div>

                    <div class="form-group">
                        <label for="surname" style="background-color:#F9CEEE">Surname</label>
                        <input class="form-control" type="text"  name="txt_lastname" style="background-color:#F9CEEE">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1" style="background-color:#F9CEEE">Email Address</label>
                        <input type="email" class="form-control"name = 'txt_email' aria-describedby="emailHelp" style="background-color:#F9CEEE">
                    </div>

                    <div class="form-group">
                        <label for="pass" style="background-color:#F9CEEE">Password</label>
                        <input class="form-control is invalid" type="password"  name="txt_password" style="background-color:#F9CEEE">
                    </div >
                    <div align="center">
                        <input type="submit"  name="btn_add" class="btn btn-success " style="background-color:#97C4B8"value="Save"   >
                    </div>

                </form>
            </div>

        </div>
    </div>

    <div class="col-4"></div>

</div>

</body>

</html>
