<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Profile</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<style>
.card {
        margin: 0 auto;
        float: none;
        margin-bottom: 50px;
    }
    .top_border{
        margin-top: 0px;
        background-color: #8CC0DE;
        width: available;

    }

    .basket_text_style {
        text-align: right;
        font-size: 15px;
        font-weight: bold;
        color: #2E0249;
        vertical-align: center;
        height: 30px;
    }

    .reg_style{
        width:40rem;
        height: auto;
        background-color: #F4BFBF;
        margin-top: 25px;
    }
    .background{
        background-image: url("images/parfum.jpg");
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
        color: #2E0249;
    }
    .text_body{
        text-align:center;
        color: #2E0249;
        font-weight: bold;
    }
    </style>


<body class="background">

<?php

require_once 'dbconnect.php';

session_start();

$id = $_SESSION['user_login'];

$select_stmt = $db->prepare("SELECT * FROM customers WHERE user_id=:uid");
$select_stmt->execute(array(":uid"=>$id));

$row=$select_stmt->fetch(PDO::FETCH_ASSOC);

$name1 = $row["name"];
$lastname1= $row["lastname"];
$email1 = $row["email"];
$id1 = $row["user_id"];

if(isset($_REQUEST['btn_edit']))

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
                $new_password = password_hash($password, PASSWORD_DEFAULT);

                $update_stmt=$db->prepare("UPDATE customers set name = :uname,lastname =:ulastname,email = :uemail,password =:upassword where user_id = $id1") ;		//sql insert query

                 $name1 = $row["name"];
                 $lastname1= $row["lastname"];
                 $email1 = $row["email"];

                if($update_stmt->execute(array(
                    ':uname'	=>$name,
                    ':ulastname'=>$lastname,
                    ':uemail'	=>$email,
                    ':upassword'=>$new_password))){
                    $updateMsg="Update Successfully...";

                }
            }

        catch(PDOException $e)
        {
            echo $e->getMessage();

        }
    }

}
?>
<div class="card-title top_border">
    <nav class="navbar top_border  justify-content-between">
        <button class="btn btn-sm basket_text_style" name = "btn_profile" onclick="location.href='profile.php'">PROFILE</button>
        <button class="btn btn-sm basket_text_style" name = "btn_profile" onclick="location.href='index.php'">HOME</button>
    </nav>

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
    echo "<script>Swal.fire({
    position: 'center',
    icon: 'success',
    title: 'Your changes has been saved',
    showConfirmButton: false,
    timer: 1500
    }) </script>";
}
?>

<div class="row">
    <div class="col">
    <div class="col">

        <div class="card reg_style">

            <div class="card-header card-header-color text_color" align="center">
                <H4 style="font-size: 30px; font-weight:bold;">YOUR PROFILE</H4
            </div>

            <div class="card-body card-body-color text_body" >
                <form  method = "post">
                    <div class="form-group" >
                        <label style="background-color:#9BA3EB;" for="name">Name</label>
                        <input style="background-color:#9BA3EB;" class="form-control" type="text"  name="txt_name" value= <?php echo $name1 ?>>
                    </div>

                    <div class="form-group">
                        <label style="background-color:#9BA3EB;" for="surname">Surname</label>
                        <input style="background-color:#9BA3EB;" class="form-control" type="text"  name="txt_lastname" value="<?php echo $lastname1 ?>">
                    </div>

                    <div class="form-group">
                        <label style="background-color:#9BA3EB;" for="exampleInputEmail1">Email Address</label>
                        <input style="background-color:#9BA3EB;" type="email" class="form-control"name = 'txt_email' aria-describedby="emailHelp" value="<?php echo $email1 ?>">
                    </div>

                    <div class="form-group">
                        <label style="background-color:#9BA3EB;" for="pass">Password</label>
                        <input style="background-color:#9BA3EB;" class="form-control is invalid" type="password"  name="txt_password">
                    </div >
                    <div align="center">
                        <input type="submit" style="background-color:orange;"  name="btn_edit" class="btn btn-success " value="Edit Your Profile" >
                    </div>

                </form>
            </div>

            <div class="card-footer card-footer-color" align="center">
                <a href="logout.php">Logout</a>
            </div>

        </div>
    </div>

    <div class="col"></div>


</div>


</body>
</html>

