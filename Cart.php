<?php
    session_start();
    $database_name = "Product_details";
    $con = mysqli_connect("localhost","root","",$database_name);

    if (isset($_POST["add"])){
        if (isset($_SESSION["cart"])){
            $item_array_id = array_column($_SESSION["cart"],"product_id");
            
           if (!in_array($_GET["id"],$item_array_id)){
                $count = count($_SESSION["cart"]);
                 $item_array = array(
                    'product_id' => $_GET["id"],
                    'item_name' => $_POST["hidden_name"],
                    'product_price' => $_POST["hidden_price"],
                    'item_quantity' => $_POST["quantity"],
                );
                $_SESSION["cart"][$count] = $item_array;
                // echo '<script>window.location="Cart.php"</script>';
            }
        }else{
            $item_array = array(
                'product_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'product_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"],
            );
            $_SESSION["cart"][0] = $item_array;
        }
    }

    if (isset($_GET["action"])){
        if ($_GET["action"] == "delete"){
            foreach ($_SESSION["cart"] as $keys => $value){
                if ($value["product_id"] == $_GET["id"]){
                    unset($_SESSION["cart"][$keys]);
                    // echo '<script>window.location="Cart.php"</script>';
                }
            }
        }
    }
    if (isset($_GET["action"])){
        if ($_GET["action"] == "empty"){
          unset($_SESSION["cart"]);             
        }
    }


    if(isset($_POST["Add_ITEMS"])){
    
    if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
    } 
    
    $sql = "INSERT INTO product ( pname, price) VALUES ('".$_POST["pname"]."','".$_POST["price"]."')";   
    
    if ($con->query($sql) === TRUE) {
    echo "<script type= 'text/javascript'>alert('New record created successfully');</script>";
    } else {
    echo "<script type= 'text/javascript'>alert('Error: " . $sql . "<br>" . $con->error."');</script>";
    }
    
    }

?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Cart</title>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <!-- Custom css -->
   <link rel="stylesheet" href="style.css">
  
</head>

<body>

  
<div class="wrapper">
  <div class="sidebar">
    <div class="bg_shadow"></div>
    <div class="sidebar_inner">
      <div class="close m-2">
        <i class="fas fa-times"></i>
      </div>

      <ul class="siderbar_menu mx-2">
          <div ><h5 class="text-white text-center my-5"> Admin  </h5></div>

          <!-- Create User Button -->
        <div class="Button-user text-center mt-5" data-toggle="modal" data-target="#exampleModal"> <a link='#' > Add Item </a> </div>

          <!-- Delete User Button -->
        <div class="Button-user text-center mt-5"> <a link='#' > See Feedback </a> </div>        
        
      </ul>

    </div>
  </div>
  <div class="main_container">
    <div class="navbar">
      <div class="hamburger">
        <i class="fas fa-bars"></i>
      </div>
      <div class="logo">
           <!-- Logo -->
      </div>
    </div>
    <div class="content">
     <h5> Voice Recognization Attendance System</h5>


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
     
              <form action="" method="POST">
               <div class="data">
              	   <input type="text" name="pname" placeholder="Enter item" /><br/>
                   <input type="text" name="price" placeholder="Price" /><br/>
                   <input type="submit" name="Add_ITEMS" value="submit" /><br/>
               </div>
              </form>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>


<div class="container my-4 py-4">

<div class="row my-4">
  <div class="col-6">
  

  <div class="form-group pull-right">
<input type="text" class="search form-control" placeholder="What you looking for?">
</div>
<span class="counter pull-right"></span>
    <table class="table results"  >
        <thead>
            <tr>
              <th scope="col">Item</th>
              <th scope="col">price</th>
              <th scope="col">quantity</th>
              <th scope="col"></th>
            </tr>
            <tr class="warning no-result">
  <td colspan="4"><i class="fa fa-warning"></i> No result</td>
</tr>
        </thead>
        <tbody >
        <?php
        // To fetch data from DB
            $query = "SELECT * FROM product ORDER BY id ASC ";
            $result = mysqli_query($con,$query);
            if(mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_array($result)) {
                ?>

                    <form method="post" action="Cart.php?action=add&id=<?php echo $row["id"]; ?>">
                        <tr class="product" >
                            <td><?php echo $row["pname"]; ?></td>
                            <td><?php echo $row["price"]; ?></td>
                            <td width="15%"><input type="number"  name="quantity" class="form-control" value="1"></td>
                            <td><input type="hidden" name="hidden_name" value="<?php echo $row["pname"]; ?>"><td>
                            <td><input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>"></td>
                            <td><input type="submit"  name="add" style="margin-top: 5px;"
                                   value="Add"></td
                        </tr>
                    </form>     

                <?php
            }
         }
       ?>
       </tbody>
    </table>
    </div>

    <div class="col-6 bill-calc">
    <div class="table-responsive">
        <table>
        <thead>
        <tr>
            <th width="10%">Product Name</th>
            <th width="10%">Quantity</th>
            <th width="10%">Rate</th>
            <th width="10%">Amount</th>
            <th width="10%">Remove Item</th>
        </tr>
        </thead>
        <tbody>
        <?php
            if(!empty($_SESSION["cart"])){
                $total = 0;
                foreach ($_SESSION["cart"] as $key => $value) {
                    ?>
                    <tr>
                        <td><?php echo $value["item_name"]; ?></td>
                        <td><?php echo $value["item_quantity"]; ?></td>
                        <td> <?php echo $value["product_price"]; ?></td>
                        <td>
                            <?php echo number_format($value["item_quantity"] * $value["product_price"], 2); ?></td>
                        <td><a href="Cart.php?action=delete&id=<?php echo $value["product_id"]; ?>"><span
                                    class="text-danger">Remove</span></a></td>

                    </tr>
                    <?php
                    $total = $total + ($value["item_quantity"] * $value["product_price"]);
                }
                    ?>
                    <tr>
                        <td colspan="3" align="right">TOTAL AMOUNT TO PAY</td>
                        <th align="right"> ₹ <?php echo number_format($total, 2); ?></th>
                        <td> <a href="Cart.php?action=empty"><span
                                    class="text-danger">Empty</span></a> </td>
                    </tr>
                    <?php
                }
            ?>
             </tbody>
        </table>
    </div>

    </div>

</div>
</div>



    </div>
  </div>
 
</div>


<!-- Bootstrap Jquery-->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- Font Awesome Icons -->
<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
<!-- Jquery CDN -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!-- Custom JS file -->
<script src="index.js"> </script>

</body>
</html>
