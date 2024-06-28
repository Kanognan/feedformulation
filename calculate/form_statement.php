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
    <title>เพิ่มรายการรายรับ/รายจ่าย</title>
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
            padding-left: 17em !important;
            width: 100%;
        }

        .charge {
            background-color: #e1fddb;
            margin: 2em;
        }

        .receipts {
            background-color: #fffacc;
            ;
            margin: 2em;
        }

        .content-box {
            padding: 2em;
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

        .addmore .btn:hover,
        .addmore .btn:focus:hover {
            background-color: #DBEDF2;
            color: black;
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

        .box2,
        .box1 {
            border: 1px solid lightgray;
            border-radius: 10px;
        }

        .head-box1 {
            background-color: #c8ead1;
            padding: 0.7em;
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;
        }

        .cat {
        margin: 0.5em auto;
        background-color: #f5f5f5;
        border-radius: 30px;
        text-align: center;
        border-radius: 30px;
        padding: 1.2em;
        border: none;
        width: 13.5em;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
    }

    .cat:hover {
        background-color: lightgray;
    }

    .cat-form {
        margin: 0.5em auto;
        background-color: #c8ead1;
        border-radius: 30px;
        text-align: center;
        border-radius: 30px;
        padding: 1.2em;
        border: none;
        width: 13.5em;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
    }

    .cat-active {
        margin: 0.5em auto;
        background-color: #A1CAE2;
        border-radius: 30px;
        text-align: center;
        border-radius: 30px;
        padding: 1.2em;
        border: none;
        width: 13.5em;
        color: white;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
    }

        @media (max-width: 576px) {
            
            .content {
                padding-left: 3.5em !important;
                padding-right: .5em !important;

            }

            .g-2 {
                width: 90%;
                margin: 0;
            }

            .cat,
            .cat-active {
                margin: 0.5em auto;
                width: 100%;
            }

            .cat-form {
                margin: 0.5em auto;
                width: 100%;
            }
            
            .content-box {
                margin: 0 auto;
                width: 100%;
                /* padding: 1.2em; */
            }

            .keyword-row .col-1 {
                display: flex;
                align-items: center;
                justify-content: center;
                
            }

            .keyword-row .col-7 {
                display: flex;
                align-items: center;
               
            }

            .keyword-row .col-3 {
                display: flex;
                align-items: center;
                justify-content: flex-start;
               
                /* สำหรับจัดเรียงจากซ้ายไปขวา */
            }

            .keyword-row .col-1 {
                display: flex;
                align-items: center;
               
            }

            .remove-keyword-btn {
                width: 100%;
                
            }
            .content-box .row>* {
                padding-left: calc(var(--bs-gutter-x)* .2) !important;
                padding-right: calc(var(--bs-gutter-x)* .3) !important;
                font-size: 14px;
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
                <div class="row text-center">
                    <div class="col-12 col-lg col-md-6 col-sm-12"><button type="button" onclick="window.location='form_statement.php'"
                            class="cat-form">+ เพิ่มรายรับ/รายจ่าย</button></div>
                    <div class="col-12 col-lg col-md-6 col-sm-12"><button type="button" onclick="window.location='index_profit.php'"
                            class="cat">สรุปรายรับ/รายจ่าย</button> </div>
                    <div class="col-12 col-lg col-md-6 col-sm-12"><button type="button" onclick="window.location='r_daily.php'"
                            class="cat">ผลตอบแทนรายวัน</button> </div>
                    <div class="col-12 col-lg col-md-6 col-sm-12"><button type="button" onclick="window.location='r_monthy.php'"
                            class="cat">ผลตอบแทนรายเดือน</button> </div>
                    <div class="col-12 col-lg col-md-6 col-sm-12"><button type="button" onclick="window.location='r_yearly.php'"
                            class="cat">ผลตอบแทนรายปี</button> </div>
                </div>
                <br>
                <div class="text-content">
                    <h3 style="text-align:center">เพิ่มข้อมูลรายการรายรับ/รายจ่าย</h3>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <br />
                            <form action="form_statement_db.php" method="post" class="form-horizontal">
                                <div class="box1">
                                    <h4 class="head-box1">ประเภทของรายการ</h4>
                                    <div class="content-box">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">ประเภทของรายการ</label>
                                                    <div class="col-md-12">
                                                        <select class="form-select" aria-label="Default select example"
                                                            name="statement_status">
                                                            <option selected>เลือกประเภทรายการ</option>
                                                            <option value="รายรับ">รายการรายรับ</option>
                                                            <option value="รายจ่าย">รายการรายจ่าย</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label">วัน/เดือน/ปี ที่ทำรายการ</label>
                                                    <div class="col-md-12">
                                                        <input type="date" name="statement_date" id="statement_date"
                                                            class="form-control" required
                                                            placeholder="รายละเอียดของรายการ">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <br>
                                <div class="box2">
                                    <h4 class="head-box1">รายละเอียดของรายการ</h4>
                                    <div class="content-box">
                                        <div class="row">
                                            <div class="col-12 col-md-6 col-lg-1 d-flex align-items-center justify-content-center">
                                                ลำดับ
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-7 d-flex align-items-center justify-content-center">
                                                รายละเอียดรายการ
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 d-flex align-items-center justify-content-center">
                                                จำนวนเงิน (บาท)
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-1"></div>
                                        </div>

                                        <div class="liststatement">
                                            <div class="keyword-liststatement" id="keywordListstatement">
                                                <div class="keyword-row">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6 col-lg-1 d-flex justify-content-center">
                                                            <label class="row-number">1</label>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-7">
                                                            <!-- <label> รายละเอียดของรายการ</label> -->
                                                            <input type="text" name="statement_detail[]"
                                                                class="form-control" required
                                                                placeholder="รายละเอียดของรายการ"
                                                                pattern="[a-zA-Z]+([a-zA-Z0-9\s,\-\.\(/)]*)">
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-3">
                                                            <!-- <label> จำนวนเงิน (บาท)</label> -->
                                                            <input type="number" name="statement_amount[]"
                                                                class="form-control" step="0.01" min="0" required
                                                                placeholder="จำนวนเงิน (บาท)">
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-1"></div>
                                                    </div>
                                                </div>
                                                <div class="d-grid gap-2 col-2 mx-auto addbtn mt-3">
                                                    <button class="btn btn-warning add-keyword-btn" type="button"
                                                        data-bs-toggle="tooltip" title="เพิ่มช่องกรอกวัตถุดิบเพิ่มเติม">
                                                        <i class="bi bi-plus-lg"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                        </div>
                        <br><br>
                        <div class="d-flex justify-content-center btn-more mt-5">
                            <div class="form-group">
                                <button type="submit" class="btn btn-add confirm" name="addstatement">บันทึก</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- เนื้อหา -->
        </div>
    </div>
    </div>

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
    const keywordListstatement = document.querySelector("#keywordListstatement");
    let count = keywordListstatement.querySelectorAll(".keyword-row").length;

    keywordListstatement.addEventListener("click", function (event) {
        if (event.target.classList.contains("add-keyword-btn")) {
            const keywordRow = createKeywordRow();
            keywordListstatement.insertBefore(keywordRow, document.querySelector(".addbtn"));
            count++;
            keywordRow.querySelector(".row-number").innerText = count;
        } else if (event.target.classList.contains("remove-keyword-btn")) {
            const rowToRemove = event.target.closest(".keyword-row");
            rowToRemove.parentNode.removeChild(rowToRemove); // แก้ไขบรรทัดนี้
            count--; // เพิ่มบรรทัดนี้
            updateRowNumbers(); // เพิ่มบรรทัดนี้
        }
    });

    function createKeywordRow() {
        const keywordRow = document.createElement("div");
        keywordRow.className = "keyword-row row mt-2";

        const keywordNumberCol = document.createElement("div");
        keywordNumberCol.className = "col-12 col-md-6 col-lg-1 d-flex justify-content-center";

        const keywordNumber = document.createElement("label");
        keywordNumber.className = "row-number";
        keywordNumber.innerText = count + 1;

        const keywordInputDetailCol = document.createElement("div");
        keywordInputDetailCol.className = "col-12 col-md-6 col-lg-7 d-flex align-items-center";

        const keywordInputDetail = document.createElement("input");
        keywordInputDetail.type = "text";
        keywordInputDetail.className = "form-control";
        keywordInputDetail.name = "statement_detail[]";
        keywordInputDetail.placeholder = "รายละเอียดของรายการ";
        keywordInputDetail.required = true;
        keywordInputDetail.pattern = "[a-zA-Z]+([a-zA-Z0-9\s,\-\.\(/)]*)";

        const keywordInputAmountCol = document.createElement("div");
        keywordInputAmountCol.className = "col-12 col-md-6 col-lg-3";

        const keywordInputAmount = document.createElement("input");
        keywordInputAmount.type = "number";
        keywordInputAmount.className = "form-control";
        keywordInputAmount.name = "statement_amount[]";
        keywordInputAmount.placeholder = "จำนวนเงิน (บาท)";
        keywordInputAmount.required = true;

        const removeKeywordButtonCol = document.createElement("div");
        removeKeywordButtonCol.className = "col-12 col-md-6 col-lg-1";

        const removeKeywordButton = document.createElement("button");
        removeKeywordButton.textContent = "-";
        removeKeywordButton.type = "button";
        removeKeywordButton.className = "btn btn-danger remove-keyword-btn w-100";

        keywordNumberCol.appendChild(keywordNumber);
        keywordRow.appendChild(keywordNumberCol);

        keywordInputDetailCol.appendChild(keywordInputDetail);
        keywordRow.appendChild(keywordInputDetailCol);

        keywordInputAmountCol.appendChild(keywordInputAmount);
        keywordRow.appendChild(keywordInputAmountCol);

        removeKeywordButtonCol.appendChild(removeKeywordButton);
        keywordRow.appendChild(removeKeywordButtonCol);

        return keywordRow;
    }

    // เพิ่มฟังก์ชันสำหรับอัปเดตหมายเลขแถว
    function updateRowNumbers() {
        const rowNumbers = keywordListstatement.querySelectorAll(".row-number");
        rowNumbers.forEach(function (number, index) {
            number.innerText = index + 1;
        });
    }
});

    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var today = new Date().toISOString().split('T')[0]; // วันที่ปัจจุบันในรูปแบบ ISO
            var dateInput = document.getElementById('statement_date');

            dateInput.max = today; // กำหนดค่าสูงสุดให้เป็นวันที่ปัจจุบัน

            dateInput.addEventListener('change', function () {
                var selectedDate = new Date(dateInput.value);
                if (selectedDate > new Date(today)) {
                    alert("ไม่สามารถเลือกวันที่เกินวันปัจจุบันได้");
                    dateInput.value = today; // เซ็ตค่าวันที่ให้เป็นวันปัจจุบัน
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("#menu a[href='index_profit.php']").classList.add("active");
        });
    </script>
</body>

</html>