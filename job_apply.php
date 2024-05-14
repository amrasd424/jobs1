<?php 
include('config.php');
include('database.php');
include('alaisstyle.php');
$submitted = isset($_GET['submitted']) && $_GET['submitted'] === 'true';
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$ip_address = $_SERVER['REMOTE_ADDR'];
$actual_link = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//$pattern = '/\[.*\]/';
$pattern = '/\[.*\]/';
// Check if $actual_link matches the pattern
if (preg_match($pattern, $actual_link)) {
    // Stop the script
    $log_message = "IP: {$ip_address}, User Agent: {$user_agent}, APPLY Link: {$actual_link}" . PHP_EOL;
    file_put_contents("errorlink.log", $log_message, FILE_APPEND);
    exit("");
}

$blocked = array("__proto__","expect","job.","concat","require","socket","gethostbyname","to_s","[3]","hitmz","etc","password","passord","conf","*","if","now","sysdate","sleep","XOR","핥","桿","한","蒔","雜","賵馗丕卅賮","reboot","SMTP","JSON","SELECT","FROM","PG_SLEEP","SELECT 236 FROM PG_SLEEP","}}","}","function","PNG","Keys","parse","@@dKIfN","%u", "Ù", "Ø");
foreach ($blocked as $word) {
    if (stripos($actual_link, $word) !== false) {
        $log_entry = '[' . date('Y-m-d H:i:s') . '] blocked APPLY word found: ' . $word . ' in URL: ' . $actual_link . ' | User Agent: ' . $user_agent . ' | IP Address: ' . $ip_address . PHP_EOL;
        file_put_contents('errorblocked.log', $log_entry, FILE_APPEND);
            $to = "amrasd424@yahoo.com";
        $subject = "Blocked APPLY Word Found";
        $message = "Blocked word '$word' was found in URL: $actual_link\nUser Agent: $user_agent\nIP Address: $ip_address";
        $headers = "From: mark@arabjobs.info"; // Change this to your email address
        
        // Send the email
        mail($to, $subject, $message, $headers);
    }
}
$banned_words = array("feed","xml","/");
$forbiddenWords = array("__proto__","expect","job.","concat","require","gethostbyname","to_s","[3]","hitmz","etc","password","passord","conf","*","if","now","sysdate","sleep","XOR","disintermediate","laan","Bulgaria","challenge","foreground","reciprocal","Pants","Won","Granite","web-readiness","Bike","핥","桿","한","蒔","雜","賵馗丕卅賮","Montserrat","XML","xcxcx","acx","xca","Oxfordshire","strategize","Self-enabling","Small","asd","Bahamian dollar","7fg","compressing","Optimization","parallelism","Functionality","Leone","networks","reboot","Arkansas","Handmade Cotton Cheese","Architect","multi-byte","straat","SMTP","Bahamas","Namibi","adaptive","ekra","navigating","plug-and-play","JSON","UIC-Franc","ekra","circuit","SELECT","FROM","PG_SLEEP","SELECT 236 FROM PG_SLEEP","Optimized","plug-and-play","JSON","UIC-Franc","Adaptive","navigating","back up","installation","calculate","Arizona","s s s","Iowa","sd sd","14gswd","Ergonomic","Licensed","Tennessee","}}","}","function","Australian Dollar","Missouri","s1","s2ʺ","s3ʹ","?","PNG","Keys","Israel","encryption","forecast","Brunei Dollar","Total","Facilitator","utilize","bluetooth","India","Divide","HDD","open-source","Somalia","relationships","Springs","parse","JBOD","Corner","=","@@dKIfN","Towels","overriding","Surinam Dollar","Function-based","xnxx.com","socket","Assurance","97996","98991","198991","exe","bxss.me","users","Utah","acu1539","Versatile","Place","turquoise","Buckinghamshire","turn-key","schemas","aggregate","panel","hacking","Zambian","Secured","wooden","empower","encompassing","$","Incredible","\x","acu7977","Rustic","Refined Rubber Mouse","Refined","وsي","Handcrafted Cotton","desk","bricks-and-clicks","Nepalese","SCSI","auxiliary","backing up","vortals","%u","if","now", "sysdate", "sleep", "XOR", "المركزي المصري", "%u", "Ù", "Ø", "المصرية" ,"المصريه" ,"البريد المصري" ,"بنك مصر" ,"كير", "we", "للاتصالات", "saib", "movie", "couple", "fucking", "Adult", "tranny", "movies", "synergize", "متناك", "tits", "porn", "افلام", "gay", "sexy", "shemale", "ass", "sex", "dick", "pussy", "blow", "fuck", "dig", "سكس", "نيك", "شرموطة", "متناكة");
function clean_input($input) {
    $input = trim($input); // Remove leading and trailing spaces
    //$input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8'); // Convert special characters to HTML entities
    return $input;
}
// Function to remove banned words
function remove_banned_words($text, $banned_words) {
    foreach ($banned_words as $word) {
        // Using str_replace for case-insensitive word replacement
        $text = str_replace($word, ' ', $text);
    }
    // Remove extra spaces after removing banned words
    return trim($text);
}

if(isset($_GET['job']) && !empty($_GET['job'])) {
    $job = clean_input($_GET['job']);
    // Decode the URL parameter
    $job = urldecode($job);
    // Remove "%2B" from the decoded value
    $job = str_replace('%2B', '', $job);
    
}
if(isset($_GET['job']) && mb_strlen($_GET['job'], 'UTF-8') < 10) {
    // فتح الملف للكتابة
    $log_message = "APPLY JOB: {$_GET['job']},IP: {$ip_address}, User Agent: {$user_agent}, Link: {$actual_link}" . PHP_EOL;
    file_put_contents("errorshort.log", $log_message, FILE_APPEND);
} 
// Checking for forbidden words and replacing with a default message
foreach ($forbiddenWords as $word) {
    $lowercaseWord = strtolower($word);
    $lowercaseJob = strtolower($job);
   if (strpos(" $lowercaseJob ", " $lowercaseWord ") !== false) {
        $job = "مطلوب موظفين";
        break;
    }
}

// Removing banned words from the input
$job = remove_banned_words($job, $banned_words);
$job = strip_tags($job);
$decoded_job = filter_var($job, FILTER_SANITIZE_STRING);
if($decoded_job == null)
{	
  $decoded_job = "وظائف اليوم";
}

$city = isset($_GET['city']) ? $_GET['city'] : 'الرياض';
$country = isset($_GET['country']) ? $_GET['country'] : 'السعودية';
$default_country = "السعودية";
$default_city = "الرياض";
$cities_egypt = array('القاهرة', 'الإسكندرية', 'قنا', 'الجيزة', 'المنصورة', 'المطرية', 'منوف', 'بدر', 'كفر الشيخ', 'بورسعيد', 'أسيوط', 'الزرقا', 'العلمين', 'دمياط', 'بنها', 'أبو تيج', 'سوهاج', 'القرنة', 'السويس', 'الحسينية', 'شرم الشيخ', 'كفر صقر', 'طنطا', 'الدقهلية', 'بني سويف', 'الزقازيق', 'الصف', 'الغردقة', 'المنيا', 'الباجور', 'الحوامدية', 'أبو حماد', 'دمنهور', 'سمسطا', 'مطروح', 'بركة السبع', 'بلبيس');
$cities_saudia = array('الخبر', 'حفر الباطن', 'جدة', 'الدمام', 'عفيف', 'الهفوف', 'أبها', 'صامطة', 'القريات', 'الرياض', 'تبوك', 'نجران', 'القرى', 'القطيف', 'الطائف', 'المدينة المنورة', 'خميس مشيط', 'المنامة', 'الباحة', 'القلالي', 'المبرز', 'بريدة', 'الرس', 'أحد رفيدة', 'الخرج', 'شرورة', 'عنيزة', 'خليص', 'قلوه', 'الدرعية', 'الاحساء', 'رنيه', 'رابغ', 'تربه', 'بيش', 'بدر', 'طبرجل', 'محايل', 'أبو عريش', 'مكة', 'الجبيل', 'بقعاء', 'بحرة', 'شقراء', 'الافلاج', 'النعيرية', 'صبيا', 'الدرب', 'عرعر', 'سراة عبيدة', 'دومة الجندل', 'جازان', 'أضم', 'وادي الدواسر', 'املج', 'الطوال', 'بارق', 'حوطة بني تميم', 'الحناكية', 'المنطقة الشرقية', 'العارضة', 'الجموم', 'خيبر', 'الحائط', 'رفحاء', 'الخرمة', 'الخفجي', 'المذنب', 'المزاحمية', 'ضبا', 'النماص', 'رجال المع', 'المجاردة', 'ميسان', 'تثليث', 'تيماء', 'ظهران الجنوب', 'بقيق', 'النبهانية', 'رأس تنوره', 'المهد', 'العلا', 'الزلفي', 'سكاكا', 'الدائر', 'الليث', 'المويه', 'القويعية', 'بالقرن', 'الأسياح', 'المخواة', 'طريف', 'ينبع', 'احد المسارحه', 'المجمعة', 'العرضيات', 'ضمد', 'بيشة', 'البدائع', 'الوجه', 'بلجرشي', 'البكيريه', 'الدوادمي', 'السليل', 'القنفذة', 'عسير', 'العيون', 'تنورة', 'البرك', 'جيزان', 'الداير', 'الحريق', 'ابها', 'الظهران');
$cities_emarat = array("دبي", "رأس الخيمة", "الشارقة", "ابو ظبي", "الفجيرة", "عجمان", "خورفكان", "كلباء","مدينة زايد", "خورفكان", "أم القيوين", "الذيد", "الرمس", "جبل علي", "الإمارات", "دبا الفجيرة", "كلباء", "ليوا");
$cities_kuwait = array("جليب الشيوخ", "الوفرة", "الفروانية", "السالمية", "الجهراء", "الأحمدي", "الكويت", "الفحيحيل", "الفنطاس", "القرين", "العاصمة", "المنقف", "المهبولة", "صباح السالم", "خيطان", "مبارك الكبير", "العديلية", "القصور", "شرق", "المسيلة", "القصر");
$cities_morocco = array("الدار البيضاء", "سلا", "فاس", "طنجة", "مراكش", "مكناس", "الرباط", "وجدة", "القنيطرة");
$cities_qatar = array("الريان", "الدوحة", "قطر", "أم صلال", "الخور", "الوكرة", "الجميلية", "السيلية");
$cities_oman = array("مسقط", "صور", "الأشوص", "نزوى", "صلالة", "صحار", "عبري", "قلهات", "البيضاء", "أم صلال");
$cities_bahrain = array("المنامة", "المحرق", "الرفاع", "البحرين", "الرفاع الغربي", "السيف", "عالي", "سار", "الحورة", "سند", "الرفاع الغربي");

// القيم المدخلة من المستخدم
//$entered_city = $_GET['city'];

// فحص اسم المدينة وتحديد الدولة والمدينة المناسبة
if (in_array($city, $cities_egypt)) {
    $country = "مصر";
    $city = $city;
} 
elseif (in_array($city, $cities_saudia))
{
    $country = "السعودية";
    $city = $city;
} 
elseif (in_array($city, $cities_emarat))
{
    $country = "الامارات";
    $city = $city;
} 
elseif (in_array($city, $cities_kuwait))
{
    $country = "الكويت";
    $city = $city;
} 
elseif (in_array($city, $cities_morocco))
{
    $country = "المغرب";
    $city = $city;
} 
elseif (in_array($city, $cities_qatar))
{
    $country = "قطر";
    $city = $city;
} 
elseif (in_array($city, $cities_oman))
{
    $country = "عمان";
    $city = $city;
} 
elseif (in_array($city, $cities_bahrain))
{
    $country = "البحرين";
    $city = $city;
} 
elseif ($country == "مصر") 
{
    
    $city = "القاهرة"; // إذا كان البلد مصر
} 
elseif ($country == "السعودية")
{
    $city = "الرياض"; // إذا كان البلد السعودية
} 
elseif ($country == "الامارات") 
{
    
    $city = "دبي";
} 
elseif ($country == "الكويت") 
{
    
    $city = "الكويت";
} 
elseif ($country == "المغرب") 
{
    
    $city = "الدار البيضاء";
} 
elseif ($country == "قطر") 
{
    
    $city = "الدوحة";
} 
elseif ($country == "عمان") 
{
    
    $city = "مسقط";
} 
elseif ($country == "البحرين") 
{
    
    $city = "المنامة";
} 
else 
{
    // إذا كان البلد ليس مصر أو السعودية
    $country = "السعودية";
    $city = "الرياض"; // القيم الافتراضية
}
$message_array = file("companies.txt");
$message = array_rand($message_array);
$company = $message_array[$message];

$salary = isset($_GET['salary']) ? $_GET['salary'] : "بعد المقابلة الشخصية";
$currency = "جنيه مصري";
if (isset($_GET['dawam'])) {
    $userDawam = $_GET['dawam']; 
    $allowedDawamTypes = array("دوام كامل", "دوام مرن", "دوام جزئي");
    if (in_array($userDawam, $allowedDawamTypes)) {
        $dawam = $userDawam;
    } else {
        $dawam = "دوام مرن";
    }
} else {
    $dawam = "دوام مرن"; // أو يمكنك تعيين قيمة افتراضية أخرى حسب الحاجة
}

switch($country)
{
	default:
	case "مصر":
	  $currency = "جنيه مصري";
	  //$dawam = "دوام كامل";
	  if($city == null)
		  $city = "القاهرة";
	  break;
	case "السعودية":
	  $currency = "ريال سعودي";
	  if($city == null)
		  $city = "الرياض";
	  break;
	case "الامارات":
	  $currency = "درهم اماراتي";
	  if($city == null)
		  $city = "دبي";
	  break;
	case "قطر":
	  $currency = "ريال قطري";
	  if($city == null)
		  $city = "الدوحة";
	  break;
	case "البحرين":
	  $currency = "دينار بحريني";
	  if($city == null)
		  $city = "المنامة";
	  break;
	case "الكويت":
	  $currency = "دينار كويتي";
	  if($city == null)
		  $city = "الكويت";
	  break;
	case "عمان":
	  $currency = "ريال عماني";
	  if($city == null)
		  $city = "مسقط";
	  break;
	case "الاردن":
	  $currency = "دينار أردني";
	  if($city == null)
		  $city = "عمان";
	  break;
	case "المغرب":
	  $currency = "درهم مغربي";
	  if($city == null)
		  $city = "الدار البيضاء";
	  break;
}
// إذا كانت القيمة الافتراضية للراتب، قم بتعيين العملة على قيمة فارغة
if($salary == "بعد المقابلة الشخصية"){
  $currency = "";
}
$company = $_GET['company'] ?? 'شركة حكومية';

if ($company === 'شركة حكومية') {
}
function log_error($error_message, $error_file = 'errorsqlbug.log') {
    $ip_address = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'Unknown';
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Unknown';
    $timestamp = date('Y-m-d H:i:s');

    $log_message = "[{$timestamp}] [IP: {$ip_address}] [User-Agent: {$user_agent}] {$error_message}\n";
    
    // تسجيل الرسالة في ملف
    error_log($log_message, 3, $error_file);
}
// التحقق من الاتصال بقاعدة البيانات
if ($conn) {
    // تنظيف وتهيئة البيانات المدخلة
    $actual_link = $conn->real_escape_string($actual_link);

    // إعداد الاستعلام
    $query = "SELECT * FROM jobs_apply WHERE url = '$actual_link' ORDER BY id DESC LIMIT 1";

    // تنفيذ الاستعلام
    if ($res = $conn->query($query)) {
        // التحقق من وجود نتائج
        if ($res->num_rows > 0) {
            $resAssoc = $res->fetch_assoc();
            $decoded_job = $resAssoc["job"];
            $country = $resAssoc["country"];
            $city = $resAssoc["city"];
            $company = $resAssoc["company"];
            $dawam = $resAssoc["dawam"];
            $similar = $resAssoc["job_url"];
        } else 
        {
        $jobs_list = "";
//$city = $conn->real_escape_string($city);
if ($ress = $conn->query("SELECT job,country,city FROM jobs WHERE city = '$city' ORDER BY RAND() LIMIT 6")) {
    while ($ressAssoc = $ress->fetch_assoc()) {
         $words = preg_split('/\s+/', $ressAssoc["job"]);
        if (count($words) <= 1 || strpos($ressAssoc["job"], "???") !== false || strpos($ressAssoc["country"], "???") !== false ||
        strpos($ressAssoc["city"], "???") !== false || strpos($ressAssoc["job"], "print") !== false || 
        strpos($ressAssoc["job"], "\x") !== false || strpos($ressAssoc["job"], "$") !== false || 
        strpos($ressAssoc["job"], "}") !== false || strpos($ressAssoc["job"], "{") !== false || strpos($ressAssoc["job"], "www") !== false || 
        strpos($ressAssoc["job"], ">") !== false || strpos($ressAssoc["job"], "<") !== false || 
        strpos($ressAssoc["job"], "*") !== false || strpos($ressAssoc["job"], "=") !== false)
        {
         continue;
         }
        $joburl = "https://$similarserver/jobs.php?job=" . str_replace(" ", "+", $ressAssoc["job"]) . "&country=" . ($ressAssoc["country"]) . "&city=" . ($ressAssoc["city"]);
       
        $jobs_list .= urldecode($ressAssoc["job"]) . ": " . $joburl . "\n";
        $job_url = $conn->real_escape_string($jobs_list);
    }
    $ress->close();
}
            // إعداد استعلام الإدخال
            $sql = "INSERT INTO `jobs_apply`(`job`, `country`, `city`, `company`, `dawam`, `url`, `job_url`) 
                    VALUES ('$decoded_job','$country','$city','$company','$dawam','$actual_link', '$job_url')";

            // تنفيذ استعلام الإدخال
            if ($result = $conn->query($sql)) {
                // النجاح في إدخال البيانات
                // يمكنك إضافة أي إجراءات إضافية هنا
            } else 
            {
                $error_message = "SQL APPLY Error: " . $conn->error;
                log_error($error_message);
            }
               
        }
    } else {
          $error_message = "bind APPLY: " . $conn->error;
    log_error($error_message);
    }
} 
else 
{
     $error_message = "Connection APPLY Error: " . $conn->connect_error;
    log_error($error_message);
}

$name = "";
$email = "";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $country = $_GET['country'];


    // التحقق مما إذا كان البريد الإلكتروني موجود بالفعل
    $check_sql = "SELECT * FROM `emails` WHERE `email` = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
       
    } else {
        // إدخال البيانات في قاعدة البيانات
        $insert_sql = "INSERT INTO `emails`(`name`, `email`, `country`) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param('sss', $name, $email, $country);
        if ($stmt->execute()) {
     
        } else {
         
        }
    }

    // إغلاق الاتصال
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>التقديم على وظيفة <?php echo $decoded_job; ?> - <?php echo $city; ?> - <?php echo $country; ?> | وظائف <?php echo $country; ?></title>
		<link rel="icon" type="image/x-icon" href="./favicon.ico">
		<style type="text/css">
		@font-face {
			font-family: 'Jazeera';
			src: url('fonts/Al-Jazeera-Arabic-Bold.eot');
			src: url('fonts/Al-Jazeera-Arabic-Bold.eot?#iefix') format('embedded-opentype'),
				url('fonts/Al-Jazeera-Arabic-Bold.woff2') format('woff2'),
				url('fonts/Al-Jazeera-Arabic-Bold.woff') format('woff'),
				url('fonts/Al-Jazeera-Arabic-Bold.ttf') format('truetype'),
				url('fonts/Al-Jazeera-Arabic-Bold.svg#Al-Jazeera-Arabic-Bold') format('svg');
			font-weight: bold;
			font-display: swap;
			font-style: normal;
		}
		/* Reset default styles */
		* {
		  box-sizing: border-box;
		  margin: 0;
		  padding: 0;
		}
		
		/* Set full width */
		body {
		  font-family: "Jazeera",sans-serif ;
		  direction: rtl;
		  width: 100%;
		}
		/* Style for header */
		header {
			background-color: <?php echo $headerStyle['background-color']; ?>;
			color: #fff;
			padding: 20px;
			text-align: right;
		}

		/* Style for search bar */
		#search-bar {
			background-color: #eee;
			padding: 30px;
			text-align: center;
		}

		#search-bar input[type="text"] {
			font-family: "Jazeera",sans-serif ;
			padding: 10px;
			border: none;
			width: 70%;
			margin-right: 10px;
		}

		#search-bar button[type="submit"] {
			font-family: "Jazeera",sans-serif ;
			padding: 10px;
			border: none;
			background-color: <?php echo $headerStyle['background-color']; ?>;
			color: #fff;
			cursor: pointer;
		}

		/* Style for content area */
		#content {
			padding: 20px;
		}

		/* Style for footer */
		footer {
			background-color: #333;
			color: #fff;
			padding: 20px;
			text-align: center;
		}
		
		.breadcrumbs {
		  font-size: 16px;
		  margin: 10px;
		  color: #333;
		  text-align: right;
		}

		.breadcrumbs a {
		  color: #555;
		  text-decoration: none;
		}

		.breadcrumbs a:hover {
		  color: #000;
		}

		.breadcrumbs span.current-page {
		  color: #000;
		  font-weight: bold;
		}
		.job-suggestions {
			margin: 20px 0;
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 5px;
			background-color: #f5f5f5;
		}

		.job-suggestions ul {
			margin: 0;
			padding: 0;
			list-style: none;
		}

		.job-suggestions ul li {
			margin: 5px 0;
			padding: 0;
			font-size: 16px;
			line-height: 1.5;
		}

		.job-suggestions ul li a {
			color: #333;
			text-decoration: none;
		}

		.job-suggestions ul li a:hover {
			color: #000;
			text-decoration: underline;
		}
		.my-table {
		  margin-bottom: 20px;
		  border: 1px solid #333;
		  border-radius: 5px;
		  background-color: <?php echo $headerStyle['background-color']; ?>;
		  color: #fff;
		  padding: 10px;
		}

		.my-table table {
		  width: 100%;
		  border-collapse: collapse;
		}

		.my-table th, .my-table td {
		  padding: 10px;
		  text-align: center;
		  border: 1px solid #fff;
		}

		.my-table th {
		  background-color: #fff;
		  color: #333;
		}

		.my-table tr:nth-child(even) {
		  background-color: #333;
		  color: #fff;
		}
		.my-table h2 {
		  text-align: center;
		  margin-top: 0;
		  margin-bottom: 10px;
		}
		.apply-form {
		  background-color: white;
		  color: #ae3d3c;
		  padding: 20px;
		  border-radius: 10px;
		}

		.apply-form label {
		  margin-bottom: 5px;
		  display: block;
		}

		.apply-form input[type="text"],
		.apply-form input[type="email"],
		.apply-form input[type="number"],
		.apply-form input[type="file"] {
		  font-family: "Jazeera",sans-serif ;
		  height: 30px;
          background-color: lightgray;
          width: 100%;
          color: black;
		  padding: 5px;
		  border-radius: 5px;
		  margin-bottom: 20px;
		}
		.apply-form label[for="message"] {
		  display: block;
		  margin-bottom: 10px;
		}

		.apply-form textarea {
		  font-family: "Jazeera",sans-serif;
		  height: 100px;
		  background-color: lightgray;
		  width: 100%;
		  color: black;
		  padding: 5px;
		  border-radius: 5px;
		  margin-bottom: 20px;
		}
		.apply-form input[type="radio"] {
		  margin-right: 10px;
		}

		.apply-form button[type="submit"] {
		  font-family: "Jazeera",sans-serif ;
		  background-color: #ae3d3c;
		  color: white;
		  padding: 10px;
		  border: none;
		  border-radius: 5px;
		  cursor: pointer;
		}

		.apply-form button[type="submit"]:hover {
		  font-family: "Jazeera",sans-serif ;
		  background-color: #ae3d3c;
		}

		.success-message {
		  color: green;
          text-align: center;
		  height: 50px;
          margin-bottom: 30px;
		  background-color: lightgreen;
		  padding: 10px;
		}
	</style>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
<script>
    
    // Function to track page view
    function trackPageView() {
        const timestamp = new Date().toISOString();
        const userAgent = navigator.userAgent;

        // Create the tracking object with only the necessary data
        const data = {
            timestamp: timestamp,
            userAgent: userAgent,
        };

        // Send the data to the server-side endpoint using fetch
        fetch('/track_page_view.php', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => {
            // Handle the server response if needed
            if (response.ok) {
                
            } else {
                
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Call the trackPageView function on page load
    trackPageView();
</script>
		</head>
		<body>
			<header>
				<h1>وظائف <?php echo $country; ?></h1>
			</header>
			<div id="search-bar">
				<form method="get" action="/jobs.php">
					<button type="submit">ابحث</button>
					<input type="text" name="job" placeholder="ابحث في ملايين فرص العمل">
						<input type="hidden" name="country" value="<?php echo $country; ?>">
							<input type="hidden" name="city" value="<?php echo $city; ?>">
		        </form>
						</div>
						<div class="breadcrumbs">
							<a href="index.php">الرئيسية</a> &gt; 
	                        <a href="index.php">وظائف</a> &gt; 
	                        <a href="index.php"><?php echo $country; ?></a>  &gt; 
							<span class="current-page"> التقديم على وظيفة</span>
						</div>

						<div id="content">
							<div class="job-suggestions">
								<h2>التقديم على وظيفة : <?php echo $decoded_job; ?></h2>
							</div>
							<?php if (!$submitted): ?>
							<div>
								<div class="my-table">
									<h2>بيانات الوظيفة التي سيتم التقديم عليها</h2>
									<table>
										<tbody>
											<tr>
												<td>اسم الوظيفة</td>
												<td><?php echo $decoded_job; ?></td>
											</tr>
											<tr>
												<td>اسم المعلن</td>
												<td><?php echo $company; ?></td>
											</tr>
											<tr>
												<td>العنوان : الدولة</td>
												<td><?php echo $country; ?></td>
											</tr>
											<tr>
												<td>العنوان : المدينة</td>
												<td><?php echo $city; ?></td>
											</tr>
											<tr>
												<td>نوع الدوام</td>
												<td><?php echo $dawam; ?></td>
											</tr>
											<tr>
												<td>الراتب المتوقع</td>
												<td><?php echo $salary; ?> <?php echo $currency; ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>

							<h2>تعبئة نموذج التقديم</h2>
							<form class="apply-form" action="/job_apply.php?job=<?php echo urlencode($decoded_job); ?>&country=<?php echo urlencode($country); ?>&city=<?php echo urlencode($city); ?>&dawam=<?php echo urlencode($dawam); ?>&company=<?php echo urlencode($company); ?>&salary=<?php echo urlencode($salary); ?>&submitted=true" method="post" enctype="multipart/form-data">
								<div>
									<label for="name">الاسم :   (إجباري)</label>
									<input type="text" id="name" name="name" required>
								</div>
								<div>
									<label for="email">البريد الالكتروني :     (إجباري)</label>
									<input type="email" id="email" name="email" required>
								</div>
								<div>
									<label for="message">الرسالة:    (إجباري)</label>
									<textarea id="message" name="message" required></textarea>
								</div>
								<div>
									<label for="age">العمر :    (إجباري)</label>
									<input type="number" id="age" name="age" min="18" max="100" required>
								</div>
								<div>
									<label>النوع :   (إجباري)</label>
									<label for="male">
										<input type="radio" id="male" name="gender" value="male" required> ذكر</label>
										<label for="female">
											<input type="radio" id="female" name="gender" value="female" required> أنثى</label>
										</div>
										<div>
											<label for="cv">السيرة الذاتية :   (إختياري)</label>
											<input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx">
  </div>
											<div>
												<button type="submit" name="submit">التقديم الآن</button>
											</div>
										</form>
               <?php else: ?>
               
		    <div class="success-message"><p>تم التقديم على الوظيفة بنجاح</p></div>	<div class="my-table">
								<div class="my-table">
                                    <h2>بيانات الوظيفة التي تم التقديم عليها</h2>
									<table>
										<tbody>
											<tr>
												<td>اسم الوظيفة</td>
												<td><?php echo $decoded_job; ?></td>
											</tr>
											<tr>
												<td>اسم المعلن</td>
												<td><?php echo $company; ?></td>
											</tr>
											<tr>
												<td>العنوان : الدولة</td>
												<td><?php echo $country; ?></td>
											</tr>
											<tr>
												<td>العنوان : المدينة</td>
												<td><?php echo $city; ?></td>
											</tr>
											<tr>
												<td>نوع الدوام</td>
												<td><?php echo $dawam; ?></td>
											</tr>
											<tr>
												<td>الراتب المتوقع</td>
												<td><?php echo $salary; ?> <?php echo $currency; ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<?php endif; ?>
										<div>
											<h2>وظائف مشابهة</h2>
											<div class="job-suggestions">
											<?php
                                              // استعراض البيانات من جدول jobs_apply
                                             $sql = "SELECT job_url FROM jobs_apply WHERE url = '$actual_link' ORDER BY id DESC LIMIT 1";
                                           
                                             $result = $conn->query($sql);

                                             if ($result->num_rows > 0) {
                                             $row = $result->fetch_assoc();
                                             $jobs_links = $row["job_url"];
        
                                             // تحويل الروابط إلى قائمة مرتبة
                                             $links_array = explode("\n", $jobs_links);
                                             foreach ($links_array as $link) {
                                             // تحقق من أن الرابط غير فارغ قبل عرضه
                                             if (!empty($link)) {
                                             // تقسيم الرابط وعنوان الوظيفة
                                             $link_parts = explode(": ", $link);
                                             $job_url = $link_parts[1];
                                             $job_title = $link_parts[0];
                                                         $parsed_url = parse_url($job_url);
            $domain = $parsed_url['host']; // الحصول على الجزء المستضاف من URL
           
            $path_with_params = $parsed_url['path'] . (isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '');
        
echo "<li><a href=\"https://{$domain}
{$path_with_params}\">" . htmlspecialchars($job_title) . "</a></li>
";
                                             }
                                             
                                        }
                                        } else {
                                       
                                       }
                                       ?></div>
										</div>
									</div>
									
									<footer>
										<p>© 2024 -  وظائف <?php echo $country; ?></p>
									</footer>
									<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo Config::$googletagid; ?>"/>
									<script>
                                     window.dataLayer = window.dataLayer || [];
                                         function gtag(){dataLayer.push(arguments);}
                                         gtag('js', new Date());
                                         gtag('config', '<?php echo Config::$googletagid; ?>');
</script>
</body>
</html>