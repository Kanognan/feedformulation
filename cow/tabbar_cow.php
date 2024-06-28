<?php 
session_start();
include('../server.php');
$sql = "SELECT * FROM cow order by createAt DESC";
$breed = "SELECT * FROM cow_breed";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: 'Kanit';
        }
        body{
            min-height:100vh;
            background:white;
            color:white;
            background-size:cover;
            background-position: center;
            
        }
        .side-bar{
            background-color:#6999C6 ;
            width:250px;
            height:100vh;
            position:fixed;
            top:0;
            overflow-y: auto;
            transition: 0.6s ease;
            transition-property:left;
            margin-top:7em;
            margin-right:7em;

        }
        .menu{
            width:100%;
            /* margin-top:10px; */

        }
        .menu .item{
            position:relative;
            cursor:pointer;
        }
        .menu .item:hover{
          background-color:#00445F;
          
        }
        .menu .item a{
            color:#fff;
            text-decoration:none;
            display:block;
            padding:5px 30px;
            line-height:60px;
        }
        .menu .item a:hover{
            color:#fff;
            
        }
        .item i{
            margin-right:18px;
            font-size: 20px;
            color: #fff;
       
        }
        .item i:hover{
            color:#6999C6;
       
        }
    </style>
</head>
<body>
    <div class="side-bar">
        <div class="menu">
            <div class="item"><a href="cow.php"><i class="fa-solid fa-cow"></i>ข้อมูลทั่วไปของโค</a></div>
            <div class="item"><a href="index_dianosis_cow.php"><i class="fa-solid fa-suitcase-medical"></i>การเจ็บป่วยของโค</a></div>
            <div class="item"><a href="index_vaccine_cow.php"><i class="fa-solid fa-syringe"></i>การฉีดวัคซีน</a></div>
            <div class="item"><a href="index_health_cow.php"><i class="fa-solid fa-virus-covid"></i>การตรวจโรคประจำปี</a></div>
            <div class="item"><a href="index_breed_cow.php"><i class="fa-solid fa-venus-mars"></i>การผสมพันธุ์</a></div>
            <div class="item"><a href="index_milk_cow.php"><i class="fa-solid fa-bottle-droplet"></i>ผลผลิตของโค</a></div>
        </div>
    </div>
</body>
</html>