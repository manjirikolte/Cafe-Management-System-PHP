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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Custom css -->
    <link rel="stylesheet" href="style.css">
    <style>
    .results tr[visible="false"],
    .no-result {
      display: none;
    }

    .results tr[visible="true"] {
      display: table-row;
    }

    .counter {
      padding: 8px;
      color: #ccc;
    }
    </style>
</head>

<body>


<header>

<nav class="navbar navbar-expand-lg navbar-light bg-light" style="  box-shadow: 10px 2px 10px grey;">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav float-right">
      <li class="nav-item active mx-5">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
   
    </ul>
  </div>
</nav>

</header>

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
                                <td><input type="submit"  name="add" style="margin-top: 5px;" class="button-style"
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



<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="index.js"> </script>
<script>
  $(document).ready(function() {
    $(".search").keyup(function () {
      var searchTerm = $(".search").val();
      var listItem = $('.results tbody').children('tr');
      var searchSplit = searchTerm.replace(/ /g, "'):containsi('")
      
    $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
          return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
      }
    });
      
    $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function(e){
      $(this).attr('visible','false');
    });
  
    $(".results tbody tr:containsi('" + searchSplit + "')").each(function(e){
      $(this).attr('visible','true');
    });
  
    var jobCount = $('.results tbody tr[visible="true"]').length;
      $('.counter').text(jobCount + ' item');
  
    if(jobCount == '0') {$('.no-result').show();}
      else {$('.no-result').hide();}
            });
  });
</script>

</body>
</html>
