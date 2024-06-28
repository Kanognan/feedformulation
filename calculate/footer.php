<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>

    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,200;0,400;0,500;1,400&family=Lobster&display=swap"
        rel="stylesheet">
    <title>Document</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Kanit';
    }

    footer {
        margin-top: 6em;
        height: 20em;
        background-image: url('../Images/Foremost.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        overflow: hidden;
        opacity: 0.7;


    }

    .footer-topic-border {
        border-bottom: 3px solid lightgray;
        width: 2em;
    }

    .footer-topic {
        color: black;
    }

    .bottom-footer {
        background-color: #46739C;
        opacity: 0.8;
        color: white;
        text-align: center;
        font-size: 15px;


    }


    .footer-info {
        margin-top: 1.2em;
        z-index: 1;
        color: white;



    }

    #about {
        padding: 3em;
    }

    .footer-info ul li {
        margin-bottom: 0.5em;

    }

    .footer-info ul li:hover {
        color: #46739C;

    }

    .footer-info ul a {
        color: white;
        text-decoration: none;

    }

    .footer-info-social li {
        display: inline;
        margin-right: 0.8em;

    }

    .footer-info-social li i:hover {
        color: white;

    }
    .ft-content{
            width: 100%;
        }
        #about {
            margin-bottom: 1em;
            padding: 1em 3em;
            
        }

    @media screen and (max-width: 850px) {
        footer {
            background-size: cover;
            width: 100%;
            
            
            /* The width is 100%, when the viewport is 800px or smaller */
        }

        #about {
            width: 90%;
            margin-bottom: 1em;
            padding: 1em 3em;
            
        }
        .ft-content{
            width: 100%;
        }
    }
    </style>
</head>

<body>
    <footer>
        <div class="row ft-content">
            <div class="col-3" id="about">
                <h5 class="footer-topic">Feedformulation</h5>
                <div class="footer-topic-border"></div>
                <div class="footer-info">
                    <!-- <img src="Images/Logo.png" alt=""> -->
                    <p>เกี่ยวกับเรา</p>
                </div>
                <div class="footer-info-social">
                    <a href="#">
                        <li><i class="bi bi-facebook" style="font-size:1.6rem; color:#46739C;"></i></li>
                    </a>
                    <li><a href="#"><i class="bi bi-youtube" style="font-size:1.6rem; color:#46739C;"></i></a></li>
                    <li><a href="#"><i class="bi bi-line" style="font-size:1.6rem; color:#46739C;"></i></a></li>
                    <li><a href="#"><i class="bi bi-envelope-fill" style="font-size:1.6rem; color:#46739C;"></i></a>
                    </li>
                </div>
            </div>

            <div class="col-3" id="about">
                <h5 class="footer-topic">บริการของเรา</h5>
                <div class="footer-topic-border"></div>
                <div class="footer-info">
                    <ul>
                        <a href="">
                            <li>หน้าหลัก</li>
                        </a>
                        <a href="">
                            <li>ข่าวสาร</li>
                        </a>
                        <a href="">
                            <li>คลังวัตถุดิบ</li>
                        </a>
                        <a href="">
                            <li>เกี่ยวกับโค</li>
                        </a>
                        <a href="">
                            <li>กระทู้</li>
                        </a>
                        <a href="">
                            <li>ติดต่อเรา</li>
                        </a>

                    </ul>
                </div>
            </div>
        </div>
        <div class="bottom-footer">
            Copyright@2023 &copy;Feedformulation

        </div>
    </footer>


</body>

</html>