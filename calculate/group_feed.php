<?php
session_start();
if (!isset ($_SESSION["acc_id"]) || $_SESSION["acc_id"] == "") {
    $resultNoSession = "เข้าสู่ระบบก่อนใช้งาน";
    $_SESSION['resultNoSession'] = $resultNoSession;
    echo "<script type='text/javascript'>";
    echo "window.location = '../login.php'; ";
    echo "</script>";
    exit();
    // ผู้ใช้งานทั่วไป
}
include "../server.php";
?>
<?php
ini_set('display_errors', 0);
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <title>คำนวณโภชนะของโคแบบรายกลุ่ม</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kanit', sans-serif;
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

        .top {
            margin-top: 7em;
            height: cover;

        }

        .title-detail {
            text-align: center;
            margin-bottom: 1.5em;
        }

        .main {
            margin-top: 3rem;
            padding: 0.5rem;
            width: 100%;

        }

        .t1-1 {
            background-color: #c6d9eb;
            padding: 2em;
            border-radius: 15px;
            margin-bottom: 1.25em;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
        }

        .feedcow {
            border: 1px solid lightgray;
            padding: 2em;
            border-radius: 20px;
            margin: 1em 2.5em;
            width: 90%;
            height: cover;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
        }

        .demand {
            margin: 1em;
            padding: 1.5em;
            /* width: 89%; */
            border-radius: 20px;
            /* background-color: #A1CAE2; */

        }

        .select-cal {
            border-radius: 30px;
            padding: 1.1em;
            margin: 1em auto;
            border: none;
            width: 13.5em;
            background-color: #f5f5f5;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;

        }

        .select-cal:hover {
            background-color: #78a3d4;
            color: white;
        }

        .select-cal-active {
            border-radius: 30px;
            padding: 1.1em;
            border: none;
            margin: 1em auto;
            width: 13.5em;
            color: white;
            background-color: #A1CAE2;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
        }


        .addmore .btn {
            display: block;
            background-color: #92CA68;
            color: white;
            padding: 0.5em;
            width: 6em;
            margin: 0 auto;
            border-radius: 20px;
            font-size: 1em;
        }


        .addcal .btn:hover,
        .addcal .btn:focus:hover {
            background-color: #92CA68;
            color: black;
        }

        .addmore .btn:hover,
        .addmore .btn:focus:hover {
            background-color: #DBEDF2;
            color: black;
        }

        .edible {
            background-color: #fff;
            /* border-radius: 20px; */
            /* padding: 0.5em; */
            margin: 0.5em auto;
            height: auto;

        }

        .box-edible {
            background-color: #c6d9eb;
            padding: 1.5em;
            border-radius: 20px;
            margin: 2em auto;
            height: auto;

        }


        .tpic-edible {
            background-color: #6999C6;
            padding: 0.5em;
            text-align: center;
            font-size: 1.2em;
            font-weight: 400;

        }

        .content-edible {
            height: 15em;
            padding: 1.5em;

        }

        .pspan {
            color: #eb4343;
            font-size: 0.9em;
        }

        .btn-more {
            margin: 1em 0;
        }

        .btn-more .btn-add {
            background-color: #77DC67;
            color: white;
            width: 8em;
            border-radius: 20px !important;
            margin: 0em 0.3em;
        }

        .btn-more .btn-add:hover {
            background-color: #6999C6 !important;
        }

        .btn-more .btn-cancel {
            background-color: #FE5E5E;
            color: white;
            width: 8em;
            border-radius: 20px !important;
            margin: 0em 0.3em;
        }

        .btn-more .btn-cancel:hover {
            background-color: #6999C6 !important;
        }

        @media (max-width: 576px) {
            .content {
                padding-left: 3em !important;
                padding-right: 2.5em !important;
            }

            .g-2 {
                width: 94%;

            }

            .add .btn {
                width: 100%;
            }

            /* ปรับการจัดวางของปุ่มเพิ่มกลุ่มโค */
            .add {
                text-align: right;
                margin-bottom: 1em;
            }

            /* ปรับขนาดและการจัดวางของปุ่มที่เลือก */
            .select-cal-active,
            .select-cal,
            .select-cal-history {
                width: 100%;
                margin-bottom: 0.5em;
                display: block;
                margin: 0.5em 2em;
            }

            /* ปรับขนาดและการจัดวางของ input fields */
            .col-3,
            .col-6 {
                width: 100%;
                margin-bottom: 0.5em;
            }

            .demand .d-flex {
                flex-direction: column;
                /* align-items: center; */

            }

            .widget {
                display: none !important;
            }

            .demand .col-md-3 {

                width: 100%;
            }

            .demand {
                margin-left: 3.5em;
            }

            h2 {
                margin-left: 2.5em;
            }

            .feedcow {
                margin: 1em 2em;
                width: 95%;
            }

            .feedcow .row>* {

                padding-right: calc(var(--bs-gutter-x)* .1) !important;
            }

        }

        @media (min-width: 768px) {
            .content {
                padding-left: 15em !important;
                padding-right: 2.5em !important;
            }

            .g-2 {
                width: 95% !important;
            }

            .widget {
                display: none !important;
            }

            .col-lg-3 {
                width: 32.33% !important;
            }

            .feedcow {
                margin: 1em 1.5em;
                width: 95%;
            }
            .select-cal-active,
            .select-cal,
            .select-cal-history {
            width: 13em;
            margin:0.5em 2em;
        }



        }
    </style>

<body>
    <div class="flex">
        <div class="g-1">
            <?php include ('sidebar.php') ?>
        </div>
        <div class="g-2">
            <div class="content">
                <!-- เนื้อหา -->
                <h2 class="text-center">คำนวณโภชนะโค</h2>
                <!-- คำนวณอาหาร -->
                <?php include ('../weatherAPI.php'); ?>
                <div class="row demand text-center">
                    <div class="row d-flex justify-content-center">
                        <div class="col-12 col-lg-4 col-md-6">
                            <button type="button" class="select-cal"
                                onclick="window.location='feed.php'">คำนวณโภชนะแบบรายตัว</button>
                        </div>
                        <div class="col-12 col-lg-4 col-md-6">
                            <button type="button" class="select-cal-active"
                                onclick="window.location='group_feed.php'">คำนวณโภชนะแบบกลุ่ม</button>
                        </div>
                        <div class="col-12 col-lg-4 col-md-6">
                            <button type="button" class="select-cal"
                                onclick="window.location='history_demand.php'">ประวัติการคำนวณโภชนะโค</button>
                        </div>
                    </div>
                </div>
                <form action="show_group_feed.php" method="post">
                    <?php
                    $humidity = $result['main']['humidity'];
                    $tem = $result['main']['temp'] - 273.15;
                    ?>
                    <div class="feedcow">
                        <div class="row">
                            <h5>คำนวณโภชนะของโคแบบรายกลุ่ม</h5>
                            <span class="pspan">* คำนวณได้เฉพาะโคอายุ 6 เดือนขึ้นไป</span>
                            <div class="row mt-4">
                                <div class="col-md-6 mb-3 ">
                                    <label for="temperature" class="form-label">อุณหภูมิคอกโค ณ ปัจจุบัน ( ํC)</label>
                                    <input type="text" class="form-control" id="tem" name="tem"
                                        value="<?php echo round($tem) ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="humidity" class="form-label">ความชื้น (%)</label>
                                    <input type="text" class="form-control" id="humidity" name="humidity"
                                        value="<?php echo $humidity ?>">
                                </div><br>
                            </div>
                            <div class="row">
                                <?php
                                $sql = "SELECT DISTINCT group_cow.group_id, group_cow.group_name
                                           FROM cow
                                           INNER JOIN group_cow ON cow.group_id = group_cow.group_id
                                           WHERE acc_id = $acc_id AND group_cow.group_id <> 1
                                           AND NOT EXISTS (
                                             SELECT 1 FROM cow WHERE group_cow.group_id = cow.group_id AND DATEDIFF(NOW(), cow_bday) < 180
                                           )";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    ?>
                                    <div class="col-12 col-lg-3 col-md-6 col-sm-6 mb-3 was-validated">
                                        <label for="">เลือกกลุ่มโค</label><br>
                                        <div class="input-group">
                                            <select class="form-select" id="inputGroupcowSelect"
                                                aria-label="Example select with button addon" name="group_select" required>
                                                <option value="" selected disabled>เลือกกลุ่มโค</option>
                                                <?php
                                                while ($raw = $result->fetch_assoc()):
                                                    ?>
                                                    <option value="<?php echo $raw["group_id"]; ?>">
                                                        <!-- <?php echo $raw["group_id"]; ?> -->
                                                        <?php echo $raw["group_name"]; ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-12 col-lg-2 col-md-6 col-sm-6" id="gender"></div>
                                    <div class="col-12 col-lg-2 col-md-6 col-sm-6 mb-3" id="cowAge"> </div>
                                    <div class="col-12 col-lg-4 col-md-6 col-sm-6 mb-3" id="cowGen"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-1" id="pregnant"></div>
                                    <input type="hidden" name="pregnant" id="pregnantInput">
                                    <div class="col-md-6 mb-1" id="pregnancyday"></div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-6 mb-1" id="milk"></div>
                                    <div class="col-md-6 mb-1" id="milkday"></div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-6 mb-1" id="weight" name="cow_weight"></div>
                                    <div class="col-md-6 mb-1" id="activity" name="cow_activity"></div>
                                </div><br>
                                <div class="row">
                                    <div class="col-12 was-validated" id="growth" name="growth"></div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-6 mb-1 was-validated" id="fat" name="fat"></div>
                                    <div class="col-md-6 mb-1 was-validated" id="protein" name="protein"></div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-6 mb-1 was-validated" id="adg" name="adg"></div>
                                    <div class="col-md-6 mb-1 was-validated" id="totalmilk" name="totalmilk"></div>
                                </div>


                            </div>
                            <div class="d-flex justify-content-center btn-more">
                                <div class="form-group">
                                    <button type="reset" class="btn btn-cancel">ล้างข้อมูล</button>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-add confirm" name="calproductgroup">คำนวณ</button>
                                </div>
                            </div>
                            <?php
                                } else {
                                    ?>
                            <p style="text-align:center; color:gray; margin-top:2em"> คุณยังไม่มีข้อมูลกลุ่มโค ? <span><a
                                        style="text-decoration: underline; color:#6999C6" href="../cow/addgroup.php">
                                        เพิ่มข้อมูลกลุ่มโค</a></span></p>
                            <?php
                                }
                                ?>
                    </div>
            </div>


            <script>
                document.getElementById("inputGroupcowSelect").addEventListener("change", function () {
                    var selectedgroupCow = this.value;
                    var genderContainer = document.getElementById("gender");
                    var ageContainer = document.getElementById("cowAge");
                    var genContainer = document.getElementById("cowGen");
                    var pregnancyContainer = document.getElementById("pregnant");
                    var pregnancyDayContainer = document.getElementById("pregnancyday");
                    var milkContainer = document.getElementById("milk");
                    var milkdayContainer = document.getElementById("milkday");
                    var weightContainer = document.getElementById("weight");
                    var activityContainer = document.getElementById("activity");
                    var fatContainer = document.getElementById("fat");
                    var proteinContainer = document.getElementById("protein");
                    var adgContainer = document.getElementById("adg");
                    var growthContainer = document.getElementById("growth");
                    var totalmilkContainer = document.getElementById("totalmilk");

                    // Clear previous content
                    genderContainer.innerHTML = "";
                    ageContainer.innerHTML = "";
                    genContainer.innerHTML = "";
                    pregnancyContainer.innerHTML = "";
                    pregnancyDayContainer.innerHTML = "";
                    weightContainer.innerHTML = "";
                    activityContainer.innerHTML = "";
                    fatContainer.innerHTML = "";
                    proteinContainer.innerHTML = "";
                    adgContainer.innerHTML = "";
                    growthContainer.innerHTML = "";
                    totalmilkContainer.innerHTML = "";
                    milkContainer.innerHTML = "";
                    milkdayContainer.innerHTML = "";

                    if (selectedgroupCow !== "") {
                        fetchCowData(selectedgroupCow, genderContainer, ageContainer, genContainer,
                            pregnancyContainer, pregnancyDayContainer, milkContainer,
                            milkdayContainer, weightContainer, activityContainer);


                        // Call function to send data to PHP
                        sendDataToPHP(selectedgroupCow);
                    }

                    function sendDataToPHP(selectedgroupCow) {
                        const dataToSend = {
                            group: selectedgroupCow,
                            gen: genContainer,
                            age: ageContainer,
                            dominant_gender: genderContainer,
                            avg_calf_date: pregnancyDayContainer,
                            avg_cow_weight: weightContainer,
                            activity: activityContainer
                            // ... (เพิ่มต่อไปตามความต้องการ)
                        };

                        console.log(JSON.stringify(dataToSend));

                        fetch('group_feed.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json;charset=UTF-8'
                            },
                            body: JSON.stringify(dataToSend)
                        })
                            .then(response => response.json())
                            .then(data => {
                                // Handle the response data here
                                console.log(data);
                            })
                        // .catch(error => {
                        //     // Handle errors
                        //     console.error('Error occurred', error);
                        // });
                    }


                    function fetchCowData(selectedgroupCow, genderContainer, ageContainer, genContainer,
                        pregnancyContainer, pregnancyDayContainer, milkContainer, milkdayContainer,
                        weightContainer, activityContainer
                    ) {
                        fetch(`fetch_group.php?selectedgroupCow=${encodeURIComponent(selectedgroupCow)}`)
                            .then(response => response.json())
                            .then(data => {
                                // Log the entire data received from the server
                                console.log(data);

                                const cowGenders = Array.isArray(data.dominant_gender) ? data
                                    .dominant_gender : [data.dominant_gender];

                                const cowweight = Array.isArray(data.avg_cow_weight) ? data
                                    .avg_cow_weight : [data.avg_cow_weight];

                                const cowactivity = Array.isArray(data.cow_activity) ? data
                                    .cow_activity : [data.cow_activity];

                                const cowBirthdays = Array.isArray(data.avg_age) ? data
                                    .avg_age : [data.avg_age];

                                const calfdate = Array.isArray(data.avg_calf_date) ? data
                                    .avg_calf_date : [data.avg_calf_date];

                                const milkdate = Array.isArray(data.avg_milk_date) ? data
                                    .avg_milk_date : [data.avg_milk_date];

                                const milkstatus = Array.isArray(data.cow_milk_status) ? data
                                    .cow_milk_status : [data.cow_milk_status];

                                const breedstatus = Array.isArray(data.cow_breed_status) ? data
                                    .cow_breed_status : [data.cow_breed_status];

                                const avg_gen = Array.isArray(data.avg_gen) ? data
                                    .avg_gen : [data.avg_gen];



                                // Populate ageContainer and genContainer
                                cowBirthdays.forEach(avg_age => {
                                    const ageInput = createInputField("inputAge",
                                        "ค่าเฉลี่ยอายุโค", avg_age
                                    );
                                    ageContainer.appendChild(ageInput);
                                    const ageInputs = ageContainer.getElementsByTagName(
                                        'input');
                                    for (let i = 0; i < ageInputs.length; i++) {
                                        ageInputs[i].disabled = true;
                                    }

                                });

                                // Populate ageContainer and genContainer
                                avg_gen.forEach(avg_gen => {
                                    const ageInput = createInputField("inputGen",
                                        "รุ่นของโค", avg_gen
                                    );
                                    genContainer.appendChild(ageInput);
                                    const genInputs = genContainer.getElementsByTagName(
                                        'input');
                                    for (let i = 0; i < genInputs.length; i++) {
                                        genInputs[i].disabled = true;
                                    }

                                });

                                // Populate genderContainer
                                cowGenders.forEach(dominant_gender => {
                                    const genderInput = createInputField("inputGender",
                                        "เพศโค", dominant_gender);
                                    genderContainer.appendChild(genderInput);
                                    genderContainer.appendChild(document.createElement(
                                        "br"));
                                    const genderInputs = genderContainer
                                        .getElementsByTagName('input');
                                    for (let i = 0; i < genderInputs.length; i++) {
                                        genderInputs[i].disabled = true;
                                    }
                                });

                                cowweight.forEach(avg_cow_weight => {
                                    // Convert avg_cow_weight to a number with two decimal places
                                    const avgCowWeightFormatted = parseFloat(avg_cow_weight).toFixed(2);

                                    const weightInput = createInputField("inputweight",
                                        "ค่าเฉลี่ยน้ำหนักโค (กิโลกรัม)", avgCowWeightFormatted);
                                    weightContainer.appendChild(weightInput);
                                    weightInput.setAttribute("disabled", true);
                                    weightContainer.appendChild(document.createElement("br"));

                                    // Disable all input fields
                                    const weightInputs = weightContainer.getElementsByTagName('input');
                                    for (let i = 0; i < weightInputs.length; i++) {
                                        weightInputs[i].disabled = true;
                                    }
                                });

                                cowactivity.forEach(cow_activity => {
                                    const activityInput = createInputField("inputactivity",
                                        "กิตติกรรมการเดิน", cow_activity);
                                    activityContainer.appendChild(activityInput);
                                    activityInput.setAttribute("disabled", true);
                                    activityContainer.appendChild(document.createElement(
                                        "br"));
                                    const activityInputs = activityContainer
                                        .getElementsByTagName('input');
                                    for (let i = 0; i < activityInputs.length; i++) {
                                        activityInputs[i].disabled = true;
                                    }

                                });

                                calfdate.forEach(avg_calf_date => {
                                    const avgcalfDateInt = parseInt(avg_calf_date);
                                    const calfdayInput = createInputField("inputcalfdate",
                                        "ค่าเฉลี่ยอายุครรภ์(วัน)", avgcalfDateInt);
                                    pregnancyDayContainer.appendChild(calfdayInput);
                                    calfdayInput.setAttribute("disabled", true);
                                    pregnancyDayContainer.appendChild(document.createElement(
                                        "br"));
                                    const activityInputs = pregnancyDayContainer
                                        .getElementsByTagName('input');
                                    for (let i = 0; i < activityInputs.length; i++) {
                                        activityInputs[i].disabled = true;
                                    }

                                });
                                breedstatus.forEach(cow_breed_status => {
                                    const breedstatusInput = createInputField("inputbreedstatus",
                                        "สถานะการตั้งท้อง", cow_breed_status);
                                    pregnancyContainer.appendChild(breedstatusInput);
                                    breedstatusInput.setAttribute("disabled", true);
                                    pregnancyContainer.appendChild(document.createElement(
                                        "br"));
                                    const breedstatusInputs = pregnancyContainer
                                        .getElementsByTagName('input');
                                    for (let i = 0; i < breedstatusInputs.length; i++) {
                                        breedstatusInputs[i].disabled = true;
                                    }

                                });
                                milkstatus.forEach(cow_milk_status => {
                                    const milkstatusInput = createInputField("inputmilkstatus",
                                        "สถานะการให้นม", cow_milk_status);
                                    milkContainer.appendChild(milkstatusInput);
                                    milkstatusInput.setAttribute("disabled", true);
                                    milkContainer.appendChild(document.createElement(
                                        "br"));
                                    const milkstatusInputs = milkContainer
                                        .getElementsByTagName('input');
                                    for (let i = 0; i < milkstatusInputs.length; i++) {
                                        milkstatusInputs[i].disabled = true;
                                    }

                                });
                                milkdate.forEach(avg_milk_date => {
                                    // Convert avg_milk_date to integer
                                    const avgMilkDateInt = parseInt(avg_milk_date);
                                    const milkdayInput = createInputField("inputmilkdate",
                                        "ค่าเฉลี่ยวันให้นม(วัน)", avgMilkDateInt);
                                    milkdayContainer.appendChild(milkdayInput);
                                    milkdayInput.setAttribute("disabled", true);
                                    milkdayContainer.appendChild(document.createElement("br"));

                                    // Disable all input fields
                                    const milkdayInputs = milkdayContainer.getElementsByTagName(
                                        'input');
                                    for (let i = 0; i < milkdayInputs.length; i++) {
                                        milkdayInputs[i].disabled = true;
                                    }
                                });

                                if (data.cow_milk_status == 'ไม่ให้นม') {
                                    // สร้าง input เพิ่ม
                                    const additionalInputContainer4 = document
                                        .createElement("div");
                                    additionalInputContainer4.className = "col-12";

                                    const additionalInputLabel4 = document.createElement(
                                        "label");
                                    additionalInputLabel4.textContent =
                                        "ความต้องการเพิ่มหรือลดน้ำหนัก(กิโลกรัม)";
                                    additionalInputContainer4.appendChild(
                                        additionalInputLabel4);

                                    const additionalInput4 = document.createElement(
                                        "input");
                                    additionalInput4.type = "number";
                                    additionalInput4.step = "0.01";
                                    additionalInput4.min = "-999";
                                    additionalInput4.max = "999";
                                    additionalInput4.className = "form-control";
                                    additionalInput4.name = "growth";
                                    additionalInput4.value = "";
                                    additionalInput4.required = "true";

                                    const additionalP = document.createElement("p");
                                    // เพิ่มคลาส CSS และเนื้อหาในองค์ประกอบ `<p>`
                                    additionalP.className = "pspan";
                                    additionalP.textContent =
                                        "* ถ้าต้องการลดน้ำหนักให้กรอก 'จำนวนติดลบ'(กิโลกรัม)";

                                    // เพิ่มองค์ประกอบ `<p>` ไปยัง `<div>` ที่มี ID ว่า "growth"
                                    document.getElementById("growth").appendChild(
                                        additionalInputContainer4);
                                    document.getElementById("growth").appendChild(additionalP);
                                    additionalInputContainer4.appendChild(additionalInput4);

                                } else if (data.cow_milk_status == 'ให้นม') {
                                    // สร้าง input เพิ่ม
                                    const additionalInputContainer = document
                                        .createElement(
                                            "div");
                                    additionalInputContainer.className = "col-12";

                                    const additionalInputLabel1 = document
                                        .createElement(
                                            "label");
                                    additionalInputLabel1.textContent =
                                        "ค่าเฉลี่ยโปรตีนในน้ำนม(%)";
                                    additionalInputContainer.appendChild(
                                        additionalInputLabel1);

                                    const additionalInput1 = document.createElement(
                                        "input");
                                    additionalInput1.type = "number";
                                    additionalInput1.step = "0.01";
                                    additionalInput1.min = "0";
                                    additionalInput1.max = "999";
                                    additionalInput1.className = "form-control";
                                    additionalInput1.name = "protein";
                                    additionalInput1.value = "";
                                    additionalInput1.required = "true";
                                    additionalInputContainer.appendChild(
                                        additionalInput1);

                                    additionalInputContainer.appendChild(document
                                        .createElement("br"));
                                    document.getElementById("protein").appendChild(
                                        additionalInputContainer);

                                    const additionalInputContainer2 = document
                                        .createElement("div");
                                    additionalInputContainer2.className = "col-12";

                                    const additionalInputLabel2 = document
                                        .createElement(
                                            "label");
                                    additionalInputLabel2.textContent =
                                        "ค่าเฉลี่ยไขมันในน้ำนม(%)";
                                    additionalInputContainer2.appendChild(
                                        additionalInputLabel2);

                                    const additionalInput2 = document.createElement(
                                        "input");
                                    additionalInput2.type = "number";
                                    additionalInput2.step = "0.01";
                                    additionalInput2.min = "0";
                                    additionalInput2.max = "999";
                                    additionalInput2.className = "form-control";
                                    additionalInput2.name = "fat";
                                    additionalInput2.value = "";
                                    additionalInput2.required = "true";
                                    additionalInputContainer2.appendChild(
                                        additionalInput2);

                                    additionalInputContainer2.appendChild(document
                                        .createElement("br"));
                                    document.getElementById("fat").appendChild(
                                        additionalInputContainer2);

                                    const additionalInputContainer3 = document
                                        .createElement("div");
                                    additionalInputContainer3.className = "col-12";

                                    const additionalInputLabel3 = document
                                        .createElement(
                                            "label");
                                    additionalInputLabel3.textContent =
                                        "ความต้องการเพิ่มหรือลดน้ำหนัก";
                                    additionalInputContainer3.appendChild(
                                        additionalInputLabel3);

                                    const additionalInput3 = document.createElement(
                                        "input");
                                    additionalInput3.type = "number";
                                    additionalInput3.step = "0.01";
                                    additionalInput3.min = "-999";
                                    additionalInput3.max = "999";
                                    additionalInput3.className = "form-control";
                                    additionalInput3.name = "adg";
                                    additionalInput3.value = "";
                                    additionalInput3.required = "true";
                                    additionalInputContainer3.appendChild(
                                        additionalInput3);

                                    document.getElementById("adg").appendChild(
                                        additionalInputContainer3);
                                    const additionalP = document.createElement("p");
                                    // เพิ่มคลาส CSS และเนื้อหาในองค์ประกอบ `<p>`
                                    additionalP.className = "pspan";
                                    additionalP.textContent =
                                        "* ถ้าต้องการลดน้ำหนักให้กรอก 'จำนวนติดลบ'(กิโลกรัม)";
                                    // เพิ่มองค์ประกอบ `<p>` ไปยัง `<div>` ที่มี ID ว่า "growth"
                                    document.getElementById("adg").appendChild(additionalP);

                                    const additionalInputContainer7 = document
                                        .createElement("div");
                                    additionalInputContainer7.className = "col-12";

                                    const additionalInputLabel7 = document
                                        .createElement(
                                            "label");
                                    additionalInputLabel7.textContent =
                                        "ค่าเฉลี่ยปริมาณน้ำนมต่อวัน(กิโลกรัม)";
                                    additionalInputContainer7.appendChild(
                                        additionalInputLabel7);

                                    const additionalInput7 = document.createElement(
                                        "input");
                                    additionalInput7.type = "number";
                                    additionalInput7.step = "0.01";
                                    additionalInput7.min = "0";
                                    additionalInput7.max = "999";
                                    additionalInput7.className = "form-control";
                                    additionalInput7.name = "totalmilk";
                                    additionalInput7.value = "";
                                    additionalInput7.required = "true";
                                    additionalInputContainer7.appendChild(
                                        additionalInput7);
                                    additionalInputContainer7.appendChild(document
                                        .createElement("br"));

                                    document.getElementById("totalmilk").appendChild(
                                        additionalInputContainer7);

                                }

                            });
                    }

                });
                // ------------------------------------------------------------------------------------------
                function createInputField(name, label, value) {
                    var container = document.createElement("div");

                    var labelElement = document.createElement("label");
                    labelElement.textContent = label;
                    container.appendChild(labelElement);

                    var inputElement = document.createElement("input");
                    inputElement.type = "text";
                    inputElement.name = name;
                    inputElement.value = value;
                    inputElement.className = "form-control";
                    container.appendChild(inputElement);

                    return container;
                }

                function clearPreviousData() {
                    // ลบข้อมูลทั้งหมดที่มี ID เหล่านี้
                    document.getElementById("gender").innerHTML = "";
                    document.getElementById("cowAge").innerHTML = "";
                    document.getElementById("cowGen").innerHTML = "";
                    document.getElementById("Pregnant").innerHTML = "";
                    document.getElementById("pregnancyday").innerHTML = "";
                    document.getElementById("milk").innerHTML = "";
                    document.getElementById("milkday").innerHTML = "";
                    // document.getElementById("adg").innerHTML = "";
                    // document.getElementById("protein").innerHTML = "";
                    // document.getElementById("fat").innerHTML = "";
                    // document.getElementById("growth").innerHTML = "";
                    // document.getElementById("weight").innerHTML = "";
                    // document.getElementById("activity").innerHTML = "";
                }
            </script>
            <?php
            if (isset ($_SESSION['resultData'])) {
                $resultData = $_SESSION['resultData'];
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'เพิ่มข้อมูลสำเร็จ',
                                text: '" . $resultData . "',
                                confirmButtonText: 'OK',
                                showConfirmButton: false,
                                timer: 2000 
                            });
                        });
                    </script>";
                unset($_SESSION['resultData']);
            }

            ?>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    document.querySelector("#menu a[href='feed.php']").classList.add("active");
                });
            </script>








</body>

</html>