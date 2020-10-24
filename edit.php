<?php
    session_start();
    $database_name = "Product_details";
    $con = mysqli_connect("localhost","root","",$database_name);

    if(isset($_GET['delete'])){
      header('Location: edit.php');
      $id= $_GET['delete'];
      $sql = "DELETE FROM product WHERE id=$id ";   
    
      if ($con->query($sql) === TRUE) {
        echo "<script type= 'text/javascript'>alert('record is deleted');</script>";
      } else {
        echo "<script type= 'text/javascript'>alert('Error: " . $sql . "<br>" . $con->error."');</script>";
      }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
          <div>
            <h5 class="text-center my-5"> Admin </h5>
          </div>

          <!-- Create User Button -->
          <div class="Button-style text-center mt-5" data-toggle="modal" data-target="#exampleModal"> <a link='#'> Add
              Item </a> </div>

          <!-- Delete User Button -->
          <div class="Button-style text-center mt-5"> <a link='#'> Edit Item </a> </div>

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
          <!-- TODO: Logo here-->
          <h5><i>Cafe Time</i> </h5>
        </div>

      </div>
      <!-- Menubar Ends -->

      <div class="content">

      <div class="container my-5">

        <table class="table results table-dark">
            <thead>
              <tr>
                <th >Item</th>
                <th >price</th>
                <th>Edit</th>
                <th>delete</th>
              </tr>
              <tr class="warning no-result">
                <td colspan="4"><i class="fa fa-warning"></i> No result</td>
              </tr>
            </thead>
            <!-- PHP CODE to FETCH ELEMENT -->
            <tbody>
              <?php
                    $query = "SELECT * FROM product ORDER BY id ASC ";

                    $result = mysqli_query($con,$query);
                    if(mysqli_num_rows($result) > 0) {

                    while ($row = mysqli_fetch_array($result)) {
                ?>

              <form method="post" action="Cart.php?action=add&id=<?php echo $row["id"]; ?>">
                <tr class="product ">
                  <td><?php echo $row["pname"]; ?></td>
                  <td><?php echo $row["price"]; ?></td>
                  <td> <a href="edit.php?edit=<?php echo $row['id'];?>" class=" btn text-info Button-style2">Edit</a> </td>
                  <td> <a href="edit.php?delete=<?php echo $row['id'];?>" class=" btn Button-style2">Delete</a> </td>
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

      </div>
    </div>

  </div>

</body>
</html>