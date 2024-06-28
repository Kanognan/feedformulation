<?php 
session_start();
include('../server.php');
$acc_id = $_SESSION['acc_id'];
$sql = "SELECT * FROM cow WHERE acc_id = $acc_id order by createAt DESC";
$breed = "SELECT * FROM cow_breed";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
        </script>
    <script src="js/bootstrap.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,200;0,400;0,500;1,400&family=Lobster&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: kanit;

        }


        .cow-border {
            margin-top: 3em;
            border-radius: 20px;
 
        }
        .second{
            margin-bottom:2em;
        }

      

        .cow-border img {
            align-items: center;
            border-radius: 50%;
            width: 4.5em;
            height: 4.5em;
        }

    
        */ .card-text p {
            text-align: center;
            margin-top: 1.2em;
        }

        .col-3 #right {
            display: inline;



        }

        .add .btn {
        background-color: #4F80C0;
        color: white;
        width: 10.5em;
        padding: 0.5em;
        border-radius: 20px;
        font-size: 1em;
        margin: 0.5em 0.2em 0.5em 0.6em;

    }

        
        button[type=submit] {
        background-color: #4F80C0;
        color: white;
        width: 4.8em;
        padding: 10px;
        border-radius: 20px;
        font-size: 1em;
    }


        .show>li:hover {
            background-color: lightgray;
            cursor: pointer;
        }

        .tableact {
            background-color: #4F80C0 !important;
        }

        .add .btn:hover,
        .add .btn:focus,
        button[type=submit]:hover {
            background-color: #AACCE2;
            color: black;
        }

        .search {
            width: 50%;
            padding: 8px;
            border-color: #4F80C0;
            border-radius: 20px;
            margin: 0.2em;
            margin-bottom: 2em;
        }

     
        .flex {
        display: flex;
    }

    .g-2 {
        flex: 1;
    }

    .content {
        padding: 3em;
        padding-left: 16em !important;
        width: 100%;
    }
    .breed {
        text-align: center;
        
        color: white;
        border-radius: 5px;
    }

        
    @media (max-width: 576px) {
        .content {
            padding-left: 7em !important;
        }

        .show {
            display: none;
        }

        .col-2 {
            display: none;
            width: 100%;
        }
    }
    </style>
</head>

<body>
<?php include('nav-bar.php') ?>
   <div class="flex">
    <div class="g-1"> <?php include('sidebar.php') ?></div>
    <div class="g-2">
        <div class="content">
        <div class="row headcow">
                    <div class="col-8">
                        <h3>ข้อมูลโค</h3>
                    </div>
                    <div class="col-4">
                        <div class="d-grid gap-2 d-md-inline">
                            <a href="group.php" class="add"><button type="button" class="btn">กลุ่มโค</button></a>
                            <a href="addcow.php" class="add"><button type="button"
                                    class="btn">เพิ่มข้อมูลโค</button></a>
                            <!-- <a href="update_weight.php" class="add"><button type="button" class="btn">อัปเดตน้ำหนักโค</button></a> -->
                        </div>
                    </div>
                </div>
                <div class="row ser">
                <div class="col-9">
                        <form action="tablecow.php" method="post">
                            <input class="search" type="text" name="search"
                                placeholder="ป้อนรหัส/ชื่อโคที่ต้องการค้นหา">
                            <button type="submit" class="btn">ค้นหา</button>
                        </form>
                    </div>
                    <div class="col-3"></div>
                </div>
                <div class="row second">
                <div class="col-10">
                        <div class="show">
                            <li class="non" id="non">การแสดงผล :</li>
                            <li id="nactive" onclick="document.location='cow.php'"><img src="../Images/image.png" alt=""
                                    style="width:25px; margin-right:1em;">รูปภาพ</li>
                            <li class="tableact" onclick="document.location='tablecow.php'"><img
                                    src="../Images/table.png" style="width:25px; margin-right:1em; alt=">ตาราง</li>
                        </div>
                    </div>
                    <div class="col-2">
                       
                        <span>มีข้อมูลทั้งหมด
                            <?php echo mysqli_num_rows($result) ?> รายการ
                        </span>
                    </div>
                </div>
                <div class="row">
                    <?php
                // Check if the search query is submitted
                $sql = "SELECT * FROM cow where acc_id = $acc_id";
                if (isset($_POST['search'])) {
                    $search_query = mysqli_real_escape_string($conn, $_POST['search']);
                    // Modify the SQL query to include the search condition
                    $sql .= " AND (cow.cow_id LIKE '%$search_query%' OR cow.cow_name LIKE '%$search_query%')";
                    echo "<p style='color:gray; margin-left:1em; margin-top:1.5em'>ผลลัพธ์การค้นหาจาก : ".$search_query."</p>";
                
                    // Execute the modified query
                    $result = $conn->query($sql);
                    if (!$result) {
                        die("Query failed: " . $conn->error);
                    }
                    ?>
                    <div class="cow-border">
                <table class="table table-hover"  style="text-align:center;">
                    <thead>
                        <tr class="table table-primary">
                            <th scope="col">รูปภาพ</th>
                            <th scope="col">หมายเลขประจำตัวโค</th>
                            <th scope="col">ชื่อ</th>
                            <th scope="col">พันธุ์</th>
                            <th scope="col">เพศ</th>
                            <th scope="col">สถานะ</th>
                            <th scope="col">จัดการ</th>
                        </tr>
                    </thead>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                         
                         
                    <?php $sql = "SELECT * FROM cow WHERE acc_id = $acc_id order by createAt DESC";
                    $mui = mysqli_query($conn, "select * from cattle_breed inner join cow on cattle_breed.cb_id = cow.cb_id");
                    $mtc = mysqli_fetch_assoc($mui);
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tbody>
                                <tr>
                                    <td onclick="window.location='index_infor_cow.php?id=<?php echo $row['cow_id']; ?>'"><img
                                            class="img-circle" src="../pic/<?php echo $row["cow_img"]; ?>" /></td>
                                    <td onclick="window.location='index_infor_cow.php?id=<?php echo $row['cow_id']; ?>'"><?php echo $row["cow_id"]; ?></td>
                                    <td onclick="window.location='index_infor_cow.php?id=<?php echo $row['cow_id']; ?>'"><?php echo $row["cow_name"], " "; ?></td>
                                    <td onclick="window.location='index_infor_cow.php?id=<?php echo $row['cow_id']; ?>'"><?php echo $mtc["cb_Thainame"], " "; ?></td>
                                    <td onclick="window.location='index_infor_cow.php?id=<?php echo $row['cow_id']; ?>'"> <?php echo $row["cow_gender"], " ", " "; ?></td>
                                    <td onclick="window.location='index_infor_cow.php?id=<?php echo $row['cow_id']; ?>'"><div class="breed" style="background-color: <?php
                                            echo ($row["cow_breed_status"] === 'กำลังตั้งท้อง') ? '#73C088' :
                                                (($row["cow_breed_status"] === 'รอตรวจท้อง') ? '#FBD741' :
                                                (($row["cow_breed_status"] === 'แท้ง') ? '#EA6D75' : '#C084CC'));
                                        ?>">
                                                <?php echo $row["cow_breed_status"]; ?>
                                            </div></td>
                                    <td>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <a href="#cow<?php echo $row['cow_id']; ?>" data-toggle="modal"
                                                class="btn btn-warning"><span class="glyphicon glyphicon-edit" ></span><img
                                                    src="../pic/edit.png" alt=""
                                                    style="width:15px; height:15px; margin-right:5px" title="แก้ไขข้อมูลโค"></a>
                                            <a href="#cowdel<?php echo $row['cow_id']; ?>" data-toggle="modal"
                                                class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span><img
                                                    src="../pic/delete.png" alt=""
                                                    style="width:15px; height:15px; margin-right:5px" title="ลบข้อมูลโค"></a>
                                        </div>
                                        <?php include('cow_update_model.php'); ?>
                                    </td>

                                </tr>
                            </tbody>
                        <?php }
                    } else {
                        echo "<td colspan='5' style='color: gray; padding: 2em; font-size:1.1em; text-align:center;'>' ไม่มีรายการข้อมูลโค '</td>";

                    }
                    ?>
                </table>

            </div>
            </div>
                        <?php
                        }
                    } else {
                        echo "<td colspan='6' style='color: gray; padding: 2em; font-size:1.1em; text-align:center;'>' ไม่มีรายการค้นหาจาก : ".$search_query. " '</td>";
                    }
                } else {
                    // If no search query submitted, fetch and display all cows
                    $sql = "SELECT * FROM cow WHERE acc_id = $acc_id";
                    $result = $conn->query($sql);

                    if (!$result) {
                        die("Query failed: " . $conn->error);
                    }
                    ?>
                <div class="row">
                <div class="cow-border">
                <table class="table table-hover"   style="text-align:center;">
                    <thead>
                        <tr class="table table-primary">
                            <th scope="col">รูปภาพ</th>
                            <th scope="col">หมายเลขประจำตัวโค</th>
                            <th scope="col">ชื่อ</th>
                            <th scope="col">พันธุ์</th>
                            <th scope="col">เพศ</th>
                            <th scope="col">สถานะ</th>
                            <th scope="col">จัดการ</th>
                        </tr>
                    </thead>
                    <?php if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            
                    $sql = "SELECT * FROM cow WHERE acc_id = $acc_id order by createAt DESC";
                    $mui = mysqli_query($conn, "select * from cattle_breed inner join cow on cattle_breed.cb_id = cow.cb_id");
                    $mtc = mysqli_fetch_assoc($mui);
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tbody>
                                <tr>
                                    <td onclick="window.location='index_infor_cow.php?id=<?php echo $row['cow_id']; ?>'"><img
                                            class="img-circle" src="../pic/<?php echo $row["cow_img"]; ?>" /></td>
                                    <td onclick="window.location='index_infor_cow.php?id=<?php echo $row['cow_id']; ?>'"><?php echo $row["cow_id"]; ?></td>
                                    <td onclick="window.location='index_infor_cow.php?id=<?php echo $row['cow_id']; ?>'"><?php echo $row["cow_name"], " "; ?></td>
                                    <td onclick="window.location='index_infor_cow.php?id=<?php echo $row['cow_id']; ?>'"><?php echo $mtc["cb_Thainame"], " "; ?></td>
                                    <td onclick="window.location='index_infor_cow.php?id=<?php echo $row['cow_id']; ?>'"> <?php echo $row["cow_gender"], " ", " "; ?></td>
                                    <td onclick="window.location='index_infor_cow.php?id=<?php echo $row['cow_id']; ?>'"><div class="breed" style="background-color: <?php
                                            echo ($row["cow_breed_status"] === 'กำลังตั้งท้อง') ? '#73C088' :
                                                (($row["cow_breed_status"] === 'รอตรวจท้อง') ? '#FBD741' :
                                                (($row["cow_breed_status"] === 'แท้ง') ? '#EA6D75' : '#C084CC'));
                                        ?>">
                                                <?php echo $row["cow_breed_status"]; ?>
                                            </div></td>
                                    <td>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <a href="#cow<?php echo $row['cow_id']; ?>" data-toggle="modal"
                                                class="btn btn-warning"><span class="glyphicon glyphicon-edit" ></span><img
                                                    src="../pic/edit.png" alt=""
                                                    style="width:15px; height:15px; margin-right:5px" title="แก้ไขข้อมูลโค"></a>
                                            <a href="#cowdel<?php echo $row['cow_id']; ?>" data-toggle="modal"
                                                class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span><img
                                                    src="../pic/delete.png" alt=""
                                                    style="width:15px; height:15px; margin-right:5px" title="ลบข้อมูลโค"></a>
                                        </div>
                                        <?php include('cow_update_model.php'); ?>
                                    </td>

                                </tr>
                            </tbody>
                        <?php }
                    } else {
                        echo "<td colspan='6' style='color: gray; padding: 2em; font-size:1.1em; text-align:center;'>' ไม่มีรายการข้อมูลโค '</td>";

                    }
                    ?>
                </table>

            </div>
                </div>
                            <?php
                        }
                    } else {
                        echo "<div class='else'><p>ไม่มีรายการข้อมูลโค</p></div>";
                    }
                }// End of while loop
                    ?>
    
                </div>
                </div>
                </div>

            </div>
        </div>
    </div>

</body>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("#menu a[href='cow.php']").classList.add("active");
});
</script>

</html>
                
                
            
      
  
    

   
</body>


</html>