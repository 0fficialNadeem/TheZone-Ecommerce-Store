<?php
session_start();

if (!isset($_COOKIE['shopping_cart'])) {
    setcookie('shopping_cart', serialize(array()), time() + (86400), "/"); //Shopping cart cookie expires in a day
    setcookie('shopping_cart_json', json_encode(array()), time() + (86400), "/"); //Shopping cart cookie expires in a day
}

if (isset($_POST['remove-from-cart'])) {
    $productId = $_POST['product-id'];

    $shoppingCart = isset($_COOKIE['shopping_cart']) ? unserialize($_COOKIE['shopping_cart']) : array();

    if (isset($_POST['item-key'])) {
        $itemKey = $_POST['item-key'];
        unset($shoppingCart[$itemKey]);
    };

    setcookie('shopping_cart', serialize($shoppingCart), time() + (86400), "/"); //Shopping cart cookie expires in a day

    setcookie('shopping_cart_json', json_encode($shoppingCart), time() + (86400), "/"); //Shopping cart cookie expires in a day
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shopping cart</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <style>
        .total-section {
            border: 2.5px solid black;
            border-radius: 5px;
            margin-top: auto;
            margin-bottom: auto;
            background-color: rgb(230, 230, 230);
        }

        .checkout-right-section {
            width: 30%;
            margin-bottom: auto;
            margin-top: auto;
            width: 30%;
            /* margin-right: 30px;    */
        }

        .discount-section {
            border: 2.5px solid black;
            border-radius: 5px;
            margin-top: auto;
            margin-bottom: 2vw;
            background-color: rgb(230, 230, 230);
        }

        .discount-section h4 {
            text-align: center;
            margin-top: 5px;
        }

        .total-section h4 {
            text-align: center;
            margin-top: 5px;
        }

        .whole-cart {
            display: flex;
            justify-content: space-evenly;
            width: 100%;
        }

        .cart-items {
            border: 2.5px solid black;
            border-radius: 5px;
            width: 70%;
            margin-top: 20px;
            margin-bottom: 30px;
            margin-right: auto;
            background-color: rgb(230, 230, 230);
        }

        .cart-items h3 {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .sample-product {
            background-color: white;
            border: 2.5px solid #000;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
            text-align: left;
            width: 90%;
            margin-right: auto;
            /* overflow: hidden; */
            position: relative;
            display: flex;
        }

        .product-info {
            display: flex;
            align-items: center;
        }

        .product-info img {
            margin-right: 10px;
        }

        .sample-product h3 {
            margin: 15px;
            font-size: 20px;
            width: 100%;
            white-space: normal;
            overflow-wrap: break-word;
            word-wrap: break-word;
        }

        .sample-product img {
            width: 120px;
            height: 120px;
            border: 2.5px solid #000;
            border-radius: 5px;
            margin: 15px;
        }

        .sample-product quantity-button {
            background-color: #ff0000;
            border-radius: 3px;
            color: #fff;
            border: none;
            margin: 20px;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease;
            bottom: 0;
            right: 0;
            display: inline-block;
            width: 25%;
            text-align: center;
        }

        .sample-product quantity-button:hover {
            background-color: #fff;
            /* changing background color on hover */
            color: #ff0000;
            /* border: 2.5px solid #ff0000; */
            font-weight: bold;
        }

        .sample-product button {
            background-color: #ff0000;
            border-radius: 3px;
            color: #fff;
            border: none;
            margin: 10px;
            padding: 5px 10px;
            cursor: pointer;
            bottom: 0;
            right: 0;
            position: absolute;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .sample-product button:hover {
            background-color: #fff;
            color: #ff0000;
            font-weight: bold;
        }

        .hr-for-shopping-cart {
            height: 4px;
            /* Set the height to make it thicker */
            width: 55%;
            /* Set the width to make it shorter (adjust as needed) */
            margin: 20px auto;
            /* Center the line by setting margin and using auto for left and right */
            background-color: #000;
            /* Set the background color of the line */
            border: none;
            /* Remove the default border */
        }

        .update-form {
            width: 90%;
            height: 5%;
            display: flex;
            justify-content: space-evenly;
        }
    </style>


</head>

<body>
    <!--Navbar Start-->
    <?php include('navbar.php') ?>
    <!--Navbar End-->

    <main>
        <!-- div section for the entire cart and the total amount display -->
        <div style="display: flex; justify-content: space-evenly; margin-bottom: 100px;">
            <!-- div section for the entire cart and the total amount display -->
            <div class="whole-cart">

                <!-- div section for cart items to be shown -->
                <div class="cart-items">
                    <div style="background-color: #333; color: white; text-align: center;padding: 15px;">
                        <h3>Your Cart</h3>
                    </div>
                    <ul id="cart-items">
                        <?php
                        require("connectiondb.php");
                        $shopping_cart = isset($_COOKIE['shopping_cart']) ? $_COOKIE['shopping_cart'] : array();
                        if (!empty($shopping_cart) && is_array($shopping_cart)) {
                            echo '<div class="sample-product">';
                            echo '<h3>Cart is empty</h3>';
                            echo '</div>';
                        } else {
                            $cart_items = unserialize($shopping_cart);
                            foreach ($cart_items as $item => $itemArray) {
                                list($productId, $size) = explode('|', $item);
                                $quantity = $itemArray['quantity'];

                                $stmt = $db->query("SELECT ProductName, Price, ImageUrl, ProductID FROM inventory WHERE ProductID = $productId");
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                echo '<div class="sample-product" item-key="' . $item . '">';
                                echo '<div class="product-info">';
                                echo '<img src="' . $row['ImageUrl'] . '" alt="Sample Product Image">';
                                echo '<div>';
                                echo '<h3>' . $row['ProductName'] . '</h3>';
                                echo "<h3> Size: {$size}</h3>";
                                echo "<h3> Price: £{$row['Price']} </h3>";
                                echo '<div id="quantityContainer style="position: absolute; top:0; right: 0;"">';
                                echo '<h3> Quantity: </h3>';
                                echo '<div style="margin: 10px; padding: 10px; border: 1px solid #ccc;">';
                                // -- update product quantity form starts here --
                                echo '<div class="update-form">';
                                echo '<form method="post" class="update-form">';
                                echo '<input type="hidden" name="product-id" value="' . $row['ProductID'] . '">';
                                echo "<quantity-button type='button' onclick='updateQuantity(\"{$row['ProductID']}\", \"{$size}\", 1);'> + </quantity-button>";
                                echo '<span class="item-count" item-key="' . $item . '">' . $quantity . '</span>';
                                echo "<quantity-button type='button' onclick='updateQuantity(\"{$row['ProductID']}\", \"{$size}\", -1);'> - </quantity-button>";
                                echo '</form>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                // -- update product quantity form ends here --
/*                                 echo '<div>';
                                echo '<form method="post" class="remove-form">';
                                echo '<input type="hidden" name="item-key" value="' . $item . '">';
                                echo '<button id="remove-button" type="submit" name="remove-from-cart" class="btn btn-dark remove-from-cart">Remove</button>';
                                echo '</form>';
                                echo '</div>'; */

                                echo '</div>';
                                // -- remove product form ends here --

                                echo '</div>';
                            }
                        }

                        ?>
                        <script>
                            function getCookieValue(cookieName) {
                                const name = cookieName + "=";
                                const decodedCookie = decodeURIComponent(document.cookie);
                                const cookieArray = decodedCookie.split(';');
                                for (let i = 0; i < cookieArray.length; i++) {
                                    let cookie = cookieArray[i];
                                    while (cookie.charAt(0) === ' ') {
                                        cookie = cookie.substring(1);
                                    }
                                    if (cookie.indexOf(name) === 0) {
                                        return cookie.substring(name.length, cookie.length);
                                    }
                                }
                                return "";
                            }

                            // Wait for DOM to load
                            document.addEventListener('DOMContentLoaded', function() {
                                const shoppingCartJson = JSON.parse(getCookieValue('shopping_cart_json'));

                                function updatePrice() {
                                    fetch('get-cart-total.php').then(res => res.json()).then(data => {
                                        document.getElementById('cart-total').innerHTML = data;
                                    });
                                }

                                updatePrice();

                                document.querySelectorAll('.remove-form').forEach(function(form) {
                                    form.addEventListener('submit', function(event) {
                                        event.preventDefault();

                                        const productId = form.querySelector('[name="product-id"]').value;

                                        fetch('shopping-cart.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/x-www-form-urlencoded'
                                            },
                                            body: 'item-key=' + encodeURIComponent()
                                        }).then((res) => {
                                            console.log(res);
                                            event.target.closest('.sample-product').remove();

                                            updatePrice();
                                        }).catch((err) => {
                                            console.log(err);
                                        })
                                    })
                                })

                                //
                            })

                            function updateQuantity(productId, size, change) {
                                console.log(productId);
                                console.log(size);
                                console.log(change);
                                fetch('update-product-quantity.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: 'product_id=' + encodeURIComponent(productId) + '&size=' + encodeURIComponent(size) + '&quantity_change=' + encodeURIComponent(change)
                                }).then(res => res.json()).then(data => {

                                    fetch('get-cart-total.php').then(res => res.json()).then(data => {
                                        document.getElementById('cart-total').innerHTML = data;
                                    });

                                    if (data == 0) {
                                        //Find a sample-product that has a matching product id and size and remove it
                                        const sampleProduct = document.querySelector(`.sample-product[item-key="${productId}|${size}"]`);
                                        sampleProduct.remove();
                                        console.log(getCookieValue('shopping_cart_json'));
                                        return;
                                    }

                                    const itemCount = document.querySelector(`.item-count[item-key="${productId}|${size}"]`);
                                    itemCount.innerHTML = data;
                                })
                            }
                        </script>
                    </ul>
                </div>


                <div class="checkout-right-section">
                    <div class="discount-section">
                        <h4>DISCOUNT</h4>
                        <hr class="hr-for-shopping-cart">
                        <form style="margin-bottom: 15px; margin-left: 15px; margin-right: 15px">
                            <div class="form-group">
                                <input type="text" class="form-control" id="discount-code-box" placeholder="Enter discount code">
                            </div>
                        </form>
                        <div style="text-align: center; margin-bottom: 15px; margin-top: 15px;">
                            <a class="shoppingcart-button" id="apply-discount-button" name="checkout-button">Apply Code</a>
                        </div>
                    </div>
                    <div class="total-section">
                        <h4>TOTAL</h4>
                        <hr class="hr-for-shopping-cart">
                        '<p class="text-center">Total Price: £<span id="cart-total">''</span></p>';
                        <!-- <p class="text-center">Total Price: £<span id="cart-total">0.00</span></p> -->
                        <div style="text-align: center; margin-bottom: 15px;">
                            <?php
                            if (!isset($_SESSION['email'])) {
                                echo '<a class="shoppingcart-button" id="checkout-button" name="checkout-button"  href="login-signup-page.php">Signup to checkout</a>';
                            } else if (unserialize($shopping_cart) == null) {
                                echo '<a class="shoppingcart-button" id= "checkout-button" name="checkout-button" href="index.php">Shop Now</a>';
                            } else {
                                echo '<a href="checkout.php" class="shoppingcart-button" id= "checkout-button" name="checkout-button" href="checkout.php">Check Out</a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- div section to show the total and the option to checkout via button -->

                <!-- div section for a product with its name, price and product image -->

    </main>

    <!-- Footer Start -->
    <?php include('footer.php') ?>
    <!-- Footer End -->
    <!-- needed for drop down menu -->


    <script>
        function getCookieValue(cookieName) {
            const name = cookieName + "=";
            const decodedCookie = decodeURIComponent(document.cookie);
            const cookieArray = decodedCookie.split(';');
            for (let i = 0; i < cookieArray.length; i++) {
                let cookie = cookieArray[i];
                while (cookie.charAt(0) === ' ') {
                    cookie = cookie.substring(1);
                }
                if (cookie.indexOf(name) === 0) {
                    return cookie.substring(name.length, cookie.length);
                }
            }
            return "";
        };

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('apply-discount-button').addEventListener('click', () => {
                let discountCodeBox = document.getElementById('discount-code-box');

                console.log(getCookieValue('discount_code'));

                if (getCookieValue('discount_code') != "") {
                    console.log('Discount already applied');
                    discountCodeBox.innerHTML = "Discount Already Applied";
                    return;
                };

                let discountCode = discountCodeBox.value;

                fetch('apply-discount.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'discount_code=' + encodeURIComponent(discountCode)
                }).then(res => res.json()).then(data => {
                    console.log(data);
                    if (data.success) {
                        const total = parseFloat(document.getElementById('cart-total').innerHTML);
                        const discount = total * (data.discount_percentage / 100);
                        document.getElementById('cart-total').innerHTML = (total - discount).toFixed(2);
                    } else {
                        alert(data);
                    }
                })
            })
        })
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>