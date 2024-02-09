<?php session_start(); ?>

<!doctype html>
<html lang="en">

<head>
    <!-- Same head for a consistent format -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TheZone</title>
    <link rel="stylesheet" href="../TheZone/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background-color: lightgrey;
        }

        .column {
            flex: 1;
            height: 100vh;
            width: 33%;
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
            text-align: center;
            border: solid 5px black;
            border-radius: 0px;
            margin: 10px;
            border-radius: 10px;
        }

        .button {
            margin-top: 12%;
            font-size: 28px;
            font-weight: bold;
            padding: 20px;
            background-color: white;
            color: #000;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease;
            border-radius: 5px;
        }

        .button:hover {
            background-color: black;
            color: #fff;
        }

        #column1 {
            background-image: url('images/box.png'); 
        }

        #column2 {
            background-image: url('images/customer.png'); 
        }

        #column3 {
            background-image: url('images/tracking.png'); 
        }

        @media screen and (min-width: 768px) {
            .column {
                width: 33.33%; 
            }
        }
    </style>
</head>

<body>
    
    <!-- navbar -->
    <?php include('../TheZone/adminnavbar.php') ?>
    <!-- navbar end -->

    <main>

    <div style="display: flex;">

        <div id="column1" class="column">
            <button class="button">INVENTORY VIEW</button>
        </div>

        <div id="column2" class="column">
            <button class="button">CUSTOMERS VIEW</button>
        </div>

        <div id="column3" class="column">
            <button class="button">ORDERS VIEW</button>
        </div>

    </div>

    </main>


</body>