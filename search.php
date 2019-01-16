<?php 
session_start(); 

if(!isset($_SESSION['customer_email'])){
    
    echo "<script>window.open('customer_login.php?not_validuser=You are not a valid user!','_self')</script>";
}
else {

?>

<?php 
include("include/connect.php"); 

if(isset($_POST["add_to_cart"]))
{
    if(isset($_SESSION["shopping_cart"]))
    {
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        if(!in_array($_GET["id"], $item_array_id))
        {
            $count = count($_SESSION["shopping_cart"]);
            $item_array = array(
                'item_id'           =>  $_GET["id"],
                'item_name'         =>  $_POST["hidden_name"],
                'item_price'        =>  $_POST["hidden_price"],
                'item_quantity'     =>  $_POST["quantity"]
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
            'item_id'           =>  $_GET["id"],
            'item_name'         =>  $_POST["hidden_name"],
            'item_price'        =>  $_POST["hidden_price"],
            'item_quantity'     =>  $_POST["quantity"]
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
                echo '<script>alert("Item Removed")</script>';
                echo '<script>window.location="shoppingcart.php"</script>';
            }
        }
    }
}

?>
<!DOCTYPE html>
<?php include('include/main.php');?>
  <link rel="stylesheet" type="text/css" href="css/shop.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="home.html"><img src="images/s.jpg"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <ul class="nav navbar-nav navbar-right" style="display: block;">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">HOME</a>
                </li>
            <li class="nav-item active">
                <a class="nav-link" href="about.php">ABOUT</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="shop.php">SHOP</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="contact.php">CONTACT</a>
            </li>
             <li class="nav-item active">
                <a class="nav-link" href="register.php">SIGN UP</a>
            </li>
            <li class="nav-item active">
                        <a class="nav-link" href="searchform.php"><i class="fa fa-search" style="font-size:24px"></i></a>
                    </li>
               
                    
                  </ul>
        </div>
        </nav>
    </div>
  </header>
    <body>

        <br />
        <div class="container">
            <div class="row">
            <?php
if (isset($_POST['search'])){
                $search = $_POST['search'];
                $sql = "SELECT product_id, product_name,product_image,product_price FROM tbl_product WHERE product_cat like '%$search%' OR product_keyword like '%$search%'";
    
                $query = mysqli_query($con,$sql);
                $count = mysqli_num_rows($query);
                if(mysqli_num_rows($query) > 0)
                {
                
                    while($row = mysqli_fetch_array($query))
                    {
                ?>

            <div class="col-md-3">
                <form method="post" action="search.php?action=add&id=<?php echo $row["product_id"]; ?>">
                    <div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">
                        <img src="images/<?php echo $row["product_image"]; ?>" class="img-responsive"style="width: 100%; height:225px"/><br />
                    
                        <h4 class="p_title"><?php echo $row["product_name"]; ?></h4>

                        <h4 class="p_price">Rs. <?php echo $row["product_price"]; ?></h4>

                        <h4 class="p_desc"><?php echo $row["product_description"]; ?></h4>

                        <input type="text" name="quantity" value="1" class="form-control" />

                        <input type="hidden" name="hidden_name" value="<?php echo $row["product_name"]; ?>" />

                        <input type="hidden" name="hidden_price" value="<?php echo $row["product_price"]; ?>" />

                        <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />

                    </div>
                </form>
            </div>
        
            <?php
                    }
                }
}
            ?>
            </div>
        </div>
    </div>
    <br/>
    <div class="order_detail">
     <a href="order_details.php"class="btn btn-success order-btn"> VIEW ORDER DETAIL</a>
     <a href="customer_logout.php"class="btn btn-primary ulogout">Logout</a>
    </div>
    </body>
</html>

<?php } ?>
