<?php
session_start();
include('../server.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .content-posts {
            background-color: #DBEDF2;
            margin: 2rem 1rem;
        }

        .h2-title {
            background-color: #6999C6;
            color: white;
            padding: 1rem;
        }
        .add-posts{
            padding: 2rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content-posts">
            <h2 class="h2-title">เพิ่มกระทู้</h2>
            <div class="add-posts">
                <form action="addpost_db.php" method="post">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="error">
                            <h3>
                                <?php
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                                ?>
                            </h3>
                        </div>
                    <?php endif ?>

                    <div class="form-group">
                        <label for="category">หมวดหมู่</label>
                        <select name="category" id="category" class="form-control" >
                            <?php
                            $sql = "SELECT * FROM category";
                            $result = $conn->query($sql);

                            while ($career = $result->fetch_assoc()):
                                ;
                                ?>
                                <option value="<?php echo $career["category_id"]; ?>">
                                    <?php echo $career["category_name"]; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="posts_name">ชื่อกระทู้</label>
                        <textarea type="content" name="posts_name" class="form-control" rows="3" cols="100"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="posts_content">ข้อความกระทู้</label>
                        <textarea type="content" name="posts_content" class="form-control" rows="5" cols="100"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="thread_img">เพิ่มรูปภาพ</label>
                        <input type="file" name="thread_img">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="addpost" class="btn">เพิ่มกระทู้</button>
                    </div>
                    <div class="form-group">
                        <button type="reset" name="reset" class="btn">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>

</html>