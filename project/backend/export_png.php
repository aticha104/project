<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* ======================
   CONNECT DATABASE
====================== */

$conn = new mysqli("localhost","root","","document_meeting");
if($conn->connect_error){
    die("Database connection failed");
}

$conn->set_charset("utf8mb4");

$meeting_id = intval($_GET['meeting_id'] ?? 1);


/* ======================
   LOAD USERS FROM API
====================== */

function loadUsers(){

$url = "http://192.168.4.246/api/gtw/users/";

$data = json_encode([
    "fnc"=>"find_user_all"
]);

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
"Content-Type: application/json; charset=UTF-8",
"Content-Length: ".strlen($data)
]);

$response = curl_exec($ch);

curl_close($ch);

$json = json_decode($response,true);

$users_map = [];

if(isset($json["data"])){

foreach($json["data"] as $u){

$id = trim($u["ID"] ?? "");

if($id!=""){
$users_map[$id] = $u;
}

}

}

return $users_map;

}


/* ======================
   GET PERSON NAME
====================== */

function getPersonName($person_id,$users_list){

$id = trim((string)$person_id);

if(isset($users_list[$id])){

$u = $users_list[$id];

$prefix = trim($u["HR_PREFIX_NAME"] ?? "");
$fname  = trim($u["HR_FNAME"] ?? "");
$lname  = trim($u["HR_LNAME"] ?? "");

return $prefix.$fname." ".$lname;

}

return "ไม่พบ ID: ".$id;

}

function getPersonPosition($person_id,$users_list){

$id = trim((string)$person_id);

if(isset($users_list[$id])){

$u = $users_list[$id];

return trim($u["POSITION_LEVEL"] ?? "");

}

return "";

}

function drawTextMultiLine($image,$size,$x,$y,$color,$font,$text,$max_width,$line_height){

$words = explode(" ",$text);
$line = "";

foreach($words as $word){

$test_line = $line.$word." ";

$box = imagettfbbox($size,0,$font,$test_line);
$width = $box[2]-$box[0];

if($width > $max_width){

imagettftext($image,$size,0,$x,$y,$color,$font,$line);
$y += $line_height;
$line = $word." ";

}else{

$line = $test_line;

}

}

if(trim($line)!=""){
imagettftext($image,$size,0,$x,$y,$color,$font,$line);
$y += $line_height;
}

return $y;

}


/* ======================
   LOAD USER LIST
====================== */

$all_users = loadUsers();


/* ======================
   GET MEETING DATA
====================== */

$meeting = $conn->query("SELECT * FROM meetings WHERE id=$meeting_id")->fetch_assoc();

if(!$meeting){
die("Meeting not found");
}

/* ======================
   FUNCTION THAI DATE
====================== */

function thaiDateFull($date){

$dayTH = [
"Sunday"=>"วันอาทิตย์",
"Monday"=>"วันจันทร์",
"Tuesday"=>"วันอังคาร",
"Wednesday"=>"วันพุธ",
"Thursday"=>"วันพฤหัสบดี",
"Friday"=>"วันศุกร์",
"Saturday"=>"วันเสาร์"
];

$monthTH = [
1=>"มกราคม",
2=>"กุมภาพันธ์",
3=>"มีนาคม",
4=>"เมษายน",
5=>"พฤษภาคม",
6=>"มิถุนายน",
7=>"กรกฎาคม",
8=>"สิงหาคม",
9=>"กันยายน",
10=>"ตุลาคม",
11=>"พฤศจิกายน",
12=>"ธันวาคม"
];

$timestamp = strtotime($date);

$day = $dayTH[date("l",$timestamp)];
$d = thaiNumber(date("j",$timestamp));
$m = $monthTH[date("n",$timestamp)];
$y = thaiNumber(date("Y",$timestamp)+543);

return "$dayที่ $d $m พ.ศ. $y";

}

function thaiNumber($number){

$num = ['0','1','2','3','4','5','6','7','8','9'];
$numTH = ['๐','๑','๒','๓','๔','๕','๖','๗','๘','๙'];

return str_replace($num,$numTH,$number);

}

function thaiTime($time){

if(!$time) return "";

$t = date("H.i", strtotime($time));

return thaiNumber($t)." น.";

}

$meeting_date_th = thaiDateFull($meeting["meeting_date"]);
$meeting_time_th = thaiTime($meeting["meeting_time"]);
$meeting_time_end_th = thaiTime($meeting["meeting_time_end"]);

/* ======================
   ATTENDEES + ROLE
====================== */

$result_attendees = $conn->query("
SELECT 
ma.person_id,
ma.role_id,
ma.attendance_status,
r.name AS role_name
FROM meeting_attendees ma
LEFT JOIN roles r ON ma.role_id = r.id
WHERE ma.meeting_id = $meeting_id
ORDER BY ma.role_id ASC
");

$result_agenda = $conn->query("SELECT * FROM agendas WHERE meeting_id=$meeting_id ORDER BY agenda_order");

function drawParagraph($image,$font,$size,$text,$x,$y,$max_width,$line_height,$color){

$words = preg_split('/\s+/u',$text);
$line = "";

foreach($words as $word){

$test = $line.$word." ";

$box = imagettfbbox($size,0,$font,$test);
$width = $box[2]-$box[0];

if($width > $max_width){

imagettftext($image,$size,0,$x,$y,$color,$font,$line);
$y += $line_height;
$line = $word." ";

}else{

$line = $test;

}

}

if(trim($line)!=""){
imagettftext($image,$size,0,$x,$y,$color,$font,$line);
$y += $line_height;
}

return $y;

}

/* ======================
   CREATE IMAGE
====================== */

$image = imagecreatetruecolor(1240,1754);

$white = imagecolorallocate($image,255,255,255);
$black = imagecolorallocate($image,0,0,0);

imagefill($image,0,0,$white);

$font = __DIR__."/../fonts/THSarabunNew.ttf";

if(!file_exists($font)){
die("Font file missing");
}


/* ======================
   HEADER
====================== */

$y = 150;

imagettftext($image,40,0,420,$y,$black,$font,"รายงานการประชุม");

$y += 80;

imagettftext($image,26,0,120,$y,$black,$font,"เรื่อง : ".$meeting['meeting_title']);

$y += 50;

imagettftext($image,26,0,120,$y,$black,$font,"วันที่ : ".$meeting_date_th);

$y += 50;

imagettftext($image,26,0,120,$y,$black,$font,"เวลา : ".$meeting_time_th." - ".$meeting_time_end_th);

$y += 50;

imagettftext($image,26,0,120,$y,$black,$font,"ณ ".$meeting['meeting_at']);

$y += 80;


/* ======================
   PRESENT
====================== */

imagettftext($image,28,0,120,$y,$black,$font,"ผู้มาประชุม");

$y += 50;

$idx = 1;

$result_attendees->data_seek(0);

while($row = $result_attendees->fetch_assoc()){

if($row["attendance_status"]=="present"){

$person_id = $row["person_id"];

$name = getPersonName($person_id,$all_users);
$position = getPersonPosition($person_id,$all_users);
$role = $row["role_name"] ?? "";

/* column layout */

imagettftext($image,24,0,120,$y,$black,$font,thaiNumber($idx).".");

imagettftext($image,24,0,160,$y,$black,$font,$name);

imagettftext($image,24,0,520,$y,$black,$font,$position);

imagettftext($image,24,0,900,$y,$black,$font,$role);

$y += 40;

$idx++;

}

}


/* ======================
   ABSENT
====================== */

$y += 40;

imagettftext($image,28,0,120,$y,$black,$font,"ผู้ไม่มาประชุม");

$y += 50;

$idx = 1;

$result_attendees->data_seek(0);

while($row = $result_attendees->fetch_assoc()){

if($row["attendance_status"]=="absent"){

$person_id = $row["person_id"];

$name = getPersonName($person_id,$all_users);
$position = getPersonPosition($person_id,$all_users);
$role = $row["role_name"] ?? "";

imagettftext($image,24,0,120,$y,$black,$font,thaiNumber($idx).".");
imagettftext($image,24,0,160,$y,$black,$font,$name);
imagettftext($image,24,0,520,$y,$black,$font,$position);
imagettftext($image,24,0,900,$y,$black,$font,$role);

$y += 40;

$idx++;

}

}


/* ======================
   AGENDA
====================== */

$y += 40;

imagettftext($image,28,0,120,$y,$black,$font,"ระเบียบวาระการประชุม");

$y += 50;

while($row = $result_agenda->fetch_assoc()){

$title = "วาระที่ ".thaiNumber($row["agenda_order"])." ";
$detail = $row["agenda_text"];

/* วาระ */

imagettftext(
$image,
26,
0,
120,
$y,
$black,
$font,
$title
);

$y += 40;

/* รายละเอียด */

$y = drawParagraph(
$image,
$font,
24,
$detail,
180,
$y,
900,
38,
$black
);

$y += 20;

}


/* ======================
   SIGNATURE
====================== */

$y = 1550;

imagettftext($image,24,0,250,$y,$black,$font,"ลงชื่อ........................................");

imagettftext($image,24,0,750,$y,$black,$font,"ลงชื่อ........................................");

$y += 40;

imagettftext($image,24,0,250,$y,$black,$font,"( ผู้จดรายงาน )");

imagettftext($image,24,0,750,$y,$black,$font,"( ประธานการประชุม )");


/* ======================
   OUTPUT IMAGE
====================== */

ob_start();
imagepng($image);
$image_data = ob_get_clean();

imagedestroy($image);

$base64 = base64_encode($image_data);

require '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('defaultFont', 'THSarabunNew');

$dompdf = new Dompdf($options);

$html = '
<html>
<head>
<meta charset="UTF-8">
<style>
body{
margin:0;
padding:0;
text-align:center;
}
img{
width:100%;
}
</style>
</head>
<body>

<img src="data:image/png;base64,'.$base64.'">

</body>
</html>
';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4','portrait');
$dompdf->render();

if(ob_get_length()){
ob_end_clean();
}

$dompdf->stream("meeting_report.pdf", ["Attachment"=>false]);
exit;