<?php include("../server.php"); ?>
<?php include("../session/user_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include("../header.php"); ?>
    <title>คำนวณสูตรอาหาร</title>
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
        i {
        font-size: 20px;
        margin-right: 0.7em;
    }

    .top {
        margin-top: 7em;
        height: cover;

    }

    /* Style the tab */
    .tab {
        float: left;
        background-color: #6999C6;
        width: 17%;
        height: 900px;
        display: block;
        position: fixed;

    }

    /* Style the buttons inside the tab */
    .tab button {
        display: block;
        background-color: inherit;
        color: white;
        padding: 22px 28px;
        width: 100%;
        border: none;
        outline: none;
        text-align: left;
        cursor: pointer;
        transition: 0.3s;
        font-size: 16px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        color: white;
        border-bottom: 2px solid transparent;
        border-image: linear-gradient(90deg, rgba(255, 255, 255, 1) 0%, rgba(254, 254, 254, 1) 0%, rgba(253, 253, 253, 0.9473039215686274) 11%, rgba(250, 250, 250, 0) 100%);
        border-image-slice: 1;
        border-radius: 0 !important;
    }

    /* Create an active/current "tab button" class */
    .tab button.active {
        background-color: #BBD1E5;
        color: black;
    }

    /* Style the tab content */
    .tabcontent {
        padding-left: 8em !important;
        width: 83%;
        border-left: none;
        min-height: 900px;
        margin-top: 2em;
        margin-left: 13em;

    }

    .add .btn {
        background-color: #77DC67;
        color: white;
        width: 8em;
        border-radius: 20px !important;
        margin: 0em 0.3em;
    }

    .add .btn:hover,
    .add .btn:focus:hover {
        background-color: #92CA68;
        color: black;
    }

    .cow {
        width: 100%;
        margin-top: 9em;
    }

    .tagname {
        text-align: center;
        color: #4f80c0;
        font-size: 2em;
        font-style: italic;
        margin-bottom: 1.2em;
        padding-top: 1.2em;
    }

    .feed {
        margin-top: 4em;
    }

    .cowpic {
        display: block;
        margin: auto;
    }

    .cowpic img {
        align-items: center;
        width: 10em;
        display: block;
        margin: 0 auto;

    }

    .ms1 {
        text-indent: 1.7em;
    }

    #box {

        border-radius: 8px;
        padding: 1.2em;
        cursor: pointer;

    }

    /* .col-6 .calinput{
        padding: 1em !important;
        margin: 1em !important;
        width: 95%;
    } */

    .title-detail {
        text-align: center;
        margin-bottom: 1.5em;
    }

    /* #box:hover {
        box-shadow: 5px 5px 5px #e0efff;
    } */

    .detail {
        margin-top: 1.2em;

    }

    .detail-topic {
        font-size: 1.4em;
    }

    #tem {
        width: 25em;
        margin: 0 auto;
        border: 1px solid gray;
        padding: 1.4rem;
        border-radius: 18px;
    }

    .card-img {
        float: left;
    }

    /* .tab-content {
        width: 75%;
        margin: 6rem;
        /* background-color:blue; 
    }

    */
    .main {
        margin-top: 3rem;
        padding: 0.5rem;
        width: 100%;

    }

    .feed-cow {
        border: 1px solid lightgray;
        padding: 2em;
        border-radius: 20px;
        margin-top: 1.5em;
    }


    .no-cow {
        float: right;

        /* margin-top: 1.5rem; */

    }

    #mat {
        margin-bottom: 1.3rem;
        font-size: 18em;
    }

    .submit {
        margin: 0 auto;

    }


    .profit {
        margin-top: 2rem;
        background-color: #DBEDF2;
        padding: 2.5rem;
    }

    .indent {
        text-indent: 2rem;
    }

    #amount {
        width: 80%;
        margin: 0.4rem;
        padding: 0.5rem;
        border-radius: 15px;
        border: none;
        background-color: #DBEDF2;
        text-align: center;

    }

    .ind {
        margin: 1.4rem;

    }

    .addcal .btn {
        display: block;
        background-color: #4F80C0;
        color: white;
        padding: 0.5em;
        width: 8em;
        margin: 0 auto;
        border-radius: 20px;
        font-size: 1em;
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

    #year {
        width: 90%;
        display: block;
        margin: 0 auto;
        padding: 0.8rem;
        border-color: #6999C6;
        color: black;
        margin-bottom: 1.3rem;
    }

    .btn-outline {
        width: 30rem;
    }

    .btn-check:checked+.btn,
    .btn.active,
    .btn.show,
    .btn:first-child:active,
    :not(.btn-check)+.btn:active {
        background-color: #6999C6;
    }

    .btn-check:checked+.btn,
    .btn.active,
    .btn.show,
    .btn:first-child:active,
    :not(.btn-check)+.btn:active {
        background-color: #6999C6 !important;
        border-color: #6999C6;
        color: white !important;
    }

    .edible {
        background-color: #fff ;
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
    .tpic-edible{
        background-color: #6999C6;
        padding: 0.5em;
        text-align: center;
        font-size: 1.2em;
        font-weight: 400;
        
    }
    .content-edible{
        height: 15em;
        padding: 1.5em;
        
    }

        @media (max-width: 576px) {
            .content {
                padding-left: 7em !important;
            }
        }
    </style>

<body>
    <div class="flex">
        <div class="g-1">
            <?php include('sidebar.php') ?>
        </div>
        <div class="g-2">
            <div class="content">
                <h2 class="text-center">คำนวณสูตรอาหาร</h2>
            <div class="main">
                <?php include('../weatherAPI.php'); ?>
                <h4 class="h4">คำนวณสูตรอาหาร</h4>
                <div class="feed-cow">
                    <form action="cal.php" method="post">
                        <h5>คำนวณโภชนะของโค</h5>
                        <!-- อุณหภูมิ -->
                        <div class="row">
                            <div class="col-6">
                                <label for="">อุณหภูมิ (องศาเซลเซียส)</label>
                                <br><input type="number" class="form-control" placeholder="อุณหภูมิ" aria-label="tem"
                                    aria-describedby="basic-addon1" name="tem"><br>

                            </div>
                            <div class="col-6">
                                <label for="">ความชื้น (%)</label>
                                <br><input type="number" class="form-control" placeholder="ความชื้น" aria-label="tem"
                                    aria-describedby="basic-addon1" name="rh"><br>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <label for="">เลือกโค</label><br>
                                <div class="input-group">
                                    <select class="form-select" id="inputGroupSelect04"
                                        aria-label="Example select with button addon" name="cow_select">
                                        <option value="">เลือกโค</option>
                                        <?php
                                        $acc_id = $_SESSION['acc_id'];
                                        $sql = "SELECT * FROM cow WHERE acc_id = $acc_id";
                                        $result = $conn->query($sql);
                                        while ($raw = $result->fetch_assoc()):
                                            ?>
                                                <option value="<?php echo $raw["cow_id"]; ?>">
                                                    <?php echo $raw["cow_id"]; ?>
                                                    <?php echo $raw["cow_name"]; ?>
                                                </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div id="gender"></div>
                            </div>
                            <div class="col-3">
                                <div id="age"></div>
                            </div>
                            <div class="col-3">
                                <div id="gen"></div>
                            </div>
                        </div>


                        <script>
                        document.getElementById("inputGroupSelect04").addEventListener("change", function() {
                        var selectedCow = this.value;
                        var genderContainer = document.getElementById("gender");
                        var ageContainer = document.getElementById("age");
                        var genContainer = document.getElementById("gen");

                        genderContainer.innerHTML = "";
                        ageContainer.innerHTML = "";
                        genContainer.innerHTML = "";

                        if (selectedCow !== "") {
                            fetchCowData(selectedCow, genderContainer, ageContainer, genContainer);
                            const age = calculateAge(selectedCow);
                            const gen = calculateGen(age);
                            
                            // เรียกใช้ฟังก์ชันสำหรับส่งค่าไปยัง PHP
                            sendDataToPHP(selectedCow,  gen);
                        }
                        function sendDataToPHP(selectedCow,  gen) {
                            const dataToSend = {
                                cow: selectedCow,
                                gen: gen

                               
                            };
                            
                            console.log(JSON.stringify(dataToSend));

                            fetch('cal.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json;charset=UTF-8'
                                },
                                body: JSON.stringify(dataToSend)
                            })
                            .then(response => response.json())
                            .then(data => {
                                // คุณสามารถทำอะไรก็ได้กับการตอบกลับที่ได้รับจาก PHP ได้ที่นี่
                                console.log(data);
                            })
                            .catch(error => {
                                // console.error('เกิดข้อผิดพลาด', error);
                            });
                        }
                    });

                    

                        // ---------------------------------------------------------------------------------------
                        // Calculate the age and generation
                       
                        
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

                        function calculateAge(birthdate) {
                            const birthDate = new Date(birthdate);
                            const today = new Date();

                            const years = today.getFullYear() - birthDate.getFullYear();
                            const months = today.getMonth() - birthDate.getMonth();
                            const days = today.getDate() - birthDate.getDate();

                            if (months < 0 || (months === 0 && days < 0)) {
                                years--;
                                months += 12;
                                if (days < 0) {
                                    const lastDayOfPreviousMonth = new Date(today.getFullYear(), today.getMonth(),
                                        0).getDate();
                                    days += lastDayOfPreviousMonth;
                                    months--;

                                }
                            }

                            return {
                                years: years,
                                months: months,
                                days: days
                            };
                        }

                        

                        function fetchCowData(selectedCow, genderContainer, ageContainer, genContainer) {
                        fetch(`fetch_cow_gender.php?selectedCow=${encodeURIComponent(selectedCow)}`)
                            .then(response => response.json())
                            .then(data => {
                                // Data is available here
                                const cow_genders = Array.isArray(data.cow_gender) ? data.cow_gender : [data.cow_gender];
                                const cow_bdays = Array.isArray(data.cow_bday) ? data.cow_bday : [data.cow_bday];

                                if (cow_genders.length > 0) {
                                cow_genders.forEach(gender => {
                                    const genderInput = createInputField("inputGender", "เพศโค", gender);
                                    genderContainer.appendChild(genderInput);
                                });
                            }

                            if (cow_bdays.length > 0) {
                                cow_bdays.forEach(birthdate => {
                                    const age = calculateAge(birthdate);
                                    const ageInput = createInputField("inputAge", "อายุ", `${Math.abs(age.years)} ปี ${Math.abs(age.months)} เดือน ${Math.abs(age.days)} วัน`);
                                    ageContainer.appendChild(ageInput);

                                    const gen = calculateGen(age);
                                    const genInput = createInputField("inputGen", "รุ่นโค", gen);
                                    genContainer.appendChild(genInput);

                                    
                                    // คุณสามารถเพิ่มโค้ดที่จะส่งข้อมูลไปยัง PHP script ที่คุณต้องการที่นี่
                                    // เช่นเรียกใช้ฟังก์ชันที่ทำการส่งข้อมูลโครูปอื่น ๆ ตามที่คุณต้องการ
                                });
                            }

                            })
                            .catch(error => {
                                // Handle errors
                                // console.error(error);
                            });
                    }

                        function calculateGen(age) {
                            let gen = "ไม่พบรุ่น";

                            if (age.days >= 1 && age.days <= 5 && age.months < 1) {
                                gen = 1 + " " + "ลูกโคแรกคลอดถึงอายุ 5 วัน";
                            } else if (age.days >= 6 && age.months >= 1 && age.months <= 2 && age.years < 1) {
                                gen = 2 + " " + "ลูกโคอายุ 6 วันถึง 2 เดือน";
                            } else if (age.months >= 3 && age.months <= 4 && age.years < 1) {
                                gen = 3 + " " + "ลูกโคอายุ 3 ถึง 4 เดือน";
                            } else if (age.months >= 5 && age.months <= 8 && age.years < 1) {
                                gen = 4 + " " + "โคอายุ 5 ถึง 8 เดือน";
                            } else if (age.months >= 9 && age.years <= 1 || age.months <= 3) {
                                gen = 5 + " " + " โคอายุ 9 ถึง 15 เดือน";
                            } else if (age.months >= 2 && age.years >= 1) {
                                gen = 6 + " " + "โคอายุ 15 เดือน ถึงโคอุ้มท้องแรก ระยะก่อนคลอด";
                            }

                            return "รุ่นที่" + gen;
                            // ... (previous code)

                            // Calculate the age and generation
                            
                            

                            // Create a JavaScript object to store the data
                        }
                        </script>
                        
                           

                        <!-- ตั้งท้อง -------------------------------------------------------------------------------------->
                        <div class="row">
                            <div class="col-6">
                                <br>
                                <label for="">สถานะการตั้งท้อง</label>
                                <div class="input-group">
                                    <select id="selectPregnant" class="form-control" aria -
                                        label="Example select with button addon" name="selectPregnant">
                                        <option value="เลือกสถานะการตั้งท้อง">เลือกสถานะการตั้งท้อง</option>
                                        <option value="อยู่ในช่วงตั้งท้อง">อยู่ในช่วงตั้งท้อง</option>
                                        <option value="ไม่ได้อยู่ในช่วงตั้งท้อง">ไม่ได้อยู่ในช่วงตั้งท้อง</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div id="detail-Pregnant">
                                </div>
                            </div>
                        </div>

                        <script>
                        document.getElementById("selectPregnant").addEventListener("change", function() {
                            var selectPregnantValue = this.value;
                            var detailPregnant = document.getElementById("detail-Pregnant");

                            // Clear any previously added input fields
                            detailPregnant.innerHTML = "";

                            if (selectPregnantValue === "อยู่ในช่วงตั้งท้อง") {
                                // Code for "Option 2" input fields
                                var formRowPregnant2 = document.createElement("div");
                                formRowPregnant2.className = "row";

                                // Create the first column for the first input
                                var colPregnant7 = document.createElement("div");
                                colPregnant7.className = "col-12";

                                // Create the label for the first input
                                var labelPregnant7 = document.createElement("label");
                                labelPregnant7.textContent = "อายุครรภ์";

                                // Create the first input field
                                var inputPregnant7 = document.createElement("input");
                                inputPregnant7.type = "number";
                                inputPregnant7.placeholder = "(วัน)";
                                inputPregnant7.className = "form-control";
                                inputPregnant7.name = "Pregnantday";

                                // Append the label and input to the first column
                                colPregnant7.appendChild(labelPregnant7);
                                colPregnant7.appendChild(inputPregnant7);

                                // Append the column to the form row
                                formRowPregnant2.appendChild(colPregnant7);

                                // Append the form row to the inputContainer
                                detailPregnant.appendChild(document.createElement("br"));
                                detailPregnant.appendChild(formRowPregnant2);



                            } else if (selectPregnantValue === "ไม่ได้อยู่ในช่วงตั้งท้อง") {

                                // ... Append other columns to the form row for "Option 2"
                            }
                        });
                        </script>


                        <div class="row">
                            <div class="col-6">
                                <br>
                                <label for=""> สถานะการรีดนม </label><br>
                                <div class="input-group">
                                    <select class="form-control" id="selectmilk" aria -
                                        label="Example select with button addon" name="selectmilk">

                                        <option value="option0" name="selectmilk"> เลือกช่วงการให้นม
                                        </option>
                                        <option value="อยู่ในช่วงรีดนม" name="selectmilk"> อยู่ในช่วงรีดนม
                                        </option>
                                        <option value="ไม่ได้อยู่ในช่วงรีดนม" name="selectmilk">
                                            ไม่ได้อยู่ในช่วงรีดนม
                                        </option>
                                        <option value="อยู่ในช่วงพักรีดนม" name="selectmilk">
                                            อยู่ในช่วงพักรีดนม
                                        </option>
                                    </select>


                                </div>
                            </div>

                            <div id="inputContainer">
                            </div>

                        </div>


                        <script>
                        var selectPregnant = document.getElementById("selectPregnant");
                        var selectmilk = document.getElementById("selectmilk");

                        // Enable or disable options based on gender
                        selectPregnant.addEventListener("change", function() {
                            var selectPregnant = this.value;

                            // Initially, enable all options
                            for (var i = 0; i < selectmilk.options.length; i++) {
                                selectmilk.options[i].disabled = false;
                            }

                            // If male is selected, disable certain options
                            if (selectPregnant === "ไม่ได้อยู่ในช่วงตั้งท้อง") {
                                selectmilk.querySelector('option[value="อยู่ในช่วงรีดนม"]').disabled = true;
                                selectmilk.querySelector('option[value="อยู่ในช่วงพักรีดนม"]').disabled = true;
                            } else if (selectPregnant === "อยู่ในช่วงตั้งท้อง") {
                                selectmilk.querySelector('option[value="ไม่ได้อยู่ในช่วงรีดนม"]').disabled =
                                    true;

                            }
                        });
                        </script>
                        <script>
                        document.getElementById("selectmilk").addEventListener("change", function() {
                            var selectValue = this.value;
                            var inputContainer = document.getElementById("inputContainer");

                            // Clear any previously added input fields
                            inputContainer.innerHTML = "";

                            if (selectValue === "อยู่ในช่วงรีดนม") {
                                var formRow0 = document.createElement("div");
                                formRow0.className = "row";

                                //-----------------------------------------------------------------------------------
                                // Create the first column for the first input
                                var col0 = document.createElement("div");
                                col0.className = "col-6";

                                // Create the label for the first input
                                var label0 = document.createElement("label");
                                label0.textContent = "วันให้นม (วัน)";

                                // Create the first input field
                                var input0 = document.createElement("input");
                                input0.type = "number";
                                input0.placeholder = "วัน";
                                input0.className = "form-control";
                                input0.name = "milkday";

                                // Append the label and input to the first column
                                col0.appendChild(label0);
                                col0.appendChild(input0);

                                //-----------------------------------------------------------------------------------
                                var formRow1 = document.createElement("div");
                                formRow1.className = "row";

                                //-----------------------------------------------------------------------------------
                                // Create the first column for the first input
                                var col1 = document.createElement("div");
                                col1.className = "col-4";

                                // Create the label for the first input
                                var label1 = document.createElement("label");
                                label1.textContent = "น้ำหนัก ณ ปัจจุบัน (กก.)";

                                // Create the first input field
                                var input1 = document.createElement("input");
                                input1.type = "number";
                                input1.placeholder = "หน่วยกิโลกรัม";
                                input1.className = "form-control";
                                input1.name = "bw";

                                // Append the label and input to the first column
                                col1.appendChild(label1);
                                col1.appendChild(input1);

                                //-----------------------------------------------------------------------------------
                                // Create the second column for the second input
                                var col2 = document.createElement("div");
                                col2.className = "col-4";

                                // Create the label for the second input
                                var label2 = document.createElement("label");
                                label2.textContent = "ความต้องการการเติบโตเฉลี่ย (กก./วัน)";

                                // Create the second input field
                                var input2 = document.createElement("input");
                                input2.type = "number";
                                input2.placeholder = "หน่วยกิโลกรัมต่อวัน";
                                input2.className = "form-control";
                                input2.name = "adg";

                                // Append the label and input to the second column
                                col2.appendChild(label2);
                                col2.appendChild(input2);

                                //-----------------------------------------------------------------------------------
                                // Create the third column for the third input
                                var col3 = document.createElement("div");
                                col3.className = "col-4";

                                // Create the label for the third input
                                var label3 = document.createElement("label");
                                label3.textContent = "ปริมาณน้ำนม (กก./วัน)";

                                // Create the third input field
                                var input3 = document.createElement("input");
                                input3.type = "number";
                                input3.placeholder = "หน่วยกิโลกรัมต่อวัน";
                                input3.className = "form-control";
                                input3.name = "totalmilk";

                                // Append the label and input to the third column
                                col3.appendChild(label3);
                                col3.appendChild(input3);

                                //-----------------------------------------------------------------------------------
                                // Create another form row
                                var formRow2 = document.createElement("div");
                                formRow2.className = "row";

                                //-----------------------------------------------------------------------------------
                                var col4 = document.createElement("div");
                                col4.className = "col-4";

                                // Create the label for the third input
                                var label4 = document.createElement("label");
                                label4.textContent = "ไขมันนม (%)";

                                // Create the third input field
                                var input4 = document.createElement("input");
                                input4.type = "number";
                                input4.placeholder = "หน่วย %";
                                input4.className = "form-control";
                                input4.name = "fatmilk";

                                // Append the label and input to the third column
                                col4.appendChild(label4);
                                col4.appendChild(input4);

                                //-----------------------------------------------------------------------------------
                                var col5 = document.createElement("div");
                                col5.className = "col-4";

                                // Create the label for the third input
                                var label5 = document.createElement("label");
                                label5.textContent = "โปรตีนนม (%)";

                                // Create the third input field
                                var input5 = document.createElement("input");
                                input5.type = "number";
                                input5.placeholder = "หน่วย %";
                                input5.className = "form-control";
                                input5.name = "proteinmilk";

                                // Append the label and input to the third column
                                col5.appendChild(label5);
                                col5.appendChild(input5);

                                //-----------------------------------------------------------------------------------
                                var col6 = document.createElement("div");
                                col6.className = "col-4";

                                // Create the label for the third input
                                var label6 = document.createElement("label");
                                label6.textContent = "ความต้องการเพิ่มหรือลดน้ำหนัก (กิโลกรัม/วัน)";

                                // Create the third input field
                                var input6 = document.createElement("input");
                                input6.type = "number";
                                input6.placeholder = "หน่วยกิโลกรัมต่อวัน";
                                input6.className = "form-control";
                                input6.name = "bws";

                                // Append the label and input to the third column
                                col6.appendChild(label6);
                                col6.appendChild(input6);

                                //-----------------------------------------------------------------------------------
                                // Append the columns to the form rows
                                formRow0.appendChild(col0);
                                formRow0.appendChild(col1);
                                formRow1.appendChild(col1);
                                formRow1.appendChild(col2);
                                formRow1.appendChild(col3);
                                formRow2.appendChild(col4);
                                formRow2.appendChild(col5);
                                formRow2.appendChild(col6);

                                //-----------------------------------------------------------------------------------
                                // Append the form rows to the inputContainer
                                inputContainer.appendChild(document.createElement("br"));
                                inputContainer.appendChild(formRow0);
                                inputContainer.appendChild(document.createElement("br"));
                                inputContainer.appendChild(formRow1);
                                inputContainer.appendChild(document.createElement("br"));
                                inputContainer.appendChild(formRow2);
                                inputContainer.appendChild(document.createElement("br"));

                            } else if (selectValue === "อยู่ในช่วงพักรีดนม") {
                                // Code for "Option 2" input fields
                                var formRow2 = document.createElement("div");
                                formRow2.className = "row";

                                //-----------------------------------------------------------------------------------
                                // Create the first column for the first input
                                var col7 = document.createElement("div");
                                col7.className = "col-6";

                                // Create the label for the first input
                                var label7 = document.createElement("label");
                                label7.textContent = "น้ำหนัก ณ ปัจจุบัน (กก.)";

                                // Create the first input field
                                var input7 = document.createElement("input");
                                input7.type = "number";
                                input7.placeholder = "หน่วยกิโลกรัม";
                                input7.className = "form-control";
                                input7.name = "bw";

                                // Append the label and input to the first column
                                col7.appendChild(label7);
                                col7.appendChild(input7);

                                //-----------------------------------------------------------------------------------
                                // Create the second column for the second input
                                var col8 = document.createElement("div");
                                col8.className = "col-6";

                                // Create the label for the second input
                                var label8 = document.createElement("label");
                                label8.textContent = "ความต้องการการเติบโตเฉลี่ย (กก./วัน)";

                                // Create the second input field
                                var input8 = document.createElement("input");
                                input8.type = "text";
                                input8.placeholder = "หน่วยกิโลกรัมต่อวัน";
                                input8.className = "form-control";
                                input8.name = "adg";

                                // Append the label and input to the second column
                                col8.appendChild(label8);
                                col8.appendChild(input8);



                                //-----------------------------------------------------------------------------------
                                // Append the columns to the form row
                                formRow2.appendChild(col7);
                                formRow2.appendChild(col8);
                                // ... Append other columns to the form row

                                //-----------------------------------------------------------------------------------
                                // Append the form row to the inputContainer
                                inputContainer.appendChild(document.createElement("br"));
                                inputContainer.appendChild(formRow2);
                                inputContainer.appendChild(document.createElement("br"));


                            } else if (selectValue === "ไม่ได้อยู่ในช่วงรีดนม") {
                                // Code for "Option 2" input fields
                                var formRow2 = document.createElement("div");
                                formRow2.className = "row";

                                //-----------------------------------------------------------------------------------
                                // Create the first column for the first input
                                var col7 = document.createElement("div");
                                col7.className = "col-6";

                                // Create the label for the first input
                                var label7 = document.createElement("label");
                                label7.textContent = "น้ำหนัก ณ ปัจจุบัน (กก.)";

                                // Create the first input field
                                var input7 = document.createElement("input");
                                input7.type = "text";
                                input7.placeholder = "หน่วยกิโลกรัม";
                                input7.className = "form-control";
                                input7.name = "bw";

                                // Append the label and input to the first column
                                col7.appendChild(label7);
                                col7.appendChild(input7);

                                //-----------------------------------------------------------------------------------
                                // Create the second column for the second input
                                var col8 = document.createElement("div");
                                col8.className = "col-6";

                                // Create the label for the second input
                                var label8 = document.createElement("label");
                                label8.textContent = "ความต้องการการเติบโตเฉลี่ย (กก./วัน)";

                                // Create the second input field
                                var input8 = document.createElement("input");
                                input8.type = "text";
                                input8.placeholder = "หน่วยกิโลกรัมต่อวัน";
                                input8.className = "form-control";
                                input8.name = "adg";

                                // Append the label and input to the second column
                                col8.appendChild(label8);
                                col8.appendChild(input8);

                                // ... Create other input fields similarly

                                // Append the columns to the form row
                                formRow2.appendChild(col7);
                                formRow2.appendChild(col8);
                                // ... Append other columns to the form row

                                // Append the form row to the inputContainer
                                inputContainer.appendChild(document.createElement("br"));
                                inputContainer.appendChild(formRow2);
                                inputContainer.appendChild(document.createElement("br"));


                            }
                        });
                        </script>
                        <br>
                        <div class="addcal">
                            <button type="submit" name="calcow" class="btn">คำนวณ</button>
                        </div>
                </div>
                </form>
            </div>
            <!--------------------------------------------------------------------------------------------------->
            <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $cid = $_POST['cow_select'];
                $adg = $_POST['adg'];
                $tem = $_POST['tem'];
                $rh = $_POST['rh'];
                $wg = $_POST['bw'];
                $mui = mysqli_query($conn, "select * from cow WHERE acc_id = $acc_id and cow_id = $cid");
                $mtc = mysqli_fetch_assoc($mui);
                $gender = $mtc['cow_gender'];
                $Pregnant = $_POST['selectPregnant'];
                // กรณีวันเกิดที่เ็ก็บอยู่ในรูปแบบของ date แบบมาตรฐาน คือ ปี ค.ศ.- เดือน - วันที่
                // ฟังก์ชันคำนวณหาอายุใช้ดังนี้
                $dateOfBirth = date("d-m-Y", strtotime($mtc['cow_bday'])); //วันเกิด รูปแบบ ปี เดือน วัน
                $currentDate = date('d-m-Y'); //วันที่ปัจจุบัน
                $diff = abs(strtotime($currentDate) - strtotime($dateOfBirth));
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));


                // --------------------------------------------------------------------------------------------------
                $genr = mysqli_query($conn, "select * from cow_gen");
                $y = 0; // เริ่มต้นด้วยรุ่นที่ 0
            
                if ($days >= 1 && $days <= 5 && $months < 1) {
                    $y = 1;
                } else if ($days >= 6 && $months >= 1 && $months <= 2 && $years < 1) {
                    $y = 2;
                } else if ($months >= 3 && $months <= 4 && $years < 1) {
                    $y = 3;
                } else if ($months >= 5 && $months <= 8 && $years < 1) {
                    $y = 4;
                } else if ($months >= 9 && $years <= 1 || $months >= 0) {
                    $y = 5;
                } else if ($months >= 2 && $years >= 1) {
                    $y = 6;
                }

                while ($c = mysqli_fetch_assoc($genr)) {
                    if ($c["cow_gen_id"] == $y) {
                        break; // หากเจอรุ่นที่ตรงกันให้ออกจากลูป
                    }
                }


                // ---------------------------------------------------------------------------------------------------
                // หาค่า thi
                $THI = (1.8 * $tem + 32) - (0.55 - 0.0055 * $rh) * (1.8 * $tem - 26);

                // ---------------------------------------------------------------------------------------------------
                // หาค่าการกินได้ $DMI
                $DMIm = (0.105 * pow($wg, 0.75)); // โคทั่วไป
                $DMIg = (0.108 * pow($wg, 0.75)); // โคสาว,โคพักรีด
                $DMIl = (0.108 * pow($wg, 0.75)); // โคให้นม
                // ---------------------------------------------------------------------------------------------------
                // หาค่า ME
                $MEm = (123 / 1000 * pow($wg, 0.75)); //เพื่อการดำรงชีวิต
                $MEa = ($MEm * 5) / 100; // ค่า me เพื่อการเดิน
                $MEhl = ($MEm * 5) / 100; // ค่า me เพื่อลดความเครียดจากความร้อนต่ำ
                $MEhm = ($MEm * 10) / 100; // ค่า me เพื่อลดความเครียดจากความร้อนกลาง
                $MEhh = ($MEm * 15) / 100; // ค่า me เพื่อลดความเครียดจากความร้อนสูง
                $MEtotal_low = $MEm + $MEa + $MEhl;
                $MEtotal_mid = $MEm + $MEa + $MEhm;
                $MEtotal_high = $MEm + $MEa + $MEhh;
                $MEtotal = $MEm + $MEa;
                // ---------------------------------------------------------------------------------------------------
                // ค่า NE
                $NEm = (85 / 1000 * pow($wg, 0.75));
                // ---------------------------------------------------------------------------------------------------
                // ค่า MP
                $MPm = (2.45375 * pow($wg, 0.75));
                $MPg = 3.6774 + (0.2568 * $adg);
                $MPtotal2 = $MPm + $MPg;
                // ---------------------------------------------------------------------------------------------------
                // ค่าวิตามิน
            
                // ---------------------------------------------------------------------------------------------------
                // ค่าแร่ธาตุ
                // ---------------------------------------------------------------------------------------------------
                // ค่าเยื่อใย
                $NDF = 33;
                $ADF = 21;
                $NFC = 43;

                // -----------------------------------------------------------------------------------------------------
                if ($Pregnant == "อยู่ในช่วงตั้งท้อง" && $gender == "เพศเมีย") {
                    $Pregnantday = $_POST['Pregnantday'];
                    $milk = $_POST['selectmilk'];
                    // ------------------------------------------------------------------------------------------------
                    if ($milk == "อยู่ในช่วงรีดนม") {
                        $milkday = $_POST['milkday'];
                        $fatmilk = $_POST['fatmilk'];
                        $proteinmilk = $_POST['proteinmilk'];
                        $totalmilk = $_POST['totalmilk'];
                        $bws = $_POST['bws'];
                        // --------------------------------------------------------------------------------------------
                        // MP
                        $TPY = $totalmilk * ($proteinmilk / 100);
                        $MPl = ($TPY * 1000) / 0.426;
                        $MPtotal1 = $MPm + $MPl;
                        // ---------------------------------------------------------------------------------------------
                        // RDP,RUP
                        $RDPl = ($MPl * 64.13 / 100) * (0.6375 * 0.95);
                        $RUPl = ($MPl * 35.87 / 100) / 0.85;
                        // ---------------------------------------------------------------------------------------------
                        // CP
                        $CPl = $RDPl + $RUPl;
                        $PER_CPl = $CPl * 100;
                        // ---------------------------------------------------------------------------------------------
                        $TDN = 0;
                        $NEL = 0;
                        $ME = 0;
                        $DE = 0;


                        // ---------------------------------------------------------------------------------------------
                        //เครียดสูง
                        if ($THI > 90) {
                            // การกินได้ของโครีดนม
                            $DMIs = $DMIl * (1 - (($tem - 20) * 0.005922));
                            ?>
                            <div class="box-edible">
                            <div class="row">
                                  <h5>ข้อมูลโค</h5>
                                <div class="col-6">
                                    <div class="edible">
                                        <div class="tpic-edible">
                                            <p>ข้อมูลทั่วไป</p>
                                        </div>
                                        <div class="content-edible">
                                            <p> <?php echo "หมายเลขประจำตัวโค : " . $mtc['cow_id'], " ", "ชื่อ", " " . $mtc['cow_name'], '<br>'; ?></p>
                                            <p><?php echo "เพศ : " . $mtc['cow_gender'], '<br>'; ?></p>
                                            <p><?php echo 'อายุ : ';
                                            printf("%d ปี %d เดือน %d วัน\n", $years, $months, $days);
                                            '<br>'; ?></p>
                                            
                                            <p><?php echo ' รุ่น : ' . $c["name_gen"]; ?></p>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="edible">
                                    <div class="tpic-edible">
                                            <p>ข้อมูลอื่นๆ</p>
                                        </div>
                                        <div class="content-edible">
                                            <p>สถานะการรีดนม : <?php echo " " . $milk, '<br>'; ?></p>
                                            <p>วันให้นม :<?php echo " " . $milkday, '<br>'; ?></p>
                                            <p>สถานะการตั้งท้อง :<?php echo " " . $Pregnant, '<br>'; ?></p>
                                            <p>วันท้อง :<?php echo " " . $Pregnantday, '<br>'; ?></p>
                                            <p>ค่า THI : <?php
                                            if ($THI < 72) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะปกติ";
                                            } else if ($THI > 72 && $THI < 79) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดเล็กน้อย";
                                            } else if ($THI > 79 && $THI < 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดปานกลาง";
                                            } else if ($THI > 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดสูง";
                                            } ?></p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <h5>ข้อมูลความต้องการโภชนะของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">BW</th>
                                                <th scope="col">Milk</th>
                                                <th scope="col">Fat</th>
                                                <th scope="col">Protien</th>
                                                <th scope="col">BW C</th>
                                                <th scope="col">Intake</th>
                                                <th scope="col">NEL</th>
                                                <th scope="col">ME</th>
                                                <th scope="col">DE</th>
                                                <th scope="col">TDN</th>
                                                <th scope="col">MP</th>
                                                <th scope="col">RDP</th>
                                                <th scope="col">RUP</th>
                                                <th scope="col">CP</th>
                                                <th scope="col">CP</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(%)</th>
                                                <th scope="col">(%)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                                <td><?php echo number_format($wg, 0, '.', '') ?></td>
                                                <td><?php echo number_format($totalmilk, 0, '.', '') ?></td>
                                                <td><?php echo number_format($fatmilk, 1, '.', '') ?></td>
                                                <td><?php echo number_format($proteinmilk, 1, '.', '') ?></td>
                                                <td><?php echo number_format($bws, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DMIs, 1, '.', '') ?></td>
                                                <td><?php echo number_format($NEL, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MEtotal_high, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DE, 1, '.', '') ?></td>
                                                <td><?php echo number_format($TDN, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MPtotal1, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RDPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RUPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($CPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($PER_CPl / $DMIs, 1, '.', '') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการวิตามินและค่าเยื่อใยของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="6">วิตามิน</th>
                                                <th colspan="3">เยื่อใย</th>
                                            </tr>
                                            
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">NDF</th>
                                                <th scope="col">ADF</th>
                                                <th scope="col">NFC</th>
                                                
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="3">(IU/Day)</th>
                                                <th colspan="3">(IU/Kg)</th>
                                                <th colspan="3">(>%)</th>
                                               

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($months >= 6 && $months <= 11 && $years < 1) {
                                            echo "

                                <tr style='text-align:center; background-color:#fff;'>
                                    <td>16,000</td>
                                    <td>3,076</td>
                                    <td>6,000</td>
                                    <td>1,154</td>
                                    <td>160</td>
                                    <td>31</td>
                                    <td>$NDF</td>
                                    <td>$ADF</td>
                                    <td>$NFC</td>
                                </tr>
                            ";
                                        } else if ($months >= 12 && $years = 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>24,000</td>
                                        <td>3,380</td>
                                        <td>9,000</td>
                                        <td>1,268</td>
                                        <td>240</td>
                                        <td>34</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        } else if ($months >= 6 && $years >= 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>36,000</td>
                                        <td>3,185</td>
                                        <td>13,500</td>
                                        <td>1,195</td>
                                        <td>360</td>
                                        <td>32</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการค่าแร่ธาตุของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">Ca</th>
                                                <th scope="col">P</th>
                                                <th scope="col">Mg</th>
                                                <th scope="col">Cl</th>
                                                <th scope="col">K</th>
                                                <th scope="col">Na</th>
                                                <th scope="col">S</th>
                                                <th scope="col">Co</th>
                                                <th scope="col">Cu</th>
                                                <th scope="col">I</th>
                                                <th scope="col">Fe</th>
                                                <th scope="col">Mn</th>
                                                <th scope="col">Se</th>
                                                <th scope="col">Zn</th>
                                                <th scope="col">CP</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="15">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                                <td><?php echo number_format($wg, 0, '.', '') ?></td>
                                                <td><?php echo number_format($totalmilk, 0, '.', '') ?></td>
                                                <td><?php echo number_format($fatmilk, 1, '.', '') ?></td>
                                                <td><?php echo number_format($proteinmilk, 1, '.', '') ?></td>
                                                <td><?php echo number_format($bws, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DMIs, 1, '.', '') ?></td>
                                                <td><?php echo number_format($NEL, 1, '.', '') ?></td>
                                                <td><?php echo number_format($ME, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DE, 1, '.', '') ?></td>
                                                <td><?php echo number_format($TDN, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MPtotal1, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RDPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RUPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($CPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($PER_CPl / $DMIs, 1, '.', '') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>


            <?php
                            // -----------------------------------------------------------------------------------------
                            // เครียดกลาง
                        } else if ($THI > 79 && $THI < 90) {
                            $DMIns = $DMIl * (1 - (($tem - 20) * 0.005922));
                            ?>
                          <div class="box-edible">
                            <div class="row">
                                  <h5>ข้อมูลโค</h5>
                                <div class="col-6">
                                    <div class="edible">
                                        <div class="tpic-edible">
                                            <p>ข้อมูลทั่วไป</p>
                                        </div>
                                        <div class="content-edible">
                                            <p> <?php echo "หมายเลขประจำตัวโค : " . $mtc['cow_id'], " ", "ชื่อ", " " . $mtc['cow_name'], '<br>'; ?></p>
                                            <p><?php echo "เพศ : " . $mtc['cow_gender'], '<br>'; ?></p>
                                            <p><?php echo 'อายุ : ';
                                            printf("%d ปี %d เดือน %d วัน\n", $years, $months, $days);
                                            '<br>'; ?></p>
                                            
                                            <p><?php echo ' รุ่น : ' . $c["name_gen"]; ?></p>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="edible">
                                    <div class="tpic-edible">
                                            <p>ข้อมูลอื่นๆ</p>
                                        </div>
                                        <div class="content-edible">
                                            <p>สถานะการรีดนม : <?php echo " " . $milk, '<br>'; ?></p>
                                            <p>วันให้นม :<?php echo " " . $milkday, '<br>'; ?></p>
                                            <p>สถานะการตั้งท้อง :<?php echo " " . $Pregnant, '<br>'; ?></p>
                                            <p>วันท้อง :<?php echo " " . $Pregnantday, '<br>'; ?></p>
                                            <p>ค่า THI : <?php
                                            if ($THI < 72) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะปกติ";
                                            } else if ($THI > 72 && $THI < 79) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดเล็กน้อย";
                                            } else if ($THI > 79 && $THI < 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดปานกลาง";
                                            } else if ($THI > 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดสูง";
                                            } ?></p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <h5>ข้อมูลความต้องการโภชนะของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">BW</th>
                                                <th scope="col">Milk</th>
                                                <th scope="col">Fat</th>
                                                <th scope="col">Protien</th>
                                                <th scope="col">BW C</th>
                                                <th scope="col">Intake</th>
                                                <th scope="col">NEL</th>
                                                <th scope="col">ME</th>
                                                <th scope="col">DE</th>
                                                <th scope="col">TDN</th>
                                                <th scope="col">MP</th>
                                                <th scope="col">RDP</th>
                                                <th scope="col">RUP</th>
                                                <th scope="col">CP</th>
                                                <th scope="col">CP</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(%)</th>
                                                <th scope="col">(%)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                                <td><?php echo number_format($wg, 0, '.', '') ?></td>
                                                <td><?php echo number_format($totalmilk, 0, '.', '') ?></td>
                                                <td><?php echo number_format($fatmilk, 1, '.', '') ?></td>
                                                <td><?php echo number_format($proteinmilk, 1, '.', '') ?></td>
                                                <td><?php echo number_format($bws, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DMIns, 1, '.', '') ?></td>
                                                <td><?php echo number_format($NEL, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MEtotal_mid, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DE, 1, '.', '') ?></td>
                                                <td><?php echo number_format($TDN, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MPtotal1, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RDPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RUPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($CPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($PER_CPl / $DMIns, 1, '.', '') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการวิตามินและค่าเยื่อใยของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="6">วิตามิน</th>
                                                <th colspan="3">เยื่อใย</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">NDF</th>
                                                <th scope="col">ADF</th>
                                                <th scope="col">NFC</th>
                                                
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="3">(IU/Day)</th>
                                                <th colspan="3">(IU/Kg)</th>
                                                <th colspan="3">(>%)</th>
                                               

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($months >= 6 && $months <= 11 && $years < 1) {
                                            echo "

                                <tr style='text-align:center; background-color:#fff;'>
                                    <td>16,000</td>
                                    <td>3,076</td>
                                    <td>6,000</td>
                                    <td>1,154</td>
                                    <td>160</td>
                                    <td>31</td>
                                    <td>$NDF</td>
                                    <td>$ADF</td>
                                    <td>$NFC</td>
                                </tr>
                            ";
                                        } else if ($months >= 12 && $years = 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>24,000</td>
                                        <td>3,380</td>
                                        <td>9,000</td>
                                        <td>1,268</td>
                                        <td>240</td>
                                        <td>34</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        } else if ($months >= 6 && $years >= 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>36,000</td>
                                        <td>3,185</td>
                                        <td>13,500</td>
                                        <td>1,195</td>
                                        <td>360</td>
                                        <td>32</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการค่าแร่ธาตุของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">Ca</th>
                                                <th scope="col">P</th>
                                                <th scope="col">Mg</th>
                                                <th scope="col">Cl</th>
                                                <th scope="col">K</th>
                                                <th scope="col">Na</th>
                                                <th scope="col">S</th>
                                                <th scope="col">Co</th>
                                                <th scope="col">Cu</th>
                                                <th scope="col">I</th>
                                                <th scope="col">Fe</th>
                                                <th scope="col">Mn</th>
                                                <th scope="col">Se</th>
                                                <th scope="col">Zn</th>
                                               
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="15">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                                <td>0.62</td>
                                                <td>0.32</td>
                                                <td>0.18</td>
                                                <td>0.24</td>
                                                <td>1</td>
                                                <td>0.22</td>
                                                <td>0.2</td>
                                                <td>0.11</td>
                                                <td>11</td>
                                                <td>0.6</td>
                                                <td>12.3</td>
                                                <td>14</td>
                                                <td>0.3</td>
                                                <td>43</td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>



            <?php
                            // ----------------------------------------------------------------------------------------------
                            // เครียดต่ำ
                        } else if ($THI > 72 && $THI < 79) {
                            $DMIns = $DMIl * (1 - (($tem - 20) * 0.005922));
                            ?>
                          <div class="box-edible">
                            <div class="row">
                                  <h5>ข้อมูลโค</h5>
                                <div class="col-6">
                                    <div class="edible">
                                        <div class="tpic-edible">
                                            <p>ข้อมูลทั่วไป</p>
                                        </div>
                                        <div class="content-edible">
                                            <p> <?php echo "หมายเลขประจำตัวโค : " . $mtc['cow_id'], " ", "ชื่อ", " " . $mtc['cow_name'], '<br>'; ?></p>
                                            <p><?php echo "เพศ : " . $mtc['cow_gender'], '<br>'; ?></p>
                                            <p><?php echo 'อายุ : ';
                                            printf("%d ปี %d เดือน %d วัน\n", $years, $months, $days);
                                            '<br>'; ?></p>
                                            
                                            <p><?php echo ' รุ่น : ' . $c["name_gen"]; ?></p>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="edible">
                                    <div class="tpic-edible">
                                            <p>ข้อมูลอื่นๆ</p>
                                        </div>
                                        <div class="content-edible">
                                            <p>สถานะการรีดนม : <?php echo " " . $milk, '<br>'; ?></p>
                                            <p>วันให้นม :<?php echo " " . $milkday, '<br>'; ?></p>
                                            <p>สถานะการตั้งท้อง :<?php echo " " . $Pregnant, '<br>'; ?></p>
                                            <p>วันท้อง :<?php echo " " . $Pregnantday, '<br>'; ?></p>
                                            <p>ค่า THI : <?php
                                            if ($THI < 72) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะปกติ";
                                            } else if ($THI > 72 && $THI < 79) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดเล็กน้อย";
                                            } else if ($THI > 79 && $THI < 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดปานกลาง";
                                            } else if ($THI > 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดสูง";
                                            } ?></p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <h5>ข้อมูลความต้องการโภชนะของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">BW</th>
                                                <th scope="col">Milk</th>
                                                <th scope="col">Fat</th>
                                                <th scope="col">Protien</th>
                                                <th scope="col">BW C</th>
                                                <th scope="col">Intake</th>
                                                <th scope="col">NEL</th>
                                                <th scope="col">ME</th>
                                                <th scope="col">DE</th>
                                                <th scope="col">TDN</th>
                                                <th scope="col">MP</th>
                                                <th scope="col">RDP</th>
                                                <th scope="col">RUP</th>
                                                <th scope="col">CP</th>
                                                <th scope="col">CP</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(%)</th>
                                                <th scope="col">(%)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                                <td><?php echo number_format($wg, 0, '.', '') ?></td>
                                                <td><?php echo number_format($totalmilk, 0, '.', '') ?></td>
                                                <td><?php echo number_format($fatmilk, 1, '.', '') ?></td>
                                                <td><?php echo number_format($proteinmilk, 1, '.', '') ?></td>
                                                <td><?php echo number_format($bws, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DMIns, 1, '.', '') ?></td>
                                                <td><?php echo number_format($NEL, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MEtotal_low, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DE, 1, '.', '') ?></td>
                                                <td><?php echo number_format($TDN, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MPtotal1, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RDPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RUPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($CPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($PER_CPl / $DMIns, 1, '.', '') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการวิตามินและค่าเยื่อใยของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="6">วิตามิน</th>
                                                <th colspan="3">เยื่อใย</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">NDF</th>
                                                <th scope="col">ADF</th>
                                                <th scope="col">NFC</th>
                                                
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="3">(IU/Day)</th>
                                                <th colspan="3">(IU/Kg)</th>
                                                <th colspan="3">(>%)</th>
                                               

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($months >= 6 && $months <= 11 && $years < 1) {
                                            echo "

                                <tr style='text-align:center; background-color:#fff;'>
                                    <td>16,000</td>
                                    <td>3,076</td>
                                    <td>6,000</td>
                                    <td>1,154</td>
                                    <td>160</td>
                                    <td>31</td>
                                    <td>$NDF</td>
                                    <td>$ADF</td>
                                    <td>$NFC</td>
                                </tr>
                            ";
                                        } else if ($months >= 12 && $years = 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>24,000</td>
                                        <td>3,380</td>
                                        <td>9,000</td>
                                        <td>1,268</td>
                                        <td>240</td>
                                        <td>34</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        } else if ($months >= 6 && $years >= 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>36,000</td>
                                        <td>3,185</td>
                                        <td>13,500</td>
                                        <td>1,195</td>
                                        <td>360</td>
                                        <td>32</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการค่าแร่ธาตุของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">Ca</th>
                                                <th scope="col">P</th>
                                                <th scope="col">Mg</th>
                                                <th scope="col">Cl</th>
                                                <th scope="col">K</th>
                                                <th scope="col">Na</th>
                                                <th scope="col">S</th>
                                                <th scope="col">Co</th>
                                                <th scope="col">Cu</th>
                                                <th scope="col">I</th>
                                                <th scope="col">Fe</th>
                                                <th scope="col">Mn</th>
                                                <th scope="col">Se</th>
                                                <th scope="col">Zn</th>
                                               
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="15">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                            <td>0.62</td>
                                                <td>0.32</td>
                                                <td>0.18</td>
                                                <td>0.24</td>
                                                <td>1</td>
                                                <td>0.22</td>
                                                <td>0.2</td>
                                                <td>0.11</td>
                                                <td>11</td>
                                                <td>0.6</td>
                                                <td>12.3</td>
                                                <td>14</td>
                                                <td>0.3</td>
                                                <td>43</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>


            <?php
                            // ----------------------------------------------------------------------------------------------
                            // ไม่เครียด
                        } else if ($THI < 72) {
                            $DMIns = $DMIl * (1 - ((5 - $tem) * 0.004644));
                            ?>
                          <div class="box-edible">
                            <div class="row">
                                  <h5>ข้อมูลโค</h5>
                                <div class="col-6">
                                    <div class="edible">
                                        <div class="tpic-edible">
                                            <p>ข้อมูลทั่วไป</p>
                                        </div>
                                        <div class="content-edible">
                                            <p> <?php echo "หมายเลขประจำตัวโค : " . $mtc['cow_id'], " ", "ชื่อ", " " . $mtc['cow_name'], '<br>'; ?></p>
                                            <p><?php echo "เพศ : " . $mtc['cow_gender'], '<br>'; ?></p>
                                            <p><?php echo 'อายุ : ';
                                            printf("%d ปี %d เดือน %d วัน\n", $years, $months, $days);
                                            '<br>'; ?></p>
                                            
                                            <p><?php echo ' รุ่น : ' . $c["name_gen"]; ?></p>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="edible">
                                    <div class="tpic-edible">
                                            <p>ข้อมูลอื่นๆ</p>
                                        </div>
                                        <div class="content-edible">
                                            <p>สถานะการรีดนม : <?php echo " " . $milk, '<br>'; ?></p>
                                            <p>วันให้นม :<?php echo " " . $milkday, '<br>'; ?></p>
                                            <p>สถานะการตั้งท้อง :<?php echo " " . $Pregnant, '<br>'; ?></p>
                                            <p>วันท้อง :<?php echo " " . $Pregnantday, '<br>'; ?></p>
                                            <p>ค่า THI : <?php
                                            if ($THI < 72) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะปกติ";
                                            } else if ($THI > 72 && $THI < 79) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดเล็กน้อย";
                                            } else if ($THI > 79 && $THI < 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดปานกลาง";
                                            } else if ($THI > 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดสูง";
                                            } ?></p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <h5>ข้อมูลความต้องการโภชนะของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">BW</th>
                                                <th scope="col">Milk</th>
                                                <th scope="col">Fat</th>
                                                <th scope="col">Protien</th>
                                                <th scope="col">BW C</th>
                                                <th scope="col">Intake</th>
                                                <th scope="col">NEL</th>
                                                <th scope="col">ME</th>
                                                <th scope="col">DE</th>
                                                <th scope="col">TDN</th>
                                                <th scope="col">MP</th>
                                                <th scope="col">RDP</th>
                                                <th scope="col">RUP</th>
                                                <th scope="col">CP</th>
                                                <th scope="col">CP</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(%)</th>
                                                <th scope="col">(%)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                                <td><?php echo number_format($wg, 0, '.', '') ?></td>
                                                <td><?php echo number_format($totalmilk, 0, '.', '') ?></td>
                                                <td><?php echo number_format($fatmilk, 1, '.', '') ?></td>
                                                <td><?php echo number_format($proteinmilk, 1, '.', '') ?></td>
                                                <td><?php echo number_format($bws, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DMIns, 1, '.', '') ?></td>
                                                <td><?php echo number_format($NEL, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MEtotal, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DE, 1, '.', '') ?></td>
                                                <td><?php echo number_format($TDN, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MPtotal1, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RDPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RUPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($CPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($PER_CPl / $DMIns, 1, '.', '') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการวิตามินและค่าเยื่อใยของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="6">วิตามิน</th>
                                                <th colspan="3">เยื่อใย</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">NDF</th>
                                                <th scope="col">ADF</th>
                                                <th scope="col">NFC</th>
                                                
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="3">(IU/Day)</th>
                                                <th colspan="3">(IU/Kg)</th>
                                                <th colspan="3">(>%)</th>
                                               

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($months >= 6 && $months <= 11 && $years < 1) {
                                            echo "

                                <tr style='text-align:center; background-color:#fff;'>
                                    <td>16,000</td>
                                    <td>3,076</td>
                                    <td>6,000</td>
                                    <td>1,154</td>
                                    <td>160</td>
                                    <td>31</td>
                                    <td>$NDF</td>
                                    <td>$ADF</td>
                                    <td>$NFC</td>
                                </tr>
                            ";
                                        } else if ($months >= 12 && $years = 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>24,000</td>
                                        <td>3,380</td>
                                        <td>9,000</td>
                                        <td>1,268</td>
                                        <td>240</td>
                                        <td>34</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        } else if ($months >= 6 && $years >= 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>36,000</td>
                                        <td>3,185</td>
                                        <td>13,500</td>
                                        <td>1,195</td>
                                        <td>360</td>
                                        <td>32</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการค่าแร่ธาตุของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">Ca</th>
                                                <th scope="col">P</th>
                                                <th scope="col">Mg</th>
                                                <th scope="col">Cl</th>
                                                <th scope="col">K</th>
                                                <th scope="col">Na</th>
                                                <th scope="col">S</th>
                                                <th scope="col">Co</th>
                                                <th scope="col">Cu</th>
                                                <th scope="col">I</th>
                                                <th scope="col">Fe</th>
                                                <th scope="col">Mn</th>
                                                <th scope="col">Se</th>
                                                <th scope="col">Zn</th>
                                                
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="15">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                            <td>0.62</td>
                                                <td>0.32</td>
                                                <td>0.18</td>
                                                <td>0.24</td>
                                                <td>1</td>
                                                <td>0.22</td>
                                                <td>0.2</td>
                                                <td>0.11</td>
                                                <td>11</td>
                                                <td>0.6</td>
                                                <td>12.3</td>
                                                <td>14</td>
                                                <td>0.3</td>
                                                <td>43</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>

            <?php
                            // ----------------------------------------------------------------------------------------------
                        } else if ($milk == "อยู่ในช่วงพักรีดนม") {

                            //เครียดสูง
                            //-----------------------------------------------------------------------------------
                            if ($THI > 90) {
                                // การกินได้ของโครีดนม
                                $DMIs = $DMIl * (1 - (($tem - 20) * 0.005922));
                                ?>
                      <div class="box-edible">
                            <div class="row">
                                  <h5>ข้อมูลโค</h5>
                                <div class="col-6">
                                    <div class="edible">
                                        <div class="tpic-edible">
                                            <p>ข้อมูลทั่วไป</p>
                                        </div>
                                        <div class="content-edible">
                                            <p> <?php echo "หมายเลขประจำตัวโค : " . $mtc['cow_id'], " ", "ชื่อ", " " . $mtc['cow_name'], '<br>'; ?></p>
                                            <p><?php echo "เพศ : " . $mtc['cow_gender'], '<br>'; ?></p>
                                            <p><?php echo 'อายุ : ';
                                            printf("%d ปี %d เดือน %d วัน\n", $years, $months, $days);
                                            '<br>'; ?></p>
                                            
                                            <p><?php echo ' รุ่น : ' . $c["name_gen"]; ?></p>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="edible">
                                    <div class="tpic-edible">
                                            <p>ข้อมูลอื่นๆ</p>
                                        </div>
                                        <div class="content-edible">
                                            <p>สถานะการรีดนม : <?php echo " " . $milk, '<br>'; ?></p>
                                            <p>สถานะการตั้งท้อง :<?php echo " " . $Pregnant, '<br>'; ?></p>
                                            <p>วันท้อง :<?php echo " " . $Pregnantday, '<br>'; ?></p>
                                            <p>ค่า THI : <?php
                                            if ($THI < 72) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะปกติ";
                                            } else if ($THI > 72 && $THI < 79) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดเล็กน้อย";
                                            } else if ($THI > 79 && $THI < 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดปานกลาง";
                                            } else if ($THI > 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดสูง";
                                            } ?></p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <h5>ข้อมูลความต้องการโภชนะของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">BW</th>
                                                <th scope="col">Intake</th>
                                                <th scope="col">NEL</th>
                                                <th scope="col">ME</th>
                                                <th scope="col">DE</th>
                                                <th scope="col">TDN</th>
                                                <th scope="col">MP</th>
                                                <th scope="col">RDP</th>
                                                <th scope="col">RUP</th>
                                                <th scope="col">CP</th>
                                                <th scope="col">CP</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                                <td><?php echo number_format($wg, 0, '.', '') ?></td>
                                                <td><?php echo number_format($DMIs, 1, '.', '') ?></td>
                                                <td><?php echo number_format($NEL, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MEtotal_high, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DE, 1, '.', '') ?></td>
                                                <td><?php echo number_format($TDN, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MPtotal1, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RDPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RUPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($CPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($PER_CPl / $DMIs, 1, '.', '') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการวิตามินและค่าเยื่อใยของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="6">วิตามิน</th>
                                                <th colspan="3">เยื่อใย</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">NDF</th>
                                                <th scope="col">ADF</th>
                                                <th scope="col">NFC</th>
                                                
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="3">(IU/Day)</th>
                                                <th colspan="3">(IU/Kg)</th>
                                                <th colspan="3">(>%)</th>
                                               

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($months >= 6 && $months <= 11 && $years < 1) {
                                            echo "

                                <tr style='text-align:center; background-color:#fff;'>
                                    <td>16,000</td>
                                    <td>3,076</td>
                                    <td>6,000</td>
                                    <td>1,154</td>
                                    <td>160</td>
                                    <td>31</td>
                                    <td>$NDF</td>
                                    <td>$ADF</td>
                                    <td>$NFC</td>
                                </tr>
                            ";
                                        } else if ($months >= 12 && $years = 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>24,000</td>
                                        <td>3,380</td>
                                        <td>9,000</td>
                                        <td>1,268</td>
                                        <td>240</td>
                                        <td>34</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        } else if ($months >= 6 && $years >= 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>36,000</td>
                                        <td>3,185</td>
                                        <td>13,500</td>
                                        <td>1,195</td>
                                        <td>360</td>
                                        <td>32</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการค่าแร่ธาตุของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">Ca</th>
                                                <th scope="col">P</th>
                                                <th scope="col">Mg</th>
                                                <th scope="col">Cl</th>
                                                <th scope="col">K</th>
                                                <th scope="col">Na</th>
                                                <th scope="col">S</th>
                                                <th scope="col">Co</th>
                                                <th scope="col">Cu</th>
                                                <th scope="col">I</th>
                                                <th scope="col">Fe</th>
                                                <th scope="col">Mn</th>
                                                <th scope="col">Se</th>
                                                <th scope="col">Zn</th>
                                                
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="15">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                            <td>0.62</td>
                                                <td>0.32</td>
                                                <td>0.18</td>
                                                <td>0.24</td>
                                                <td>1</td>
                                                <td>0.22</td>
                                                <td>0.2</td>
                                                <td>0.11</td>
                                                <td>11</td>
                                                <td>0.6</td>
                                                <td>12.3</td>
                                                <td>14</td>
                                                <td>0.3</td>
                                                <td>43</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>

            <?php
                                //-----------------------------------------------------------------------------------
                                // เครียดกลาง
                            } else if ($THI > 79 && $THI < 90) {
                                $DMIns = $DMIl * (1 - (($tem - 20) * 0.005922));
                                ?>
                      <div class="box-edible">
                            <div class="row">
                                  <h5>ข้อมูลโค</h5>
                                <div class="col-6">
                                    <div class="edible">
                                        <div class="tpic-edible">
                                            <p>ข้อมูลทั่วไป</p>
                                        </div>
                                        <div class="content-edible">
                                            <p> <?php echo "หมายเลขประจำตัวโค : " . $mtc['cow_id'], " ", "ชื่อ", " " . $mtc['cow_name'], '<br>'; ?></p>
                                            <p><?php echo "เพศ : " . $mtc['cow_gender'], '<br>'; ?></p>
                                            <p><?php echo 'อายุ : ';
                                            printf("%d ปี %d เดือน %d วัน\n", $years, $months, $days);
                                            '<br>'; ?></p>
                                            <p><?php echo ' รุ่น : ' . $c["name_gen"]; ?></p>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="edible">
                                    <div class="tpic-edible">
                                            <p>ข้อมูลอื่นๆ</p>
                                        </div>
                                        <div class="content-edible">
                                            <p>สถานะการรีดนม : <?php echo " " . $milk, '<br>'; ?></p>
                                            <p>สถานะการตั้งท้อง :<?php echo " " . $Pregnant, '<br>'; ?></p>
                                            <p>วันท้อง :<?php echo " " . $Pregnantday, '<br>'; ?></p>
                                            <p>ค่า THI : <?php
                                            if ($THI < 72) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะปกติ";
                                            } else if ($THI > 72 && $THI < 79) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดเล็กน้อย";
                                            } else if ($THI > 79 && $THI < 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดปานกลาง";
                                            } else if ($THI > 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดสูง";
                                            } ?></p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <h5>ข้อมูลความต้องการโภชนะของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">BW</th>
                                                <th scope="col">Milk</th>
                                                <th scope="col">Fat</th>
                                                <th scope="col">Protien</th>
                                                <th scope="col">BW C</th>
                                                <th scope="col">Intake</th>
                                                <th scope="col">NEL</th>
                                                <th scope="col">ME</th>
                                                <th scope="col">DE</th>
                                                <th scope="col">TDN</th>
                                                <th scope="col">MP</th>
                                                <th scope="col">RDP</th>
                                                <th scope="col">RUP</th>
                                                <th scope="col">CP</th>
                                                <th scope="col">CP</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(%)</th>
                                                <th scope="col">(%)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                                <td><?php echo number_format($wg, 0, '.', '') ?></td>
                                                <td><?php echo number_format($totalmilk, 0, '.', '') ?></td>
                                                <td><?php echo number_format($fatmilk, 1, '.', '') ?></td>
                                                <td><?php echo number_format($proteinmilk, 1, '.', '') ?></td>
                                                <td><?php echo number_format($bws, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DMIns, 1, '.', '') ?></td>
                                                <td><?php echo number_format($NEL, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MEtotal_mid, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DE, 1, '.', '') ?></td>
                                                <td><?php echo number_format($TDN, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MPtotal1, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RDPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RUPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($CPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($PER_CPl / $DMIns, 1, '.', '') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการวิตามินและค่าเยื่อใยของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="6">วิตามิน</th>
                                                <th colspan="3">เยื่อใย</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">NDF</th>
                                                <th scope="col">ADF</th>
                                                <th scope="col">NFC</th>
                                                
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="3">(IU/Day)</th>
                                                <th colspan="3">(IU/Kg)</th>
                                                <th colspan="3">(>%)</th>
                                               

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($months >= 6 && $months <= 11 && $years < 1) {
                                            echo "

                                <tr style='text-align:center; background-color:#fff;'>
                                    <td>16,000</td>
                                    <td>3,076</td>
                                    <td>6,000</td>
                                    <td>1,154</td>
                                    <td>160</td>
                                    <td>31</td>
                                    <td>$NDF</td>
                                    <td>$ADF</td>
                                    <td>$NFC</td>
                                </tr>
                            ";
                                        } else if ($months >= 12 && $years = 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>24,000</td>
                                        <td>3,380</td>
                                        <td>9,000</td>
                                        <td>1,268</td>
                                        <td>240</td>
                                        <td>34</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        } else if ($months >= 6 && $years >= 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>36,000</td>
                                        <td>3,185</td>
                                        <td>13,500</td>
                                        <td>1,195</td>
                                        <td>360</td>
                                        <td>32</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการค่าแร่ธาตุของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">Ca</th>
                                                <th scope="col">P</th>
                                                <th scope="col">Mg</th>
                                                <th scope="col">Cl</th>
                                                <th scope="col">K</th>
                                                <th scope="col">Na</th>
                                                <th scope="col">S</th>
                                                <th scope="col">Co</th>
                                                <th scope="col">Cu</th>
                                                <th scope="col">I</th>
                                                <th scope="col">Fe</th>
                                                <th scope="col">Mn</th>
                                                <th scope="col">Se</th>
                                                <th scope="col">Zn</th>
                                               
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="15">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                            <td>0.62</td>
                                                <td>0.32</td>
                                                <td>0.18</td>
                                                <td>0.24</td>
                                                <td>1</td>
                                                <td>0.22</td>
                                                <td>0.2</td>
                                                <td>0.11</td>
                                                <td>11</td>
                                                <td>0.6</td>
                                                <td>12.3</td>
                                                <td>14</td>
                                                <td>0.3</td>
                                                <td>43</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>


            <?php
                                //-----------------------------------------------------------------------------------
                                // เครียดต่ำ 
                            } else if ($THI > 72 && $THI < 79) {
                                $DMIns = $DMIl * (1 - (($tem - 20) * 0.005922));
                                ?>
                      <div class="box-edible">
                            <div class="row">
                                  <h5>ข้อมูลโค</h5>
                                <div class="col-6">
                                    <div class="edible">
                                        <div class="tpic-edible">
                                            <p>ข้อมูลทั่วไป</p>
                                        </div>
                                        <div class="content-edible">
                                            <p> <?php echo "หมายเลขประจำตัวโค : " . $mtc['cow_id'], " ", "ชื่อ", " " . $mtc['cow_name'], '<br>'; ?></p>
                                            <p><?php echo "เพศ : " . $mtc['cow_gender'], '<br>'; ?></p>
                                            <p><?php echo 'อายุ : ';
                                            printf("%d ปี %d เดือน %d วัน\n", $years, $months, $days);
                                            '<br>'; ?></p>
                                            
                                            <p><?php echo ' รุ่น : ' . $c["name_gen"]; ?></p>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="edible">
                                    <div class="tpic-edible">
                                            <p>ข้อมูลอื่นๆ</p>
                                        </div>
                                        <div class="content-edible">
                                            <p>สถานะการรีดนม : <?php echo " " . $milk, '<br>'; ?></p>
                                            <p>สถานะการตั้งท้อง :<?php echo " " . $Pregnant, '<br>'; ?></p>
                                            <p>วันท้อง :<?php echo " " . $Pregnantday, '<br>'; ?></p>
                                            <p>ค่า THI : <?php
                                            if ($THI < 72) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะปกติ";
                                            } else if ($THI > 72 && $THI < 79) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดเล็กน้อย";
                                            } else if ($THI > 79 && $THI < 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดปานกลาง";
                                            } else if ($THI > 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดสูง";
                                            } ?></p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <h5>ข้อมูลความต้องการโภชนะของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">BW</th>
                                                <th scope="col">Milk</th>
                                                <th scope="col">Fat</th>
                                                <th scope="col">Protien</th>
                                                <th scope="col">BW C</th>
                                                <th scope="col">Intake</th>
                                                <th scope="col">NEL</th>
                                                <th scope="col">ME</th>
                                                <th scope="col">DE</th>
                                                <th scope="col">TDN</th>
                                                <th scope="col">MP</th>
                                                <th scope="col">RDP</th>
                                                <th scope="col">RUP</th>
                                                <th scope="col">CP</th>
                                                <th scope="col">CP</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(%)</th>
                                                <th scope="col">(%)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                                <td><?php echo number_format($wg, 0, '.', '') ?></td>
                                                <td><?php echo number_format($totalmilk, 0, '.', '') ?></td>
                                                <td><?php echo number_format($fatmilk, 1, '.', '') ?></td>
                                                <td><?php echo number_format($proteinmilk, 1, '.', '') ?></td>
                                                <td><?php echo number_format($bws, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DMIns, 1, '.', '') ?></td>
                                                <td><?php echo number_format($NEL, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MEtotal_low, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DE, 1, '.', '') ?></td>
                                                <td><?php echo number_format($TDN, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MPtotal1, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RDPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RUPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($CPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($PER_CPl / $DMIns, 1, '.', '') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการวิตามินและค่าเยื่อใยของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="6">วิตามิน</th>
                                                <th colspan="3">เยื่อใย</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">NDF</th>
                                                <th scope="col">ADF</th>
                                                <th scope="col">NFC</th>
                                                
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="3">(IU/Day)</th>
                                                <th colspan="3">(IU/Kg)</th>
                                                <th colspan="3">(>%)</th>
                                               

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($months >= 6 && $months <= 11 && $years < 1) {
                                            echo "

                                <tr style='text-align:center; background-color:#fff;'>
                                    <td>16,000</td>
                                    <td>3,076</td>
                                    <td>6,000</td>
                                    <td>1,154</td>
                                    <td>160</td>
                                    <td>31</td>
                                    <td>$NDF</td>
                                    <td>$ADF</td>
                                    <td>$NFC</td>
                                </tr>
                            ";
                                        } else if ($months >= 12 && $years = 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>24,000</td>
                                        <td>3,380</td>
                                        <td>9,000</td>
                                        <td>1,268</td>
                                        <td>240</td>
                                        <td>34</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        } else if ($months >= 6 && $years >= 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>36,000</td>
                                        <td>3,185</td>
                                        <td>13,500</td>
                                        <td>1,195</td>
                                        <td>360</td>
                                        <td>32</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการค่าแร่ธาตุของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">Ca</th>
                                                <th scope="col">P</th>
                                                <th scope="col">Mg</th>
                                                <th scope="col">Cl</th>
                                                <th scope="col">K</th>
                                                <th scope="col">Na</th>
                                                <th scope="col">S</th>
                                                <th scope="col">Co</th>
                                                <th scope="col">Cu</th>
                                                <th scope="col">I</th>
                                                <th scope="col">Fe</th>
                                                <th scope="col">Mn</th>
                                                <th scope="col">Se</th>
                                                <th scope="col">Zn</th>
                                                
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="15">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                            <td>0.62</td>
                                                <td>0.32</td>
                                                <td>0.18</td>
                                                <td>0.24</td>
                                                <td>1</td>
                                                <td>0.22</td>
                                                <td>0.2</td>
                                                <td>0.11</td>
                                                <td>11</td>
                                                <td>0.6</td>
                                                <td>12.3</td>
                                                <td>14</td>
                                                <td>0.3</td>
                                                <td>43</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>


            <?php
                                //-----------------------------------------------------------------------------------
                                // ไม่เครียด
                            } else if ($THI < 72) {
                                $DMIns = $DMIl * (1 - ((5 - $tem) * 0.004644));
                                ?>
                      <div class="box-edible">
                            <div class="row">
                                  <h5>ข้อมูลโค</h5>
                                <div class="col-6">
                                    <div class="edible">
                                        <div class="tpic-edible">
                                            <p>ข้อมูลทั่วไป</p>
                                        </div>
                                        <div class="content-edible">
                                            <p> <?php echo "หมายเลขประจำตัวโค : " . $mtc['cow_id'], " ", "ชื่อ", " " . $mtc['cow_name'], '<br>'; ?></p>
                                            <p><?php echo "เพศ : " . $mtc['cow_gender'], '<br>'; ?></p>
                                            <p><?php echo 'อายุ : ';
                                            printf("%d ปี %d เดือน %d วัน\n", $years, $months, $days);
                                            '<br>'; ?></p>
                                            
                                            <p><?php echo ' รุ่น : ' . $c["name_gen"]; ?></p>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="edible">
                                    <div class="tpic-edible">
                                            <p>ข้อมูลอื่นๆ</p>
                                        </div>
                                        <div class="content-edible">
                                            <p>สถานะการรีดนม : <?php echo " " . $milk, '<br>'; ?></p>
                                            <p>สถานะการตั้งท้อง :<?php echo " " . $Pregnant, '<br>'; ?></p>
                                            <p>วันท้อง :<?php echo " " . $Pregnantday, '<br>'; ?></p>
                                            <p>ค่า THI : <?php
                                            if ($THI < 72) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะปกติ";
                                            } else if ($THI > 72 && $THI < 79) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดเล็กน้อย";
                                            } else if ($THI > 79 && $THI < 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดปานกลาง";
                                            } else if ($THI > 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดสูง";
                                            } ?></p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <h5>ข้อมูลความต้องการโภชนะของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">BW</th>
                                                <th scope="col">Milk</th>
                                                <th scope="col">Fat</th>
                                                <th scope="col">Protien</th>
                                                <th scope="col">BW C</th>
                                                <th scope="col">Intake</th>
                                                <th scope="col">NEL</th>
                                                <th scope="col">ME</th>
                                                <th scope="col">DE</th>
                                                <th scope="col">TDN</th>
                                                <th scope="col">MP</th>
                                                <th scope="col">RDP</th>
                                                <th scope="col">RUP</th>
                                                <th scope="col">CP</th>
                                                <th scope="col">CP</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(%)</th>
                                                <th scope="col">(%)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                                <td><?php echo number_format($wg, 0, '.', '') ?></td>
                                                <td><?php echo number_format($totalmilk, 0, '.', '') ?></td>
                                                <td><?php echo number_format($fatmilk, 1, '.', '') ?></td>
                                                <td><?php echo number_format($proteinmilk, 1, '.', '') ?></td>
                                                <td><?php echo number_format($bws, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DMIns, 1, '.', '') ?></td>
                                                <td><?php echo number_format($NEL, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MEtotal, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DE, 1, '.', '') ?></td>
                                                <td><?php echo number_format($TDN, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MPtotal1, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RDPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RUPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($CPl, 1, '.', '') ?></td>
                                                <td><?php echo number_format($PER_CPl / $DMIns, 1, '.', '') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการวิตามินและค่าเยื่อใยของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="6">วิตามิน</th>
                                                <th colspan="3">เยื่อใย</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">NDF</th>
                                                <th scope="col">ADF</th>
                                                <th scope="col">NFC</th>
                                                
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="3">(IU/Day)</th>
                                                <th colspan="3">(IU/Kg)</th>
                                                <th colspan="3">(>%)</th>
                                               

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($months >= 6 && $months <= 11 && $years < 1) {
                                            echo "

                                <tr style='text-align:center; background-color:#fff;'>
                                    <td>16,000</td>
                                    <td>3,076</td>
                                    <td>6,000</td>
                                    <td>1,154</td>
                                    <td>160</td>
                                    <td>31</td>
                                    <td>$NDF</td>
                                    <td>$ADF</td>
                                    <td>$NFC</td>
                                </tr>
                            ";
                                        } else if ($months >= 12 && $years = 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>24,000</td>
                                        <td>3,380</td>
                                        <td>9,000</td>
                                        <td>1,268</td>
                                        <td>240</td>
                                        <td>34</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        } else if ($months >= 6 && $years >= 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>36,000</td>
                                        <td>3,185</td>
                                        <td>13,500</td>
                                        <td>1,195</td>
                                        <td>360</td>
                                        <td>32</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการค่าแร่ธาตุของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">Ca</th>
                                                <th scope="col">P</th>
                                                <th scope="col">Mg</th>
                                                <th scope="col">Cl</th>
                                                <th scope="col">K</th>
                                                <th scope="col">Na</th>
                                                <th scope="col">S</th>
                                                <th scope="col">Co</th>
                                                <th scope="col">Cu</th>
                                                <th scope="col">I</th>
                                                <th scope="col">Fe</th>
                                                <th scope="col">Mn</th>
                                                <th scope="col">Se</th>
                                                <th scope="col">Zn</th>
                                                
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="15">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                            <td>0.62</td>
                                                <td>0.32</td>
                                                <td>0.18</td>
                                                <td>0.24</td>
                                                <td>1</td>
                                                <td>0.22</td>
                                                <td>0.2</td>
                                                <td>0.11</td>
                                                <td>11</td>
                                                <td>0.6</td>
                                                <td>12.3</td>
                                                <td>14</td>
                                                <td>0.3</td>
                                                <td>43</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>

            <?php
                            }
                            ?>

            <?php
                        }
                        //---------------------------------------------------------------------------------------- 
                    } else if ($Pregnant == "ไม่ได้อยู่ในช่วงตั้งท้อง") {
                        $milk = $_POST['selectmilk'];
                        // -----------------------------------------------------------
                        // RDP,RUP
                        $RDPg = ($MPg * 67.36 / 100) * (0.6375 * 0.95);
                        $RUPg = ($MPg * 32.64 / 100) / 0.85;
                        // -----------------------------------------------------------
                        // CP
                        $CPg = $RDP + $RUP;
                        $PER_CPg = $CPg * 100;
                        // -----------------------------------------------------------
                        //เครียดสูง
                        if ($THI > 90) {
                            // การกินได้ของโครีดนม
                            $DMIs = $DMIm * (1 - (($tem - 20) * 0.005922));
                            ?>
                          <div class="box-edible">
                            <div class="row">
                                  <h5>ข้อมูลโค</h5>
                                <div class="col-6">
                                    <div class="edible">
                                        <div class="tpic-edible">
                                            <p>ข้อมูลทั่วไป</p>
                                        </div>
                                        <div class="content-edible">
                                            <p> <?php echo "หมายเลขประจำตัวโค : " . $mtc['cow_id'], " ", "ชื่อ", " " . $mtc['cow_name'], '<br>'; ?></p>
                                            <p><?php echo "เพศ : " . $mtc['cow_gender'], '<br>'; ?></p>
                                            <p><?php echo 'อายุ : ';
                                            printf("%d ปี %d เดือน %d วัน\n", $years, $months, $days);
                                            '<br>'; ?></p>
                                            
                                            <p><?php echo ' รุ่น : ' . $c["name_gen"]; ?></p>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="edible">
                                    <div class="tpic-edible">
                                            <p>ข้อมูลอื่นๆ</p>
                                        </div>
                                        <div class="content-edible">
                                            <p>สถานะการรีดนม : <?php echo " " . $milk, '<br>'; ?></p>
                                            <p>สถานะการตั้งท้อง :<?php echo " " . $Pregnant, '<br>'; ?></p>
                                            <p>ค่า THI : <?php
                                            if ($THI < 72) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะปกติ";
                                            } else if ($THI > 72 && $THI < 79) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดเล็กน้อย";
                                            } else if ($THI > 79 && $THI < 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดปานกลาง";
                                            } else if ($THI > 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดสูง";
                                            } ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <h5>ข้อมูลความต้องการโภชนะของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">BW</th>
                                                <th scope="col">Milk</th>
                                                <th scope="col">Fat</th>
                                                <th scope="col">Protien</th>
                                                <th scope="col">BW C</th>
                                                <th scope="col">Intake</th>
                                                <th scope="col">NEL</th>
                                                <th scope="col">ME</th>
                                                <th scope="col">DE</th>
                                                <th scope="col">TDN</th>
                                                <th scope="col">MP</th>
                                                <th scope="col">RUP</th>
                                                <th scope="col">CP</th>
                                                <th scope="col">CP</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                                <td><?php echo number_format($wg, 0, '.', '') ?></td>
                                                <td><?php echo number_format($DMIs, 1, '.', '') ?></td>
                                                <td><?php echo number_format($NEL, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MEtotal_high, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DE, 1, '.', '') ?></td>
                                                <td><?php echo number_format($TDN, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MPtotal2, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RUPg, 1, '.', '') ?></td>
                                                <td><?php echo number_format($CPg, 1, '.', '') ?></td>
                                                <td><?php echo number_format($PER_CPg / $DMIs, 1, '.', '') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                            <h5>ข้อมูลค่าแนะนำความต้องการวิตามินและค่าเยื่อใยของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="6">วิตามิน</th>
                                                <th colspan="3">เยื่อใย</th>
                                            </tr>
                                            
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">NDF</th>
                                                <th scope="col">ADF</th>
                                                <th scope="col">NFC</th>
                                                
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="3">(IU/Day)</th>
                                                <th colspan="3">(IU/Kg)</th>
                                                <th colspan="3">(>%)</th>
                                               

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($months >= 6 && $months <= 11 && $years < 1) {
                                            echo "

                                <tr style='text-align:center; background-color:#fff;'>
                                    <td>16,000</td>
                                    <td>3,076</td>
                                    <td>6,000</td>
                                    <td>1,154</td>
                                    <td>160</td>
                                    <td>31</td>
                                    <td>$NDF</td>
                                    <td>$ADF</td>
                                    <td>$NFC</td>
                                </tr>
                            ";
                                        } else if ($months >= 12 && $years = 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>24,000</td>
                                        <td>3,380</td>
                                        <td>9,000</td>
                                        <td>1,268</td>
                                        <td>240</td>
                                        <td>34</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        } else if ($months >= 6 && $years >= 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>36,000</td>
                                        <td>3,185</td>
                                        <td>13,500</td>
                                        <td>1,195</td>
                                        <td>360</td>
                                        <td>32</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการค่าแร่ธาตุของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">Ca</th>
                                                <th scope="col">P</th>
                                                <th scope="col">Mg</th>
                                                <th scope="col">Cl</th>
                                                <th scope="col">K</th>
                                                <th scope="col">Na</th>
                                                <th scope="col">S</th>
                                                <th scope="col">Co</th>
                                                <th scope="col">Cu</th>
                                                <th scope="col">I</th>
                                                <th scope="col">Fe</th>
                                                <th scope="col">Mn</th>
                                                <th scope="col">Se</th>
                                                <th scope="col">Zn</th>
                                                <th scope="col">CP</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="15">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                                <td>0.44</td>
                                                <td>0.37</td>
                                                <td>0.40</td>
                                                <td>0.44</td>
                                                <td>1.54</td>
                                                <td>0.13</td>
                                                <td>0.19</td>
                                                <td>0.11</td>
                                                <td>16</td>
                                                <td>0.4</td>
                                                <td>26</td>
                                                <td>22</td>
                                                <td>0.3</td>
                                                <td>30</td>
                                              
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>

            <?php
                            //-----------------------------------------------------------------------------------
                            // เครียดกลาง
                        } else if ($THI > 79 && $THI < 90) {
                            $DMIns = $DMIm * (1 - (($tem - 20) * 0.005922));
                            ?>
                      <div class="box-edible">
                            <div class="row">
                                  <h5>ข้อมูลโค</h5>
                                <div class="col-6">
                                    <div class="edible">
                                        <div class="tpic-edible">
                                            <p>ข้อมูลทั่วไป</p>
                                        </div>
                                        <div class="content-edible">
                                            <p> <?php echo "หมายเลขประจำตัวโค : " . $mtc['cow_id'], " ", "ชื่อ", " " . $mtc['cow_name'], '<br>'; ?></p>
                                            <p><?php echo "เพศ : " . $mtc['cow_gender'], '<br>'; ?></p>
                                            <p><?php echo 'อายุ : ';
                                            printf("%d ปี %d เดือน %d วัน\n", $years, $months, $days);
                                            '<br>'; ?></p>
                                            
                                            <p><?php echo ' รุ่น : ' . $c["name_gen"]; ?></p>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="edible">
                                    <div class="tpic-edible">
                                            <p>ข้อมูลอื่นๆ</p>
                                        </div>
                                        <div class="content-edible">
                                            <p>สถานะการรีดนม : <?php echo " " . $milk, '<br>'; ?></p>
                                            <p>สถานะการตั้งท้อง :<?php echo " " . $Pregnant, '<br>'; ?></p>
                                            <p>ค่า THI : <?php
                                            if ($THI < 72) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะปกติ";
                                            } else if ($THI > 72 && $THI < 79) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดเล็กน้อย";
                                            } else if ($THI > 79 && $THI < 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดปานกลาง";
                                            } else if ($THI > 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดสูง";
                                            } ?></p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <h5>ข้อมูลความต้องการโภชนะของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">BW</th>
                                                <th scope="col">Intake</th>
                                                <th scope="col">NEL</th>
                                                <th scope="col">ME</th>
                                                <th scope="col">DE</th>
                                                <th scope="col">TDN</th>
                                                <th scope="col">MP</th>
                                                <th scope="col">RUP</th>
                                                <th scope="col">CP</th>
                                                <th scope="col">CP</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                                <td><?php echo number_format($wg, 0, '.', '') ?></td>
                                                <td><?php echo number_format($DMIns, 1, '.', '') ?></td>
                                                <td><?php echo number_format($NEL, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MEtotal_mid, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DE, 1, '.', '') ?></td>
                                                <td><?php echo number_format($TDN, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MPtotal2, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RUPg, 1, '.', '') ?></td>
                                                <td><?php echo number_format($CPg, 1, '.', '') ?></td>
                                                <td><?php echo number_format($PER_CPg / $DMIns, 1, '.', '') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                            <h5>ข้อมูลค่าแนะนำความต้องการวิตามินและค่าเยื่อใยของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="6">วิตามิน</th>
                                                <th colspan="3">เยื่อใย</th>
                                            </tr>
                                            
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">NDF</th>
                                                <th scope="col">ADF</th>
                                                <th scope="col">NFC</th>
                                                
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="3">(IU/Day)</th>
                                                <th colspan="3">(IU/Kg)</th>
                                                <th colspan="3">(>%)</th>
                                               

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($months >= 6 && $months <= 11 && $years < 1) {
                                            echo "

                                <tr style='text-align:center; background-color:#fff;'>
                                    <td>16,000</td>
                                    <td>3,076</td>
                                    <td>6,000</td>
                                    <td>1,154</td>
                                    <td>160</td>
                                    <td>31</td>
                                    <td>$NDF</td>
                                    <td>$ADF</td>
                                    <td>$NFC</td>
                                </tr>
                            ";
                                        } else if ($months >= 12 && $years = 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>24,000</td>
                                        <td>3,380</td>
                                        <td>9,000</td>
                                        <td>1,268</td>
                                        <td>240</td>
                                        <td>34</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        } else if ($months >= 6 && $years >= 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>36,000</td>
                                        <td>3,185</td>
                                        <td>13,500</td>
                                        <td>1,195</td>
                                        <td>360</td>
                                        <td>32</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการค่าแร่ธาตุของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">Ca</th>
                                                <th scope="col">P</th>
                                                <th scope="col">Mg</th>
                                                <th scope="col">Cl</th>
                                                <th scope="col">K</th>
                                                <th scope="col">Na</th>
                                                <th scope="col">S</th>
                                                <th scope="col">Co</th>
                                                <th scope="col">Cu</th>
                                                <th scope="col">I</th>
                                                <th scope="col">Fe</th>
                                                <th scope="col">Mn</th>
                                                <th scope="col">Se</th>
                                                <th scope="col">Zn</th>
                                                
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="15">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                            <td>0.44</td>
                                                <td>0.37</td>
                                                <td>0.40</td>
                                                <td>0.44</td>
                                                <td>1.54</td>
                                                <td>0.13</td>
                                                <td>0.19</td>
                                                <td>0.11</td>
                                                <td>16</td>
                                                <td>0.4</td>
                                                <td>26</td>
                                                <td>22</td>
                                                <td>0.3</td>
                                                <td>30</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>


            <?php
                            //-----------------------------------------------------------------------------------
                            // ครียดต่ำ
                        } else if ($THI > 72 && $THI < 79) {
                            $DMIns = $DMIm * (1 - (($tem - 20) * 0.005922));
                            ?>
                      <div class="box-edible">
                            <div class="row">
                                  <h5>ข้อมูลโค</h5>
                                <div class="col-6">
                                    <div class="edible">
                                        <div class="tpic-edible">
                                            <p>ข้อมูลทั่วไป</p>
                                        </div>
                                        <div class="content-edible">
                                            <p> <?php echo "หมายเลขประจำตัวโค : " . $mtc['cow_id'], " ", "ชื่อ", " " . $mtc['cow_name'], '<br>'; ?></p>
                                            <p><?php echo "เพศ : " . $mtc['cow_gender'], '<br>'; ?></p>
                                            <p><?php echo 'อายุ : ';
                                            printf("%d ปี %d เดือน %d วัน\n", $years, $months, $days);
                                            '<br>'; ?></p>
                                            
                                            <p><?php echo ' รุ่น : ' . $c["name_gen"]; ?></p>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="edible">
                                    <div class="tpic-edible">
                                            <p>ข้อมูลอื่นๆ</p>
                                        </div>
                                        <div class="content-edible">
                                            <p>สถานะการรีดนม : <?php echo " " . $milk, '<br>'; ?></p>
                                            <p>สถานะการตั้งท้อง :<?php echo " " . $Pregnant, '<br>'; ?></p>
                                            <p>ค่า THI : <?php
                                            if ($THI < 72) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะปกติ";
                                            } else if ($THI > 72 && $THI < 79) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดเล็กน้อย";
                                            } else if ($THI > 79 && $THI < 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดปานกลาง";
                                            } else if ($THI > 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดสูง";
                                            } ?></p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <h5>ข้อมูลความต้องการโภชนะของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">BW</th>
                                                <th scope="col">Intake</th>
                                                <th scope="col">NEL</th>
                                                <th scope="col">ME</th>
                                                <th scope="col">DE</th>
                                                <th scope="col">TDN</th>
                                                <th scope="col">MP</th>
                                                <th scope="col">RUP</th>
                                                <th scope="col">CP</th>
                                                <th scope="col">CP</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                                <td><?php echo number_format($wg, 0, '.', '') ?></td>
                                                <td><?php echo number_format($DMIns, 1, '.', '') ?></td>
                                                <td><?php echo number_format($NEL, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MEtotal_low, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DE, 1, '.', '') ?></td>
                                                <td><?php echo number_format($TDN, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MPtotal2, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RUPg, 1, '.', '') ?></td>
                                                <td><?php echo number_format($CPg, 1, '.', '') ?></td>
                                                <td><?php echo number_format($PER_CPg / $DMIns, 1, '.', '') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                            <h5>ข้อมูลค่าแนะนำความต้องการวิตามินและค่าเยื่อใยของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="6">วิตามิน</th>
                                                <th colspan="3">เยื่อใย</th>
                                            </tr>
                                            
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">NDF</th>
                                                <th scope="col">ADF</th>
                                                <th scope="col">NFC</th>
                                                
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="3">(IU/Day)</th>
                                                <th colspan="3">(IU/Kg)</th>
                                                <th colspan="3">(>%)</th>
                                               

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($months >= 6 && $months <= 11 && $years < 1) {
                                            echo "

                                <tr style='text-align:center; background-color:#fff;'>
                                    <td>16,000</td>
                                    <td>3,076</td>
                                    <td>6,000</td>
                                    <td>1,154</td>
                                    <td>160</td>
                                    <td>31</td>
                                    <td>$NDF</td>
                                    <td>$ADF</td>
                                    <td>$NFC</td>
                                </tr>
                            ";
                                        } else if ($months >= 12 && $years = 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>24,000</td>
                                        <td>3,380</td>
                                        <td>9,000</td>
                                        <td>1,268</td>
                                        <td>240</td>
                                        <td>34</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        } else if ($months >= 6 && $years >= 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>36,000</td>
                                        <td>3,185</td>
                                        <td>13,500</td>
                                        <td>1,195</td>
                                        <td>360</td>
                                        <td>32</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการค่าแร่ธาตุของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">Ca</th>
                                                <th scope="col">P</th>
                                                <th scope="col">Mg</th>
                                                <th scope="col">Cl</th>
                                                <th scope="col">K</th>
                                                <th scope="col">Na</th>
                                                <th scope="col">S</th>
                                                <th scope="col">Co</th>
                                                <th scope="col">Cu</th>
                                                <th scope="col">I</th>
                                                <th scope="col">Fe</th>
                                                <th scope="col">Mn</th>
                                                <th scope="col">Se</th>
                                                <th scope="col">Zn</th>
                                               
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="15">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                            <td>0.44</td>
                                                <td>0.37</td>
                                                <td>0.40</td>
                                                <td>0.44</td>
                                                <td>1.54</td>
                                                <td>0.13</td>
                                                <td>0.19</td>
                                                <td>0.11</td>
                                                <td>16</td>
                                                <td>0.4</td>
                                                <td>26</td>
                                                <td>22</td>
                                                <td>0.3</td>
                                                <td>30</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>


            <?php
                            //-----------------------------------------------------------------------------------
                            // ไม่เครียด
                        } else if ($THI < 72) {
                            $DMIns = $DMIm * (1 - ((5 - $tem) * 0.004644));
                            ?>
                      <div class="box-edible">
                            <div class="row">
                                  <h5>ข้อมูลโค</h5>
                                <div class="col-6">
                                    <div class="edible">
                                        <div class="tpic-edible">
                                            <p>ข้อมูลทั่วไป</p>
                                        </div>
                                        <div class="content-edible">
                                            <p> <?php echo "หมายเลขประจำตัวโค : " . $mtc['cow_id'], " ", "ชื่อ", " " . $mtc['cow_name'], '<br>'; ?></p>
                                            <p><?php echo "เพศ : " . $mtc['cow_gender'], '<br>'; ?></p>
                                            <p><?php echo 'อายุ : ';
                                            printf("%d ปี %d เดือน %d วัน\n", $years, $months, $days);
                                            '<br>'; ?></p>
                                            
                                            <p><?php echo ' รุ่น : ' . $c["name_gen"]; ?></p>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="edible">
                                    <div class="tpic-edible">
                                            <p>ข้อมูลอื่นๆ</p>
                                        </div>
                                        <div class="content-edible">
                                            <p>สถานะการรีดนม : <?php echo " " . $milk, '<br>'; ?></p>
                                            <p>วันให้นม :<?php echo " " . $milkday, '<br>'; ?></p>
                                            <p>สถานะการตั้งท้อง :<?php echo " " . $Pregnant, '<br>'; ?></p>
                                            <p>วันท้อง :<?php echo " " . $Pregnantday, '<br>'; ?></p>
                                            <p>ค่า THI : <?php
                                            if ($THI < 72) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะปกติ";
                                            } else if ($THI > 72 && $THI < 79) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดเล็กน้อย";
                                            } else if ($THI > 79 && $THI < 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดปานกลาง";
                                            } else if ($THI > 90) {
                                                echo $THI . " ", "แสดงว่า", " ", "โคอยู่ในสภาวะเครียดสูง";
                                            } ?></p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <h5>ข้อมูลความต้องการโภชนะของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">BW</th>
                                                <th scope="col">Intake</th>
                                                <th scope="col">NEL</th>
                                                <th scope="col">ME</th>
                                                <th scope="col">DE</th>
                                                <th scope="col">TDN</th>
                                                <th scope="col">MP</th>
                                                <th scope="col">RUP</th>
                                                <th scope="col">CP</th>
                                                <th scope="col">CP</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">(kg)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(Mcal/d)</th>
                                                <th scope="col">(kg/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(g/d)</th>
                                                <th scope="col">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                                <td><?php echo number_format($wg, 0, '.', '') ?></td>
                                                <td><?php echo number_format($DMIns, 1, '.', '') ?></td>
                                                <td><?php echo number_format($NEL, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MEtotal_high, 1, '.', '') ?></td>
                                                <td><?php echo number_format($DE, 1, '.', '') ?></td>
                                                <td><?php echo number_format($TDN, 1, '.', '') ?></td>
                                                <td><?php echo number_format($MPtotal2, 1, '.', '') ?></td>
                                                <td><?php echo number_format($RUPg, 1, '.', '') ?></td>
                                                <td><?php echo number_format($CPg, 1, '.', '') ?></td>
                                                <td><?php echo number_format($PER_CPg / $DMIns, 1, '.', '') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                            <h5>ข้อมูลค่าแนะนำความต้องการวิตามินและค่าเยื่อใยของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="6">วิตามิน</th>
                                                <th colspan="3">เยื่อใย</th>
                                            </tr>
                                            
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">NDF</th>
                                                <th scope="col">ADF</th>
                                                <th scope="col">NFC</th>
                                                
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="3">(IU/Day)</th>
                                                <th colspan="3">(IU/Kg)</th>
                                                <th colspan="3">(>%)</th>
                                               

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($months >= 6 && $months <= 11 && $years < 1) {
                                            echo "

                                <tr style='text-align:center; background-color:#fff;'>
                                    <td>16,000</td>
                                    <td>3,076</td>
                                    <td>6,000</td>
                                    <td>1,154</td>
                                    <td>160</td>
                                    <td>31</td>
                                    <td>$NDF</td>
                                    <td>$ADF</td>
                                    <td>$NFC</td>
                                </tr>
                            ";
                                        } else if ($months >= 12 && $years = 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>24,000</td>
                                        <td>3,380</td>
                                        <td>9,000</td>
                                        <td>1,268</td>
                                        <td>240</td>
                                        <td>34</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        } else if ($months >= 6 && $years >= 1 || $months >= 0) {
                                            echo "
                                    <tr style='text-align:center; background-color:#fff;'>
                                        <td>36,000</td>
                                        <td>3,185</td>
                                        <td>13,500</td>
                                        <td>1,195</td>
                                        <td>360</td>
                                        <td>32</td>
                                        <td>$NDF</td>
                                        <td>$ADF</td>
                                        <td>$NFC</td>
                                    </tr>
                                ";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ข้อมูลค่าแนะนำความต้องการค่าแร่ธาตุของโค</h5>
                                <div class="col-12">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">Ca</th>
                                                <th scope="col">P</th>
                                                <th scope="col">Mg</th>
                                                <th scope="col">Cl</th>
                                                <th scope="col">K</th>
                                                <th scope="col">Na</th>
                                                <th scope="col">S</th>
                                                <th scope="col">Co</th>
                                                <th scope="col">Cu</th>
                                                <th scope="col">I</th>
                                                <th scope="col">Fe</th>
                                                <th scope="col">Mn</th>
                                                <th scope="col">Se</th>
                                                <th scope="col">Zn</th>
                                                
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="15">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                            <td>0.44</td>
                                                <td>0.37</td>
                                                <td>0.40</td>
                                                <td>0.44</td>
                                                <td>1.54</td>
                                                <td>0.13</td>
                                                <td>0.19</td>
                                                <td>0.11</td>
                                                <td>16</td>
                                                <td>0.4</td>
                                                <td>26</td>
                                                <td>22</td>
                                                <td>0.3</td>
                                                <td>30</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>

            <?php
                        }
                        ?>

            <?php
                    }
                }
            }
            ?>
        </div>
    </div>
    <!-- วัตถุดิบ -->
    <!-- <div class="addmore">
                        <div class="row">
                            <div class="col-10" style="margin-top:1em;">
                                รายการวัตถุดิบ
                            </div>
                            <div class="col-2">
                                <button type="button" name="addmore" id="addmore" class="btn">เพิ่ม</button>
                            </div>

                        </div>
                    </div>
                    <script>
                    $(document).ready(function() {
                        let i = 1;
                        $('#addmore').click(function() {
                            i++;
                            $('#dynamic_field').append('<tr id="row' + i +
                                '"><td><select class="form-control" data-skip-name="true" name="raw[]"><option value="choose">เลือกวัตถุดิบ</option><?php $sql = "SELECT * FROM cow";
                                $result = $conn->query($sql);
                                while ($raw = $result->fetch_assoc()):
                                    ;
                                    ?><option value = "<?php echo $raw["cow_id"]; ?>" ><?php echo $raw["cow_id"]; ?>         <?php echo $raw["cow_name"]; ?></option><?php endwhile; ?> </select></td ><td><button type = "button" name = "remove" id = "' +
                                i +
                                '" class="btn btn-danger btn_remove"><i class="fa-solid fa-trash-can" style="color: #ffffff;"></i></button></td></tr>'
                            )
                        })
                        $(document).on('click', '.btn_remove', function() {
                            let button_id = $(this).attr('id');
                            $('#row' + button_id + '').remove();
                        })
                    })
                    </script>
                    <table class="table" id="dynamic_field">
                        <tr>
                            <td>
                                <select class="form-control" data-skip-name="true" name="raw[]" required>
                                    <option value="choose">เลือกวัตถุดิบ</option>
                                    <?php
                                    $sql = "SELECT * FROM cow";
                                    $result = $conn->query($sql);
                                    while ($raw = $result->fetch_assoc()):
                                        ;
                                        ?>
                                        <option value="<?php echo $raw["cow_id"]; ?>">
                                            <?php echo $raw["cow_id"]; ?>
                                            <?php echo $raw["cow_name"]; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                </div>
                </td>
                </tr>
                </table> -->
    <!-- <div class="addcal"><button type="button" class="btn" id="cal">ยืนยัน</button></div> -->
                <!-- เนื้อหา -->
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("#menu a[href='feed.php']").classList.add("active");
        });
    </script>
</body>

</html>