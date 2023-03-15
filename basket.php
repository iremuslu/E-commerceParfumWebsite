
<?php

require_once 'dbconnect.php';

session_start();

if(isset($_POST["add_to_cart"]))
{
    if(isset($_SESSION["shopping_cart"]))
    {
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        if(!in_array($_GET["id"], $item_array_id))
        {
            $count = count($_SESSION["shopping_cart"]);
            $item_array = array(
                'item_id'			=>	$_GET["id"],
                'item_name'			=>	$_POST["hidden_name"],
                'item_price'		=>	$_POST["hidden_price"],
                'item_quantity'		=>	$_POST["quantity"]
            );
            $_SESSION["shopping_cart"][$count] = $item_array;
        }
        else
        {
            echo '<script>alert("Item Already Added")</script>';
        }
    }
    else
    {
        $item_array = array(
            'item_id'			=>	$_GET["id"],
            'item_name'			=>	$_POST["hidden_name"],
            'item_price'		=>	$_POST["hidden_price"],
            'item_quantity'		=>	$_POST["quantity"]
        );
        $_SESSION["shopping_cart"][0] = $item_array;
    }
}

if(isset($_GET["action"]))
{
    if($_GET["action"] == "delete")
    {
        foreach($_SESSION["shopping_cart"] as $keys => $values)
        {
            if($values["item_id"] == $_GET["id"])
            {
                unset($_SESSION["shopping_cart"][$keys]);
                echo '<script>window.location="basket.php"</script>';
            }
        }
    }
}




if(array_key_exists('clear', $_POST)) {
    $_SESSION["shopping_cart"] = array();
    echo '<script>window.location="index.php"</script>';

}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Art For Art</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>



</head>

<style>

    .table_style{
        width:54rem;

    }

    .background-image{
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

        font-size: 15px;
        font-weight: bold;
        color: #f4f1de;
        vertical-align: center;
        height: 30px;

    }

    .payment_card_style{

        width: 57rem;
        height: auto;
        background-color: #8CC0DE;

    }
    .payment_header_text{

        font-family: "Berlin Sans FB Demi";
        font-size: 30px;
        color: #6d6875;
        text-align: center;
        font-weight: bolder;
    }
    .payment_menu{
        margin-top: 10px;
        margin-bottom: 10px;
        height: auto;
    }

    .payment_buttons{
        text-align: center;
        background-color: #9BA3EB;
        width: 150px;
        height: auto;
        color:#f4f1de;
    }

    .approve_style{
        background-color:#9BA3EB;
        color:#f4f1de;
        margin-bottom: 35px;
    }

    .text_color{
        font-weight: bold;
        font-family: "Berlin Sans FB Demi";
    }



</style>

<body class="background-image ">
<div class="card-title top_border">
    <nav class="navbar top_border  justify-content-between">
        <button class="btn btn-sm basket_text_style" name = "btn_profile"   onclick="location.href='profile.php'">PROFILE</button>
        <button class="btn btn-sm basket_text_style" name = "btn_profile" onclick="location.href='index.php'">HOME</button>
    </nav>

</div>


<div class="container " style="margin-top: 60px"></div>

<div class="card payment_card_style " style="display: block" id="basket_card">

    <div class="card-header">
        <h2 class="payment_header_text "> BASKET</h2>
    </div>

    <div class="card-body  ">

        <div class="table-responsive table_style">
            <table class="table table-bordered"  align = "center" >
                <tr>
                    <th width="40%">Item Name</th>
                    <th width="10%">Quantity</th>
                    <th width="20%">Price</th>
                    <th width="15%">Total</th>
                    <th width="5%">Action</th>
                </tr>
                <?php
                if(!empty($_SESSION["shopping_cart"]))
                {
                    $total = 0;
                    foreach($_SESSION["shopping_cart"] as $keys => $values)
                    {
                        ?>
                        <tr>
                            <td><?php echo $values["item_name"]; ?></td>
                            <td><?php echo $values["item_quantity"]; ?></td>
                            <td>$ <?php echo $values["item_price"]; ?></td>
                            <td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td>
                            <td><a href="basket.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
                        </tr>
                        <?php
                        $total = $total + ($values["item_quantity"] * $values["item_price"]);
                    }
                    ?>
                    <tr>
                        <td colspan="3" align="right">Total</td>
                        <td align="right">$ <?php echo number_format($total, 2); ?></td>
                        <td></td>
                    </tr>
                    <?php
                }
                ?>

            </table>
        </div>

        <form id="payment" style="display: none" method="post">
            <p class="card-title text_color" style="text-align: center">PAYMENT</p>
            <label class="text_color" for="payment_option">Payment Option:</label>
            <select class="card form-control payment_menu" id="payment_option">
                <option>Wire Transfer</option>
                <option>Credit Card</option>
            </select>

            <div class="form-group">
                <label  class="text_color" for="inputAddress">Address:</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="Please Enter Your Address">
            </div>
            <form method="post">
                <div align="center">
                <button class="btn btn-sm approve_style " type="submit"  name="clear" onclick="approvef()">Approve</button>
                </div>
            </form>

        </form>

            <div align="center">
                <a  href="#" class="btn  btn-sm payment_buttons " id="buy" onclick = "buy1()">Checkout</a><br><br>
                <a href="#" class="btn btn-sm  payment_buttons " onclick="go_shopping()">Go Shopping</a>
            </div>



    </div>

</div>
<script>
    function approvef(){


        var x = document.getElementById("inputAddress").value;
        if (x == null || x == "") {
          alert("Address must be filled out");

        }else{
            alert("Your order has been received");
            location.href='index.php';

            var a = document.getElementById("payment");
            if (a.style.display === "block") {
                a.style.display= "none";

            }

        }
    }

    function go_shopping(){
        var z = document.getElementById("payment");
        if (z.style.display === "block") {
            z.style.display= "none";
        }
        location.href='index.php';
    }

    function buy1(){
        document.getElementById("buy").disabled =true;
        var a = document.getElementById("payment");
        if (a.style.display === "none") {
            a.style.display= "block";
        }

    }


</script>

</body>
</html>
