<?php
session_start();
include ('server.php');
?>

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
      background: #64839b;
      font-family: 'Kanit', sans-serif;
    }

    .form-control {
      font-size: 1em;
    }

    .form-control,
    .form-control:focus,
    .input-group-text {
      border-color: #e1e1e1;
    }

    .form-control {
      border-radius: 5px;
    }

    .register,
    .login {
      border-radius: 20px;
      margin: 0em 0.5em;
    }

    .signup-form {
      width: 60%;
      margin: 3em auto 0em;
      padding: 30px;
    }

    .signup-form form {
      color: #999;
      border-radius: 3px;
      margin-bottom: 15px;
      background: #fff;
      box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
      /* padding: 0px 30px 30px 30px; */
      padding: 30px;
      border-radius: 20px;
    }

    .signup-form h2 {
      color: #333;
      font-weight: bold;
      margin-top: 0;
      text-align: center;
    }

    .signup-form p {
      text-align: center;
    }

    .signup-form hr {
      margin: 0 -30px 20px;
    }

    .signup-form .form-group {
      margin-bottom: 20px;
    }

    .signup-form label {
      font-weight: normal;
      font-size: 15px;
    }

    .signup-form .form-control {
      min-height: 38px;
      box-shadow: none !important;
    }

    .signup-form .input-group-addon {
      max-width: 42px;
      text-align: center;
    }

    .signup-form .btn,
    .signup-form .btn:active {
      font-size: 16px;
      font-weight: bold;
      background: #004c6d !important;
      border: none;
      min-width: 140px;
    }

    .signup-form .btn:hover,
    .signup-form .btn:focus {
      background: #64839b !important;
    }

    .signup-form a {
      color: #fff;
      text-decoration: underline;
    }

    .signup-form a:hover {
      text-decoration: none;
    }

    .signup-form form a {
      color: #64839b;
      text-decoration: none;
    }

    .signup-form form a:hover {
      text-decoration: underline;
    }

    .signup-form .fa {
      font-size: 21px;
    }

    .signup-form .fa-paper-plane {
      font-size: 18px;
    }

    .signup-form .fa-check {
      color: #fff;
      left: 17px;
      top: 18px;
      font-size: 7px;
      position: absolute;
    }

    span.input-group-text {
      height: 38px;
    }


    .img p {
      margin-bottom: 0 !important;
    }

    .but-img button {
      width: 100%;
      border: 0px;
      box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 2px, rgba(0, 0, 0, 0.07) 0px 2px 4px, rgba(0, 0, 0, 0.07) 0px 4px 8px, rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 16px 32px, rgba(0, 0, 0, 0.07) 0px 32px 64px;
      border-radius: 10px;
    }

    .img p {
      padding: 0.8em 0em;
    }

    p.text-muted {
      font-size: small;
    }

    .signup-form .back {
      background: #FE5E5E !important;
    }

    /* ----------------------------------------------------- */
    .gender-label {
      margin-right: 0.6rem;

    }

    .radio-button {
      display: inline-flex;
      align-items: center;
      cursor: pointer;
      margin-right: 1rem;
      background-color: #d5e6fc;
      padding: 0.5em 1.5em 0.5em 1em;
      transition: background-color 0.3s;
      border-radius: 10px;
      width: 8em !important;
    }

    .input-group>:not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback) {
      margin-left: calc(var(--bs-border-width) * -1);
      border-top-left-radius: 10px;
      border-bottom-left-radius: 10px;
    }

    .input-group:not(.has-validation)>.dropdown-toggle:nth-last-child(n+3),
    .input-group:not(.has-validation)>.form-floating:not(:last-child)>.form-control,
    .input-group:not(.has-validation)>.form-floating:not(:last-child)>.form-select,
    .input-group:not(.has-validation)>:not(:last-child):not(.dropdown-toggle):not(.dropdown-menu):not(.form-floating) {
      border-top-right-radius: 10px;
      border-bottom-right-radius: 10px;
    }

    .radio-button:hover {
      background-color: #e0e0e0;
    }

    .custom-radio input {
      width: 2em;
      height: 2em;
      border: 2px solid #ccc;
      border-radius: 50%;
      display: inline-block;
      position: relative;
      margin: 0em 0.5rem;
      visibility: hidden;
      /* เอาบริเวณวงกลมด้านหน้าออก */
    }

    .radio-button input {
      /* visibility: hidden; */
      margin-right: 0.5em;
    }

    .radio-button:hover .custom-radio {
      background-color: #007bff;
      border-color: #007bff;
    }


    .custom-radio input[type="radio"]:checked+.custom-radio::before {
      content: "";
      width: 8px;
      height: 8px;
      background-color: #007bff;
      border-radius: 50%;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .radio-text {
      font-size: 1rem;
      color: #212529;
    }

    /* ----------------------------------------------- */
    .bday {
      position: relative;
    }

    .input-description {
      margin-left: 0.5rem;
      font-size: 0.87rem;
      color: #6c757d;
    }

    @media (max-width: 994px) {
      .signup-form {
        width: 80%;
      }
    }

    @media (max-width: 768px) {
      .signup-form {
        width: 80%;
      }
    }

    @media (max-width: 576px) {
      .signup-form {
        width: 90%;
      }
    }
  </style>

</head>

<body>
  <div class="position-relative bg container">
    <div class="signup-form">
      <form action="register_expert_db.php" method="post" enctype="multipart/form-data" class="was-validated">
        <h2>ลงทะเบียน</h2>
        <p>กรุณากรอกแบบฟอร์มนี้เพื่อสร้างบัญชีสำหรับผู้เชี่ยวชาญ</p>
        <hr>
        <div class="row">
          <div class="form-group col-12 col-sm-12 col-md-6">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="bi bi-person-circle"></i>
                </span>
              </div>
              <input type="text" class="form-control" name="ex_fname" placeholder="ชื่อ" required
                pattern="[a-zA-Zก-๙]+">
              <div class="invalid-feedback text-start ps-5">
                * กรอกชื่อ
              </div>
              <div class="valid-feedback text-start ps-5">
                ชื่อ
              </div>
            </div>
          </div>
          <div class="form-group col-12 col-sm-12 col-md-6">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="bi bi-people-fill"></i>
                </span>
              </div>
              <input type="text" class="form-control" name="ex_lname" placeholder="นามสกุล" required
                pattern="[a-zA-Zก-๙]+">
              <div class="invalid-feedback text-start ps-5">
                * กรอกนามสกุล
              </div>
              <div class="valid-feedback text-start ps-5">
                นามสกุล
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="bi bi-envelope-at-fill"></i>
              </span>
            </div>
            <input type="email" class="form-control" name="email" placeholder="อีเมล" required>
            <div class="invalid-feedback text-start ps-5">
              * กรอกอีเมล
            </div>
            <div class="valid-feedback text-start ps-5">
              อีเมล
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="bi bi-person-fill-lock"></i>
              </span>
            </div>
            <input type="password" class="form-control" name="password_1" placeholder="รหัสผ่าน" required
              pattern="[a-zA-Z0-9]+" minlength="8">
            <div class="invalid-feedback text-start ps-5">
              * กรอกรหัสผ่าน
            </div>
            <div class="valid-feedback text-start ps-5">
              รหัสผ่าน
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="bi bi-person-fill-lock"></i>
              </span>
            </div>
            <input type="password" class="form-control" name="password_2" placeholder="ยืนยันรหัสผ่าน" required
              pattern="[a-zA-Z0-9]+" minlength="8">
            <div class="invalid-feedback text-start ps-5">
              * ยืนยันรหัสผ่าน
            </div>
            <div class="valid-feedback text-start ps-5">
              ยืนยันรหัสผ่าน
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-12 col-sm-12 col-md-6">
            <div class="input-group bday">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="bi bi-calendar-date-fill"></i>
                </span>
              </div>
              <input type="date" class="form-control" name="ex_bday" id="bday" required>
              <div class="invalid-feedback text-start ps-5">
                * วัน เดือน ปีเกิด
              </div>
              <div class="valid-feedback text-start ps-5">
                วัน เดือน ปีเกิด
              </div>
            </div>
          </div>
          <div class="form-group col-12 col-sm-12 col-md-6">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="bi bi-building"></i>
                </span>
              </div>
              <select name="career" id="career" class="form-control" required>
                <option selected disabled value="">เลือกอาชีพ</option>
                <?php
                $sql = "SELECT * FROM career";
                $result = $conn->query($sql);

                while ($career = $result->fetch_assoc()):
                  ;
                  ?>
                  <option value="<?php echo $career["career_id"]; ?>">
                    <?php echo $career["career_name"]; ?>
                  </option>
                <?php endwhile; ?>
              </select>
              <div class="invalid-feedback text-start ps-5">
                * เลือกอาชีพ
              </div>
              <div class="valid-feedback text-start ps-5">
                อาชีพ
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="bi bi-telephone-fill"></i>
              </span>
            </div>
            <input type="tel" class="form-control" name="ex_phone" placeholder="เบอร์โทร" required pattern="[0-9]{10}">
            <div class="invalid-feedback text-start ps-5">
              * กรอกเบอร์โทรศัพท์
            </div>
            <div class="valid-feedback text-start ps-5">
              เบอร์โทรศัพท์
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group d-flex justify-content-center">
            <label class="radio-button mb-2" for="gender-male">
              <input type="radio" name="gender" value="ชาย" id="gender-male" required>
              <span class="custom-radio"></span>
              <span class="radio-text">เพศชาย</span>
            </label>
            <label class="radio-button mb-2" for="gender-female">
              <input type="radio" name="gender" value="หญิง" id="gender-female" required>
              <span class="custom-radio"></span>
              <span class="radio-text">เพศหญิง</span>
            </label>
            <label class="radio-button mb-2" for="gender-other">
              <input type="radio" name="gender" value="อื่นๆ" id="gender-other" required>
              <span class="custom-radio"></span>
              <span class="radio-text">อื่นๆ</span>
            </label>
          </div>
        </div>
        <div class="row">
          <div class="form-group col">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="bi bi-building"></i>
                </span>
              </div>
              <input type="text" class="form-control" name="ex_company" placeholder="สถานที่ทำงาน" required>
              <div class="invalid-feedback text-start ps-5">
                * กรอกสถานที่ทำงาน
              </div>
              <div class="valid-feedback text-start ps-5">
                สถานที่ทำงาน
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="bi bi-mortarboard-fill"></i>
              </span>
            </div>
            <input type="text" class="form-control" name="ex_education" placeholder="การศึกษาสูงสุด" required>
            <div class="invalid-feedback text-start ps-5">
              * กรอกการศึกษาสูงสุด
            </div>
            <div class="valid-feedback text-start ps-5">
              การศึกษาสูงสุด
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fa-solid fa-school"></i>
              </span>
            </div>
            <input type="text" class="form-control" name="ex_graduated" placeholder="สถานศึกษา" required>
            <div class="invalid-feedback text-start ps-5">
              * กรอกสถานศึกษา
            </div>
            <div class="valid-feedback text-start ps-5">
              สถานศึกษา
            </div>
          </div>
        </div>
        <div class="form-group but-img">
          <button type="button" class="btn-warning">
            <div class="img">
              <p>แนบวุฒิการศึกษา</p>
            </div>
            <input class="form-control" type="file" id="formFile1" name="ex_edu_qualification" accept="image/*" multiple
              required>
            <div class="img">
              <p class="text-muted">แนบรูปภาพวุฒิการศึกษา</p>
            </div>
          </button>
        </div>
        <div class="form-group but-img">
          <button type="button" class="btn-warning">
            <div class="img">
              <p>แนบใบประกอบวิชาชีพ</p>
            </div>
            <input class="form-control" type="file" id="formFile2" name="ex_profes_license" accept="image/*" multiple
              required>
            <div class="img">
              <p class="text-muted">แนบรูปภาพใบประกอบวิชาชีพ</p>
            </div>
          </button>
        </div>
        <div class="form-group but-img">
          <button type="button" class="btn-warning">
            <div class="img">
              <p>แนบเอกสารหลักฐานอื่นๆ</p>
            </div>
            <input class="form-control" type="file" id="formFile3" name="ex_other" accept="image/*" multiple required>
            <div class="img">
              <p class="text-muted">แนบรูปภาพอื่น ๆ ที่เกี่ยวข้อง
                เช่นเกียรติบัตรการเข้าอบรมเกี่ยวกับโคนม</p>
            </div>
          </button>
        </div>
        <!-- <div class="form-group d-flex justify-content-center">
          <button type="button" class="btn btn-primary btn-lg btn-block register back" name="back"
            onclick="window.location.href='select_user_type.php'">ย้อนกลับ</button>
          <button type="submit" class="btn btn-primary btn-lg btn-block register" name="reg_expert">ลงทะเบียน</button>
        </div> -->
        <div class="form-group d-flex justify-content-center flex-column flex-md-row">
          <button type="button" class="btn btn-primary btn-lg btn-block register back mb-2 mb-md-0 me-md-2" name="back"
            onclick="window.location.href='select_user_type.php'">ย้อนกลับ</button>
          <button type="submit" class="btn btn-primary btn-lg btn-block register" name="reg_expert">ลงทะเบียน</button>
        </div>


      </form>
      <div class="text-center">มีบัญชีอยู่แล้ว <a href="login.php">เข้าสู่ระบบที่นี่</a></div>
    </div>
  </div>
  <?php
  if (isset($_SESSION['resultErrorEmail'])) {
    $resultErrorEmail = $_SESSION['resultErrorEmail'];
    echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'เกิดข้อผิดพลาด',
                        text: '" . $resultErrorEmail . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 3000 
                    });
                });
            </script>";
    unset($_SESSION['resultErrorEmail']);
  }
  ?>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var today = new Date().toISOString().split('T')[0];
      var dateInput = document.getElementById('bday');

      dateInput.max = today;

      dateInput.addEventListener('change', function () {
        var selectedDate = new Date(dateInput.value);
        if (selectedDate > new Date(today)) {
          alert("ไม่สามารถเลือกวันที่เกินวันปัจจุบันได้");
          dateInput.value = today;
        }
      });
    });
  </script>
</body>

</html>