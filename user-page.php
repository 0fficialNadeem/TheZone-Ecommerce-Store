<?php
session_start();
require('connectiondb.php');

// Checks if the user is logged in, if not it redirects you to the login/signup page
if (!isset($_SESSION['email'])) {
    header("Location: login-signup-page.php");
    exit();
}

if (!isset($_COOKIE['shopping_cart'])) {
    setcookie('shopping_cart', serialize(array()), time() + (86400), "/"); //Shopping cart cookie expires in a day
    setcookie('shopping_cart_json', json_encode(array()), time() + (86400), "/"); //Shopping cart cookie expires in a day
}

if (isset($_POST['add-to-cart'])) {
    $productId = $_POST['product-id'];

    $shopping_cart = isset($_COOKIE['shopping_cart']) ? unserialize($_COOKIE['shopping_cart']) : array();
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

    if (array_key_exists($productId, $shopping_cart)) {
        $shopping_cart[$productId] += $quantity;
    } else {
        $shopping_cart[$productId] = $quantity;
    };

    setcookie('shopping_cart', serialize($shopping_cart), time() + (86400), "/"); //Shopping cart cookie expires in a day
    setcookie('shopping_cart_json', json_encode($shopping_cart), time() + (86400), "/"); //Shopping cart cookie expires in a day
}

$email = $_SESSION['email'];
$stmt = $db->prepare("SELECT Firstname, Lastname FROM useraccounts WHERE Email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$getName = $stmt->fetch(PDO::FETCH_ASSOC);
$fname = $getName['Firstname'];
$lname = $getName['Lastname'];
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Same head for a consistent format -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TheZone</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>



<body>
    <!--Navbar Start-->
    <?php include('navbar.php') ?>
    <!--Navbar End-->


    <main>
        <div class="container mt-3">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">

                    <h1>Hello, <?php echo $fname . ' ' . $lname ?></h1>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-light text-dark" onclick="redirectToPage('Your Orders')">
                                <div class="card-body" style="height: 150px;">
                                    <h5 class="card-title">Your Orders</h5>
                                    <ul class="list-unstyled">
                                        <li>Track, return, cancel an order</li>
                                        <li>Send invoice to email</li>
                                        <li>Buy again</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light text-dark" onclick="redirectToPage('Account information')">
                                <div class="card-body" style="height: 150px;">
                                    <h5 class="card-title">Account information</h5>
                                    <ul class="list-unstyled">
                                        <li>View your account details</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light text-dark" onclick="redirectToPage('Change Password')">
                                <div class="card-body" style="height: 150px;">
                                    <h5 class="card-title">Change Your Password</h5>
                                    <ul class="list-unstyled">
                                        <li>Change your password</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </main>
    </main>
    <script>
        var pageUrls = {
            "Your Orders": "user-order.php",
            "Account information": "user-login-details.php",
            "Change Password": "user-change-password.php",

        };


        function redirectToPage(title) {

            var url = pageUrls[title];
            if (url) {

                window.location.href = url;
            } else {
                console.error("URL not found for title:", title);
            }
        }
    </script>

    <!-- Footer Start -->
    <?php include('footer.php') ?>
    <!-- Footer End -->

</body>

</html>