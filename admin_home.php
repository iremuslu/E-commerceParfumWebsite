<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MoonLight Store</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


</head>

<style>

    .card_style{
        background-color:#FFE3A9;
        opacity:0.8;
        color : #FF8C8C;
        margin-top:50px;
        width: 70rem;
    }

    .background-image{
        background-image: url("images/fıs1.jpg");
        background-color: #FF8C8C;
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
        background-color: #FFE3A9;
        width: available;
        height:40px;

    }

    .basket_text_style:hover {
        text-align: right;
        font-size: 20px;
        font-weight: bold;
        color: #2E0249;
        vertical-align: center;
        height: 40px;
        border:1px solid blue;
        border-radius:12px;
        transition: color 1s , background-color 1s;
        background-color:#97C4B8;

    }
    


</style>

<body class = "background-image" >
    
<nav class="navbar top_border  justify-content-between">
    <button class="btn btn-sm basket_text_style" name = "btn_profile" onclick="location.href='admin_home.php'">Home</button>
    <button class="btn btn-sm basket_text_style" name = "btn_profile" onclick="location.href='add_user.php'">Add User</button>

    <button class="btn btn-sm basket_text_style" name = "btn_profile" onclick="location.href='add_product.php'">Add Product</button>
    <button class="btn btn-sm basket_text_style" name = "btn_profile" onclick="location.href='login.php'">Logout</button>
    <form class="form-inline" method="post">
        <input style="background-color:#F9CEEE;" class="form-control mr-sm-2" type="search" name = "s_name" placeholder="Enter Product Id" aria-label="Search">
        <button style="background-color:#97C4B8" class="btn btn-success my-2 my-sm-0" type="submit" name = "search">Search</button>
    </form>
</nav>




<div class="container" style="margin-top: 50px"></div>

<div class="row">
    <div class="col"></div>
    <div class="col">


<div class="view_product_box card card_style" align="center">

    <div class="card-header card-header-color">
        <h2 style="font-size: 30px; font-weight:bold;">All Products</h2>
    </div>



    <div class=" card-body card-body-color border_bottom"></div>

    <form action="" method="post" enctype="multipart/form-data" />

    <table  width="70%" align="center" >
        <thead>
        <tr>
            <th width="%10">ID</th>
            <th width="%20">Name</th>
            <th width="%10">Price</th>
            <th width="%20">Image</th>
            <th width="%20"></th>
            <th width="%20"></th>
        </tr>
        </thead>

        <?php

        require_once 'dbconnect.php';

        session_start();
        $all_products = mysqli_query($connect,"select * from products order by id ASC ");

        if(isset($_REQUEST['search']))
        {
            $id = strip_tags($_REQUEST["s_name"]);
            if(empty($id)){
                echo '<script>alert("Please enter product id!")</script>';
            }
            else
            {
                try {
                    $select_stmt = $db->prepare("SELECT * FROM products WHERE id =:uid");
                    $select_stmt->execute(array(':uid' => $id));
                    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

                    if ($select_stmt->rowCount() > 0) {
                        if ($id == $row["id"]) {
                            $all_products =  mysqli_query($connect,"select * from products where id = $id");
                        }
                    }else{
                        echo '<script>alert("Product no found !")</script>';
                    }
                }catch(PDOException $e)
                {
                    $e->getMessage();
                }
            }
        }
        while($row=mysqli_fetch_array($all_products)){
            ?>

            <tbody>
            <tr>
                <td style="font-size: 30px; font-weight:bold;"><?php echo $row['id']; ?></td>
                <td style="font-size: 12px; font-weight:bold;"><?php echo $row['name']; ?></td>
                <td>$ <?php echo $row['price']; ?></td>
                <td><img src="images/<?php echo $row['image']; ?>" width="60" height="70" style="padding-bottom: 5px"/></td>
                <td><a href="admin_home.php?action=view_pro&delete_product=<?php echo $row['id'];?>" style="color:red">Delete</a></td>
                <td><a href="edit_product.php?action=edit_pro&id=<?php echo $row['id'];?> " style="color:#14C38E">Edit</a></td>
            </tr>
            </tbody>

            <?php } ?>
    </table>

    </form>

</div>
</div>
    <div class="col">
</div>

<?php

if(isset($_GET['delete_product'])){
    $delete_product = mysqli_query($connect,"delete from products where id='$_GET[delete_product]' ");

    if($delete_product){
        echo "<script>alert('Product has been deleted successfully!')</script>";

        echo "<script>window.open('admin_home.php?action=view_pro','_self')</script>";

    }
}

if(isset($_POST['deleteAll'])){
    $remove = $_POST['deleteAll'];

    foreach($remove as $key){
        $run_remove = mysqli_query($connect,"delete from products where id='$key'");

        if($run_remove){
            echo "<script>alert('Items selected have been removed successfully!')</script>";

            echo "<script>window.open('index.php?action=view_pro','_self')</script>";
        }else{
            echo "<script>alert('Mysqli Failed: mysqli_error($connect)!')</script>";
        }
    }
}
?>
</body>