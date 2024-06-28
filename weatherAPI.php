<?php
function get_IP_address()
{
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $IPaddress) {
                $IPaddress = trim($IPaddress); // Just to be safe

                if (
                    filter_var(
                        $IPaddress,
                        FILTER_VALIDATE_IP,
                        FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
                    )
                    !== false
                ) {

                    return $IPaddress;
                }
            }
        }
    }
}

$ip = get_IP_address();
$loc = file_get_contents("http://ip-api.com/json/$ip");
$loc_o = json_decode($loc);

$country = $loc_o->country;
$regionName = $loc_o->regionName;
$city = $loc_o->city;
$lat = $loc_o->lat;
$lon = $loc_o->lon;
$query = $loc_o->query;

$status = "";
$msg = "";
$city = "";

if ($loc) {
    $url = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&appid=49c0bad2c7458f1c76bec9654081a661";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result, true);
    if ($result['cod'] == 200) {
        $status = "yes";
    } else {
        $msg = $result['message'];
    }
}
?>

<html lang="en" class=" -webkit-">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <title>Document</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Kanit';
    }
    .widget {
        margin:9em 20em -3em 35em;
        display: flex;
        height: 15em;
        width: 50%;
        transform: translate(-50%, -50%);
        flex-wrap: wrap;
        cursor: pointer;
        border-radius: 20px;
        box-shadow: 0 27px 55px 0 rgba(0, 0, 0, 0.3), 0 17px 17px 0 rgba(0, 0, 0, 0.15);
    }

    .widget .weatherIcon {
        flex: 1 100%;
        height: 60%;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        background: #b1bfcc;
        display: flex;
        align-items: center;
        justify-content: space-around;
        font-size: 100px;
    }

    .widget .weatherIcon i {
        padding-top: 2em;
    }

    .widget .weatherInfo {
        flex: 0 0 70%;
        height: 40%;
        background: #46739C;
        border-bottom-left-radius: 20px;
        display: flex;
        align-items: center;
        color: white;
    }

    .widget .weatherInfo .temperature {
        flex: 0 0 40%;
        width: 100%;
        font-size: 3em;
        display: flex;
        justify-content: space-around;
    }

    .widget .weatherInfo .description {
        flex: 0 60%;
        display: flex;
        flex-direction: column;
        width: 100%;
        height: 100%;
        justify-content: center;
        margin-left: -1em;
    }

    .widget .weatherInfo .description .weatherCondition {
        text-transform: uppercase;
        font-size: 1.8em;
        font-weight: 100;
    }

    .widget .weatherInfo .description .place {
        font-size: 1em;
    }

    .widget .date {
        flex: 0 0 30%;
        height: 40%;
        background: #95aece;
        border-bottom-right-radius: 20px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        color: white;
        font-size: 2em;
        font-weight: 800;
    }
@media (max-width: 576px) {
		.widget{
            display:none;
		}

    }
@media (max-width: 995px )  {
    .widget {
        margin:9em 20em -3em 35em;
        display: flex;
        height: 15em;
        width: 50%;
        transform: translate(-50%, -50%);
        flex-wrap: wrap;
        cursor: pointer;
        border-radius: 20px;
        box-shadow: 0 27px 55px 0 rgba(0, 0, 0, 0.3), 0 17px 17px 0 rgba(0, 0, 0, 0.15);
    }

    .widget .weatherIcon {
        flex: 1 100%;
        height: 60%;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        background: #b1bfcc;
        display: flex;
        align-items: center;
        justify-content: space-around;
        font-size: 100px;
    }

    .widget .weatherIcon i {
        padding-top: 2em;
    }

    .widget .weatherInfo {
        flex: 0 0 70%;
        height: 40%;
        background: #46739C;
        border-bottom-left-radius: 20px;
        display: flex;
        align-items: center;
        color: white;
    }

    .widget .weatherInfo .temperature {
        flex: 0 0 40%;
        width: 100%;
        font-size: 3em;
        display: flex;
        justify-content: space-around;
    }

    .widget .weatherInfo .description {
        flex: 0 60%;
        display: flex;
        flex-direction: column;
        width: 100%;
        height: 100%;
        justify-content: center;
        margin-left: -1em;
    }

    .widget .weatherInfo .description .weatherCondition {
        text-transform: uppercase;
        font-size: 1.8em;
        font-weight: 100;
    }

    .widget .weatherInfo .description .place {
        font-size: 1em;
    }

    .widget .date {
        flex: 0 0 30%;
        height: 40%;
        background: #95aece;
        border-bottom-right-radius: 20px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        color: white;
        font-size: 2em;
        font-weight: 800;
    }}

   
    </style>
</head>

<body>
<?php if ($status == "yes") { ?>
        <article class="widget">
            <div class="weatherIcon">
                <img src="http://openweathermap.org/img/wn/<?php echo $result['weather'][0]['icon'] ?>@4x.png" />
            </div>
            <div class="weatherInfo">
                <div class="temperature">
                    <span>
                        <?php echo round($result['main']['temp'] - 273.15) ?>°c
                    </span>
                </div>
                <div class="description mr45">
                    <div class="weatherCondition">
                        <?php
                        $weatherTranslations = array(
                            'Clear' => 'แจ่มใส',
                            'Dry' => 'แห้ง',
                            'Clouds' => 'มีเมฆ',
                            'Rain' => 'ฝนตก',
                            'Drizzle' => 'ฝนปรอยๆ',
                            'Thunderstorm' => 'พายุฝนฟ้าคะนอง',
                            'Snow' => 'หิมะ',
                            'Mist' => 'หมอก',
                            'Fog' => 'หมอกหนา',
                            'Haze' => 'หมอกควัน',
                            'Smoke' => 'ควัน',
                            'Tornado' => 'พายุหมุน',
                            'Hurricane' => 'พายุเฮอริเคน',
                            'Dust' => 'ฝุ่นละออง',
                            'Sand' => 'ทราย',
                            'Ash' => 'เถ้า'
                        );

                        // ตรวจสอบว่ามีข้อมูลสภาพอากาศอยู่ในรายการแปลหรือไม่
                        $weather = isset($result['weather'][0]['main']) ? $result['weather'][0]['main'] : '';

                        // แปลสภาพอากาศเป็นภาษาไทย
                        $translatedWeather = isset($weatherTranslations[$weather]) ? $weatherTranslations[$weather] : $weather;
                        echo $translatedWeather;

                        ?>

                    </div>
                    <div class="place">
                        <?php
                        $provinceTranslations = array(
                            'Bangkok' => 'กรุงเทพมหานคร',
                            'Krung Thep Maha Nakhon' => 'กรุงเทพมหานคร',
                            'Krabi' => 'กระบี่',
                            'Kanchanaburi' => 'กาญจนบุรี',
                            'Kalasin' => 'กาฬสินธุ์',
                            'Kamphaeng Phet' => 'กำแพงเพชร',
                            'Khon Kaen' => 'ขอนแก่น',
                            'Chanthaburi' => 'จันทบุรี',
                            'Chachoengsao' => 'ฉะเชิงเทรา',
                            'Chonburi' => 'ชลบุรี',
                            'Chainat' => 'ชัยนาท',
                            'Chaiyaphum' => 'ชัยภูมิ',
                            'Chumphon' => 'ชุมพร',
                            'Chiang Rai' => 'เชียงราย',
                            'Chiang Mai' => 'เชียงใหม่',
                            'Trang' => 'ตรัง',
                            'Trat' => 'ตราด',
                            'Tak' => 'ตาก',
                            'Nakhon Nayok' => 'นครนายก',
                            'Nakhon Pathom' => 'นครปฐม',
                            'Nakhon Phanom' => 'นครพนม',
                            'Nakhon Ratchasima' => 'นครราชสีมา',
                            'Nakhon Si Thammarat' => 'นครศรีธรรมราช',
                            'Nakhon Sawan' => 'นครสวรรค์',
                            'Nonthaburi' => 'นนทบุรี',
                            'Narathiwat' => 'นราธิวาส',
                            'Nan' => 'น่าน',
                            'Bueng Kan' => 'บึงกาฬ',
                            'Buriram' => 'บุรีรัมย์',
                            'Pathum Thani' => 'ปทุมธานี',
                            'Prachuap Khiri Khan' => 'ประจวบคีรีขันธ์',
                            'Prachinburi' => 'ปราจีนบุรี',
                            'Pattani' => 'ปัตตานี',
                            'Phra Nakhon Si Ayutthaya' => 'พระนครศรีอยุธยา',
                            'Phayao' => 'พะเยา',
                            'Phang Nga' => 'พังงา',
                            'Phatthalung' => 'พัทลุง',
                            'Phichit' => 'พิจิตร',
                            'Phitsanulok' => 'พิษณุโลก',
                            'Phetchaburi' => 'เพชรบุรี',
                            'Phetchabun' => 'เพชรบูรณ์',
                            'Phrae' => 'แพร่',
                            'Phuket' => 'ภูเก็ต',
                            'Maha Sarakham' => 'มหาสารคาม',
                            'Mukdahan' => 'มุกดาหาร',
                            'Mae Hong Son' => 'แม่ฮ่องสอน',
                            'Yasothon' => 'ยโสธร',
                            'Yala' => 'ยะลา',
                            'Roi Et' => 'ร้อยเอ็ด',
                            'Ranong' => 'ระนอง',
                            'Rayong' => 'ระยอง',
                            'Ratchaburi' => 'ราชบุรี',
                            'Lopburi' => 'ลพบุรี',
                            'Lampang' => 'ลำปาง',
                            'Lamphun' => 'ลำพูน',
                            'Loei' => 'เลย',
                            'Sisaket' => 'ศรีสะเกษ',
                            'Sakon Nakhon' => 'สกลนคร',
                            'Songkhla' => 'สงขลา',
                            'Satun' => 'สตูล',
                            'Samut Prakan' => 'สมุทรปราการ',
                            'Samut Songkhram' => 'สมุทรสงคราม',
                            'Samut Sakhon' => 'สมุทรสาคร',
                            'Sa Kaeo' => 'สระแก้ว',
                            'Saraburi' => 'สระบุรี',
                            'Sing Buri' => 'สิงห์บุรี',
                            'Sukhothai' => 'สุโขทัย',
                            'Suphan Buri' => 'สุพรรณบุรี',
                            'Surat Thani' => 'สุราษฎร์ธานี',
                            'Surin' => 'สุรินทร์',
                            'Nong Khai' => 'หนองคาย',
                            'Nong Bua Lamphu' => 'หนองบัวลำภู',
                            'Ang Thong' => 'อ่างทอง',
                            'Amnat Charoen' => 'อำนาจเจริญ',
                            'Udon Thani' => 'อุดรธานี',
                            'Uttaradit' => 'อุตรดิตถ์',
                            'Uthai Thani' => 'อุทัยธานี',
                            'Ubon Ratchathani' => 'อุบลราชธานี'
                        );

                        // ตรวจสอบว่าชื่อจังหวัดอยู่ในรายการแปลหรือไม่
                        $city = isset($loc_o->city) ? $loc_o->city : '';

                        // แปลงชื่อจังหวัดเป็นภาษาไทย (หากมีข้อมูลการแปล)
                        $translatedCity = isset($provinceTranslations[$city]) ? $provinceTranslations[$city] : $city;
                        echo $translatedCity;
                        ?>
                    </div>
                </div>
                <div class="description">
                    <div class="weatherCondition">ความชื้น</div>
                    <div class="place">
                        <?php echo $result['main']['humidity'] ?>%
                    </div>
                </div>
            </div>
            <div class="date">
                <?php
                // สร้างรายการแปลเดือนเป็นตัวย่อภาษาไทย
                $monthTranslations = array(
                    'Jan' => 'ม.ค.',
                    'Feb' => 'ก.พ.',
                    'Mar' => 'มี.ค.',
                    'Apr' => 'เม.ย.',
                    'May' => 'พ.ค.',
                    'Jun' => 'มิ.ย.',
                    'Jul' => 'ก.ค.',
                    'Aug' => 'ส.ค.',
                    'Sep' => 'ก.ย.',
                    'Oct' => 'ต.ค.',
                    'Nov' => 'พ.ย.',
                    'Dec' => 'ธ.ค.',
                );

                // แปลง Unix timestamp เป็นวันที่และเดือนในรูปแบบ "d M"
                function formatDateThai($timestamp)
                {
                    global $monthTranslations;
                    return date('d', $timestamp) . ' ' . $monthTranslations[date('M', $timestamp)];
                }

                // ใช้ฟังก์ชัน formatDateThai เพื่อแสดงวันที่และเดือนในภาษาไทย
                echo formatDateThai($result['dt']); // เช่น "22 ส.ค."
            

                ?>

            </div>
        </article>
    <?php } ?>
</body>

</html>