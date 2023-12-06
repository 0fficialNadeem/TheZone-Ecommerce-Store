<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Same head for a consistent format -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TheZone - Products</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>

  <!-- nav starts -->
  <?php include('..\TheZone\\navbar.php')?>
  <!-- nav ends -->
    <?php
        // if ($SERVER[] == "Post") {
        //     $name = $_POST["name please"];
        //     $email = $_POST["this is the email"];
        //     $message = $_POST["any messages here please"];
    
    
        //     $adminEmail = "admins email";
    
           
        //     $email = "name $name\n";
        //     $email = "email $email\n";
        //     $email = "message $message\n";
    
           
        //     mail($adminEmail, $subject, $emailMessage);
    
            
        //     echo "<p>Thank you for your request, we will get back to you shortly</p>";
        // }
   ?>
    
    <h2>Contact Us</h2>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
    
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
    
        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="4" required></textarea><br>
    
        <input type="submit" value="Submit">
    </form>

    
    
    </body>
    </html>
    


