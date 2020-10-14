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
</head>
<body>

<div class="container my-4 py-4">

    <div class="row my-4">
      <div class="col-6">

        <table class="table table-dark">
            <thead>
                <tr>
                  <th scope="col">Item</th>
                  <th scope="col">price</th>
                  <th scope="col">quantity</th>
                  <th scope="col"></th>
                </tr>
            </thead>
            <tbody >
            <?php
                $query = "SELECT * FROM product ORDER BY id ASC ";
                $result = mysqli_query($con,$query);
                if(mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_array($result)) {
                    ?>

                        <form method="post" action="Cart.php?action=add&id=<?php echo $row["id"]; ?>">
                            <tr class="product" >
                                <td><?php echo $row["pname"]; ?></td>
                                <td><?php echo $row["price"]; ?></td>
                                <td width="15%"><input type="number" name="quantity" class="form-control" value="1"></td>
                                <td><input type="hidden" name="hidden_name" value="<?php echo $row["pname"]; ?>"><td>
                                <td><input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>"></td>
                                <td><input type="submit" name="add" style="margin-top: 5px;" class="btn button-style"
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

        <div class="col-6">
        <div class="table-responsive">
            <table class="table table-bordered">
            <tr>
                <th width="20%">Product Name</th>
                <th width="10%">Quantity</th>
                <th width="10%">Price Details</th>
                <th width="10%">Total Price</th>
                <th width="10%">Remove Item</th>
            </tr>

            <?php
                if(!empty($_SESSION["cart"])){
                    $total = 0;
                    foreach ($_SESSION["cart"] as $key => $value) {
                        ?>
                        <tr>
                            <td><?php echo $value["item_name"]; ?></td>
                            <td><?php echo $value["item_quantity"]; ?></td>
                            <td>$ <?php echo $value["product_price"]; ?></td>
                            <td>
                                $ <?php echo number_format($value["item_quantity"] * $value["product_price"], 2); ?></td>
                            <td><a href="Cart.php?action=delete&id=<?php echo $value["product_id"]; ?>"><span
                                        class="text-danger">Remove</span></a></td>

                        </tr>
                        <?php
                        $total = $total + ($value["item_quantity"] * $value["product_price"]);
                    }
                        ?>
                        <tr>
                            <td colspan="3" align="right">Total</td>
                            <th align="right">$ <?php echo number_format($total, 2); ?></th>
                            <td></td>
                        </tr>
                        <?php
                    }
                ?>
            </table>
        </div>

        </div>

    </div>
</div>




<!-- List js -->
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
<!-- Custom js -->
<script>

var options = {
  valueNames: [ 'name', 'city' ]
};

var hackerList = new List('hacker-list', options);
</script>
</body>
</html>
