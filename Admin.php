<?php
    session_start();

    include 'db_con.php';

    if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {


    if (isset($_POST["add"])){
        if (isset($_SESSION["bill"])){
            $item_array_id = array_column($_SESSION["bill"],"product_id");
            
           if (!in_array($_GET["id"],$item_array_id)){
                $count = count($_SESSION["bill"]);
                 $item_array = array(
                    'product_id' => $_GET["id"],
                    'item_name' => $_POST["hidden_name"],
                    'product_price' => $_POST["hidden_price"],
                    'item_quantity' => $_POST["quantity"],
                );
                $_SESSION["bill"][$count] = $item_array;
            }
        }else{
            $item_array = array(
                'product_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'product_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"],
            );
            $_SESSION["bill"][0] = $item_array;
        }
    }

    if (isset($_GET["action"])){
        if ($_GET["action"] == "delete"){
            foreach ($_SESSION["bill"] as $keys => $value){
                if ($value["product_id"] == $_GET["id"]){
                    unset($_SESSION["bill"][$keys]);
                }
            }
        }
    }

    if (isset($_GET["action"])){
        if ($_GET["action"] == "empty"){
          unset($_SESSION["bill"]);             
        }
    }

    if(isset($_POST["Add_ITEMS"])){
      header('Location: Admin.php');
    
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

    if(isset($_POST["submit"])){

                             
      if ($con->connect_error) {
      die("Connection failed: " . $con->connect_error);
      } 
      
      $sql = "INSERT INTO sales ( name, amount) VALUES ('".$_POST["name"]."','".$_POST['amount']."')";
      header('Location: Admin.php');
      
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
  <link rel="stylesheet" href="./css/style.css">
  <style>
    a,
a:hover {
  color: white;
  text-decoration: none;
}
    </style>

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
          <div>
            <h5 class="text-center my-5"> Admin </h5>
          </div>

          <!-- Create Item Button -->
          <div class="Button-style text-center mt-5" data-toggle="modal" data-target="#exampleModal"> <a href='#'> Add
              Item </a> </div>

          <!-- Delete Item Button -->
          <div class="Button-style text-center mt-5"> <a href='Delete-item.php'> Delete
              Item </a> </div>

           <!-- Total sales Button -->
           <div class="Button-style text-center mt-5"> <a href='Total-sale.php'> Total
              Sales </a> </div>

          <div class="Button-style text-center mt-5"> <a href="logout.php">Logout</a> </div>

        </ul>

      </div>
    </div>

    <div class="main_container">

      <!-- Menubar Starts -->
      <div class="navbar">

        <div class="hamburger">
          <i class="fas fa-bars"></i>
        </div>
        <div class="logo">
          <h5><i>Cafe Time</i> </h5>
        </div>

      </div>
      <!-- Menubar Ends -->

      <div class="content">

        <!-- Modal Start -->
        <div class="modal fade dark" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">

            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title " id="exampleModalLabel">Add Items</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <!-- ADD ITEMS PHP CODE -->
              <form action="" method="POST">

                <div class="modal-body">
                  <div class="data">
                    <div class="input-fields mb-4">
                      <input class="inp-style" type="text" name="pname" autocomplete="off" placeholder="Item Name">
                    </div>
                    <div class="input-fields mb-4">
                      <input class="inp-style" type="text" name="price" autocomplete="off" placeholder="Price">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" name="Add_ITEMS"  class="btn btn-success">submit</button>
                </div>

              </form>
              <!-- ADD ITEMS PHP CODE -->

            </div>

          </div>
        </div>
        <!-- Modal Ends -->

        <div class="container my-4 py-4">
          <div class="row my-4">

            <div class="col-6">
              <!-- Search Bar -->
              <div class="searchbar mb-4">

                <input class="search_input search" type="text" name="" placeholder="What are you looking for?">
                <a href="#" class="search_icon"><i class="fas fa-search"></i></a>

              </div>


              <!-- Counts no. of items in list -->
              <span class="counter pull-right"></span>

              <table class="table results table-dark">
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
                <!-- PHP CODE to FETCH ELEMENT -->
                <tbody>
                  <?php
                        $query = "SELECT * FROM product ORDER BY pname ASC ";
                        $result = mysqli_query($con,$query);
                        if(mysqli_num_rows($result) > 0) {

                        while ($row = mysqli_fetch_array($result)) {
                    ?>

                  <form method="post" action="Admin.php?action=add&id=<?php echo $row["id"]; ?>">
                    <tr class="product">
                      <td><?php echo $row["pname"]; ?></td>
                      <td><?php echo $row["price"]; ?></td>
                      <td width="15%"><input type="number" name="quantity" class="form-control input-style" value="1">
                      </td>
                      <td><input type="hidden" name="hidden_name" value="<?php echo $row["pname"]; ?>">
                      <td>
                      <td><input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>"></td>
                      <td><button type="submit" name="add" class="Button-style2 text-info" value="Add">Add</button> </td>
                    </tr>
                  </form>

                  <?php
                       }
                      }
                    ?>
                </tbody>
                <!-- PHP CODE to FETCH ELEMENT -->
              </table>

            </div>
            <!-- First Column Ends -->

            <!-- Second Column starts -->
            <div class="col-4 table-style">

              <div class=" ">
                <table class="table-dark">
                  <thead>
                    <tr>
                      <td class="pb-3" width="15%">Items</td>
                      <td class="pb-3" width="10%">Qty</td>
                      <td class="pb-3" width="10%">Rate</td>
                      <td class="pb-3" width="10%">Amount</td>
                      <td class="pb-3" width="10%">Remove</td>
                    </tr>
                  </thead>
                  <!-- PHP CODE TO CALCULATE BILL -->
                  <tbody>
                    <?php
                        if(!empty($_SESSION["bill"])){
                          $total = 0;
                          foreach ($_SESSION["bill"] as $key => $value) {
                    ?>
                    <tr>
                      <td><?php echo $value["item_name"]; ?></td>
                      <td><?php echo $value["item_quantity"]; ?></td>
                      <td> <?php echo $value["product_price"]; ?></td>
                      <td>
                        <?php echo number_format($value["item_quantity"] * $value["product_price"], 2); ?></td>
                      <td class="px-3"><a href="Admin.php?action=delete&id=<?php echo $value["product_id"]; ?>"><span
                            class="text-danger ">✕</span></a></td>

                    </tr>
                    <?php
                        $total = $total + ($value["item_quantity"] * $value["product_price"]);
                      }
                    ?>
                    <tr>
                      <td colspan="3" align="right" class="p-3">TOTAL AMOUNT TO PAY</td>
                      <th colspan="2" align="right" style="font-size:1.2em"> ₹ <?php echo number_format($total, 2); ?>
                      </th>
                    </tr>
                    <tr>
                    <!-- Save Customer Name and total bill into db -->
                      <form action="Admin.php?action=empty" method="POST">

                        <td colspan="4">
                          <div class="input-fields" style="width:230px; height: 40px; padding:5px">
                            <input class="inp-style" type="text" name="name" autocomplete="off"
                              placeholder="Enter Customer Name">
                            <input type="hidden" name="amount" value="<?php echo (isset($total))?$total:'';?>">
                          </div>
                        </td>
                        <td> <button type="submit" name="submit" class="Button-style2 text-warning"> sold </button>
                        </td>

                      </form>
                      <!-- Save Customer Name and total bill into db -->
                    </tr>

                    <?php
                      }
                    ?>
                  </tbody>
                  <!-- PHP CODE TO CALCULATE BILL -->
                </table>

              </div>
              <!-- Second Column Ends -->

            </div>
          </div>

        </div>

      </div>
    </div>

  </div>


  <!-- Bootstrap Jquery-->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
  <!-- Jquery CDN -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <!-- Custom JS file -->
  <script src="./js/index.js"> </script>

</body>

</html>

<?php 
}else{
     header("Location: login-page.php");
     exit();
}
 ?>