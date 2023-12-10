<?php
session_start();
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
            width: 30%;
        }

        .total-section h4 {
            text-align: center;
            margin-top: 5px;
        }

        .whole-cart {
            display: flex;
            width: 95%;
        }
        
        .cart-items {
            border: 2.5px solid black;
            border-radius: 5px;
            width: 60%;
            margin-top: 20px;
            margin-bottom: 30px;
            margin-right: auto;
            margin-left: auto;
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
            width: 55%;
            margin-left: auto;
            margin-right: auto; /* margin left and right set to auto to centre align the product container */
            overflow: hidden;
            position: relative;
            display: flex;
        }

        .sample-product h3 {
            margin: 15px; 
            font-size: 20px;
        }

        .sample-product img {
            width: 120px; /* setting a fixed width for the image for consistency */
            height: auto; 
            border: 2.5px solid #000; 
            border-radius: 5px;
            margin: 15px;

        }

        .sample-product button {
            background-color: #ff0000; 
            border-radius: 3px;
            color: #fff; 
            border: none; 
            margin: 15px;
            padding: 5px 10px; 
            cursor: pointer; 
            transition: background-color 0.2s ease, color 0.2s ease; /* transition of colour upon hover */
            position: absolute; /* positioning the button absolutely so that it can be on the bottom right*/
            bottom: 0; 
            right: 0; 
        }

        .sample-product button:hover {
            background-color: #fff; /* changing background color on hover */
            color: #ff0000;
            border: 2.5px solid #ff0000;
            padding: 5px 10px; 
        }

        hr {
            height: 4px; /* Set the height to make it thicker */
            width: 55%; /* Set the width to make it shorter (adjust as needed) */
            margin: 20px auto; /* Center the line by setting margin and using auto for left and right */
            background-color: #000; /* Set the background color of the line */
            border: none; /* Remove the default border */
        }
    </style>


</head>

<body>
    <!--Navbar Start-->
    <?php include('..\TheZone\\navbar.php') ?>
    <!--Navbar End-->

    <main>
        <!-- <div class="shoppingcart-container">
            <h2 class="text-center">Your Cart</h2>
            <ul id="cart-items">

                <?php
                    // $shopping_cart = $_COOKIE['shopping_cart'] ? $_COOKIE['shopping_cart'] : array();
                    // foreach(unserialize($shopping_cart) as $item) {
                    //     echo '<div class="cart-item" style="background-color: white; "';
                    //     echo '<p> '. $item . '</p>';
                    //     echo '</div>';
                    // }
                ?>
            </ul>
            <p class="text-center">Total: £<span id="cart-total">0.00</span></p>

            <div style="text-align: center;">
                <button class="shoppingcart-button" type="submit" name="checkout-button" onclick="checkout()">Check Out</button>
            </div>

        </div> -->

        <!-- div section for the entire cart and the total amount display -->
        <div class="whole-cart">

            <!-- div section for cart items to be shown -->
            <div class="cart-items">
                <div style="background-color: #333; color: white; text-align: center;padding: 15px;">
                    <h3>Your Cart</h3>
                </div>
                <div class="sample-product">
                    <img src="..\TheZone\images\product2.webp" alt="Sample Product Image">
                    <h3>Grey Zipped Sweater</h3>
                    <h3>£10.99</h3>
                    <button onclick="removeProduct()">Remove</button>
                </div>
                <hr style="">
                <div class="sample-product">
                    <img src="..\TheZone\images\product2.webp" alt="Sample Product Image">
                    <h3>Grey Zipped Sweater</h3>
                    <h3>£10.99</h3>
                    <button onclick="removeProduct()">Remove</button>
                </div>
            </div>
                    
            <!-- div section to show the total and the option to checkout via button -->
            <div class="total-section">
                <h4>TOTAL</h4>
                <hr>
                <p class="text-center">Total Price: £<span id="cart-total">0.00</span></p>
                <div style="text-align: center; margin-bottom: 15px;">
                <button class="shoppingcart-button" type="submit" name="checkout-button" onclick="checkout()">Check Out</button>
                </div>
            </div>    

        </div>

    </main>

    <!-- Footer Start -->
    <?php include('..\TheZone\footer.php') ?>
    <!-- Footer End -->


    <script>
        function checkout() {
            // Redirect to check out page
            window.location.href = 'check-out.php';
        }

        // Render the cart
        function renderCart() {
            // ...

            // Render the cart items
            for (let item of cart.items) {
                // ...

                // Add a remove button
                li.innerHTML += `
            <button class="remove-btn" data-itemid="${item.id}">Remove</button>
        `;
            }

            // ...
        }
        // Event listeners
        document.getElementById('cart').addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-btn')) {
                // Remove the item from the cart
                const itemId = event.target.dataset.itemid;
                cart.removeItem(itemId);

                // Re-render the cart
                renderCart();
            }
        });

        // Cart constructor
        function Cart() {
            // ...

            // Add a method to remove an item from the cart
            this.removeItem = function(itemId) {
                this.items = this.items.filter(function(item) {
                    return item.id !== itemId;
                });

                // Save the updated cart to local storage
                this.saveToLocalStorage();
            };

            // ...
        }

        function removeProduct() {
            // function to remove product from cart page

        }
        //  make changes where needed@khizzer
    </script>
    <!-- needed for drop down menu -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>