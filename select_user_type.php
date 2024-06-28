<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php include ("header.php"); ?>
    <title>Document</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            color: #fff;
            background-color: #004c6d;
            font-family: 'Kanit', sans-serif;
        }

        .topic {
            width: 100%;
            padding: 1.5em 3em;
        }

        h1 {
            text-align: center;
            font-size: 3em;
            padding: 0.5em 0em;
            text-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }


        .select img {
            width: 10em;
            padding: 1em;
        }

        .btn-select {
            width: 20em;
            padding: 2em 0.2em;
            margin: 1em 1em;
            background: #64839bc4;
            border-radius: 30px;
        }

        .bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(rgba(0, 0, 0, 0.3), transparent), url(Images/cowBG.jpg);
            filter: blur(8px);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            z-index: -1;
            display: grid;
            place-items: center;
        }


        .content {
            position: relative;
            z-index: 1;
            text-align: center;
            padding-top: 3em;
            width: 100%;

        }

        .center {
            display: block;
            margin: auto;
        }

        h4 {
            color: white;
        }

        @media screen and (max-width: 590px) {

            .content {
                padding: 0em !important;
            }

            .topic {
                width: 100%;
                padding: 0.5em 1em;
            }

            h1 {
                font-size: 2em;
                padding-top: 3em;
            }

            .select img {
                width: 7em;
                padding: 1em;
            }

            .btn-select {
                width: 13em;
                padding: 1em 0.2em;
                background: #64839bc4;
                border-radius: 30px;
            }
        }
    </style>
</head>

<body>
    <div class="bg"></div>
    <div class="content">
        <div class="test"></div>
        <div class="blur">
            <div class="topic">
                <h1>เลือกประเภทผู้ใช้งานที่ต้องการลงทะเบียน</h1>
            </div>
            <div class="select d-flex justify-content-center">
                <div class="row center">
                    <div class="btn btn-select col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6"
                        onclick="window.location.href='register_expert.php'">
                        <img src="Images/rating.png" alt="">
                        <h4>
                            ผู้เชี่ยวชาญ
                        </h4>
                    </div>
                    <div class="btn btn-select col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6"
                        onclick="window.location.href='register_user.php'">
                        <img src="Images/people.png" alt="">
                        <h4>
                            ผู้ใช้งานทั่วไป
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>