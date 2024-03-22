<?php

session_start();

// Checks if the user is logged in, if not it redirects you to the login/signup page
if (!isset($_SESSION['email'])) {
    header("Location: login-signup-page.php");
    exit();
}

// Preforms another check to see if the logged in account is an admin, if not, it doesn't allow the user to access the page
if ($_SESSION['isAdmin'] !== 1) {
    echo '<h1 style="color:red;">Forbidden Access</h1>
    <p>You don\'t have permission to access this page</p>';
    exit();
}
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Same head for a consistent format -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TheZone</title>
    <link rel="stylesheet" href="../TheZone/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        h2 {
            margin: 5px;
        }

        .container {
            display: flex;
            flex-direction: column;
            height: 100%;
            margin: 10px;
            margin-left: auto;
            margin-right: auto;
        }

        .row {
            display: flex;
            flex: 1;
        }

        .section {
            flex: 1;
            border: 5px solid black;
            padding: 20px;
            border-radius: 5px;
            margin: 10px;
            overflow-y: auto;
            height: calc(50% - 22px);
        }
    </style>
</head>

<body>

    <!-- navbar -->
    <?php include('../TheZone/adminnavbar.php');
    include('../TheZone/connectiondb.php');
    ?>
    <!-- navbar end -->

    <main>
     
        <div class="container">

            <div class="row">

                <div class="section">
                    <h3>Recent Orders</h3>
                    <p>Showing Latest Orders</p>
                    <table id="RecentOrders" class="table tb">
                        <thead>
                            <tr>
                                <th>OrderID</th>
                                <th>Total Amount</th>
                                <th>Order Date</th>
                                <th>Order Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $maxID =  $db->query("SELECT MAX(OrderID) FROM orders");
                            $maxID = $maxID->fetch(PDO::FETCH_ASSOC);
                            $maxID = $maxID['MAX(OrderID)'];
                            $numRows = $db->query("SELECT COUNT(*) FROM orders");
                            $numRows = $numRows->fetch(PDO::FETCH_ASSOC);
                            $numRows = $numRows['COUNT(*)'];

                            #only show the last 2 orders FIX THIS
                            for ($i = $maxID; $i > $maxID - 2; $i--) {

                                $order = $db->query("SELECT * FROM Orders WHERE OrderID = $i");
                                $order = $order->fetch();
                                echo "<tr>";
                                echo "<td>" . $order['OrderID'] . "</td>";
                                echo "<td>£" . $order['TotalAmount'] . "</td>";
                                echo "<td>" . $order['OrderTime'] . "</td>";
                                echo "<td>" . $order['OrderStatus'] . "</td>";
                                echo "</tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                </div>

                <div class="section">
                    <h2>Current Orders</h2>
                    <p>To show the current orders that require processing</p>
                    <table id="CurrentOrders" class="table">
                        <thead>
                            <tr>
                                <th>OrderID</th>
                                <th>Total Amount</th>
                                <th>Order Date</th>
                                <th>Order Status</th>
                                <th>Operations</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            $nonProcessedOrders = $db->query("SELECT * FROM orders WHERE OrderStatus = 'Processing'");
                            $nonProcessedOrders = $nonProcessedOrders->fetchAll();

                            foreach ($nonProcessedOrders as $order) {
                                echo "<tr>";
                                echo "<td>" . $order['OrderID'] . "</td>";
                                echo "<td> £" . $order['TotalAmount'] . "</td>";
                                echo "<td>" . $order['OrderTime'] . "</td>";
                                echo "<td>" . $order['OrderStatus'] . "</td>";
                                echo "<td>";
                                echo "<form action='../TheZone/update-order-admin.php' method='post'>";
                                echo "<input type='hidden' name='orderID' value='" . $order['OrderID'] . "'>";
                                echo "<select class='form-select' name='orderStatus'>";
                                echo "<option value='Processing'>Processing</option>";
                                echo "<option value='Shipped'>Shipped</option>";
                                echo "<option value='Delivered'>Delivered</option>";
                                echo "</select>";
                                echo "<input type='hidden' name='submitted' id='submitted'>";
                                echo "<button type='submit' class='btn btn-primary'>Update</button>";
                                echo "</form>";

                                echo "</td>";
                                echo "</tr>";
                            }



                            ?>

                        </tbody>
                    </table>
                </div>

            </div>

            <div class="section">
                <h2>Stock Levels</h2>
                <p>showing products with low stock levels</p>

                <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('../TheZone/connectiondb.php');

               

                $inventory = $db->prepare("SELECT * FROM inventory INNER JOIN stock_table ON inventory.ProductID = stock_table.ProductID  INNER JOIN sizes_table ON stock_table.SizeID = sizes_table.SizeID WHERE stock_table.Quantity < 20");
                $inventory->execute();
                $inventory = $inventory->fetchAll(PDO::FETCH_ASSOC);

                
                
                foreach ($inventory as $product) {
                    echo "<tr>";
                    echo "<td >" . "<img style='width: 50px; height=50px' src=" . $product['ImageURL'] . " alt='product-img'>" .  "</td>";
                    echo "<td style='width: 150px;'>" . $product['ProductName'] . "</td>";
                    echo "<td>" . $product['ProductDescription'] . "</td>";
                    echo "<td>£" . $product['Price'] . "</td>";
                    if ($product['Quantity'] < 20) {
                        echo "<td><p class=low-stock style='color:red; font-weight: Bold;'>" .$product['SizeName'].": ". $product['Quantity'] . "</p> </td>";
                    } 
                    echo "<td style='display:none;'>" . $product['ProductID'] . "</td>";
                   
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
            </div>

        </div>

    </main>


</body>

<Script>
    $document.ready(function() {
        $('#RecentOrders').DataTable({
            "paging": true,
            "info": false,
            "searching": true,
            "ordering": true,
            "autoWidth": true,
            "responsive": true,

        });
    });
    
</Script>


</html>