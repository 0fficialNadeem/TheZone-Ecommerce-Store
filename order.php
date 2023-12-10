<?php
    session_start();
    
    require("connectiondb.php");
    
    //if (isset($_POST['checkout'])) {
        $shopping_cart = $_COOKIE['shopping_cart'];

        if (!isset($shopping_cart)) {
            echo "Shopping cart is empty";
            exit;
        }

        $shopping_cart = unserialize($shopping_cart);

        $total_price = 0;

        $stmt = $db->query("SELECT UserID FROM useraccounts WHERE Email = '" . $_SESSION['email'] . "'");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_id = $row['UserID'];


        foreach($shopping_cart as $product_id) {
            $stmt = $db->query("SELECT Price FROM inventory WHERE ProductID = $product_id");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $total_price += $row['Price'];
        }

        $date_time = date("Y-m-d H:i:s");

        $stmt = $db->prepare("INSERT INTO orders (UserID, OrderTime, OrderStatus, TotalAmount) VALUES (:userid, :ordertime, :orderstatus, :totalamount)");
        $stmt->bindValue(':userid', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':ordertime', $date_time);
        $stmt->bindValue(':orderstatus', "Pending");
        $stmt->bindValue(':totalamount', $total_price, PDO::PARAM_INT);
        $stmt->execute();

        $order_id = $db->lastInsertId();

        foreach ($shopping_cart as $product_id) {
            $stmt = $db->query("SELECT ProductName, Price FROM inventory WHERE ProductID = $product_id");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);


            $stmt = $db->prepare("INSERT INTO orderitems (OrderID, ProductID, Quantity) VALUES (:orderid ,:productid, :quantity)");
            $stmt->bindValue(':orderid', $order_id, PDO::PARAM_INT);
            $stmt->bindValue(':productid', $product_id, PDO::PARAM_INT);
            $stmt->bindValue(':quantity', 1, PDO::PARAM_INT);
            $stmt->execute();
        };

        $_COOKIE['shopping_cart'] = serialize(array());
        $_COOKIE['shopping_cart_json'] = json_encode(array());
    //}
?>

<html>
    
</html>