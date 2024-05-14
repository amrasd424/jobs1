<?php 
include('config.php');
include('database.php');
include('alaisstyle.php');
// Initialize empty message variable
$errorMessage = "";

// Determine required parameters
$requiredParams = array("job");

// Capture query parameters
$params = array_intersect_key($_GET, array_flip($requiredParams));

// Check if all required parameters are present and non-empty
if (count($params) !== count($requiredParams)) {
    // Identify missing parameters
    $missingParams = array_diff($requiredParams, array_keys($params));

    // Build an informative error message
    $errorMessage = "Missing required parameters: ";
    $errorMessage .= implode(", ", $missingParams);

    // Determine redirect location
    if (isset($_SERVER['HTTP_REFERER']) && filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL)) {
        $redirectUrl = $_SERVER['HTTP_REFERER'] . "?error=" . urlencode($errorMessage);
    } else {
        $redirectUrl = "/index.php"; // Redirect to home if referring page invalid
    }

    // Perform redirect with appropriate message
    header("Location: $redirectUrl");
    exit();
}
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$ip_address = $_SERVER['REMOTE_ADDR'];
$actual_link = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//$pattern = '/\[.*\]/';
$pattern = '/\[.*\]/';
// Check if $actual_link matches the pattern
if (preg_match($pattern, $actual_link)) {
    // Stop the script
    $log_message = "IP: {$ip_address}, User Agent: {$user_agent}, Link: {$actual_link}" . PHP_EOL;
    file_put_contents("errorlink.log", $log_message, FILE_APPEND);
    exit("");
}

$blocked = array("__proto__","expect","job.","concat","require","socket","gethostbyname","to_s","[3]","hitmz","etc","password","passord","conf","*","if","now","sysdate","sleep","XOR","핥","桿","한","蒔","雜","賵馗丕卅賮","reboot","SMTP","JSON","SELECT","FROM","PG_SLEEP","SELECT 236 FROM PG_SLEEP","}}","}","function","PNG","Keys","parse","@@dKIfN","%u", "Ù", "Ø");
foreach ($blocked as $word) {
    if (stripos($actual_link, $word) !== false) {
        $log_entry = '[' . date('Y-m-d H:i:s') . '] blocked word found: ' . $word . ' in URL: ' . $actual_link . ' | User Agent: ' . $user_agent . ' | IP Address: ' . $ip_address . PHP_EOL;
        file_put_contents('errorblocked.log', $log_entry, FILE_APPEND);
            $to = "amrasd424@yahoo.com";
        $subject = "Blocked Word Found";
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
if(isset($_GET['job']) && mb_strlen($_GET['job'], 'UTF-8') < 18) {
    // فتح الملف للكتابة
    $log_message = "JOB: {$_GET['job']},IP: {$ip_address}, User Agent: {$user_agent}, Link: {$actual_link}" . PHP_EOL;
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

$currency = "جنيه مصري";
$dawamtype = rand(1, 10);
$dawam;
if ($dawamtype <= 5) 
{
    $dawam = "دوام كامل";
}
elseif ($dawamtype <= 8) 
{
    $dawam = "دوام مرن";
} 
else 
{
    $dawam = "دوام جزئي";
}
switch($country)
{
	default:
	case "مصر":
	  $salary = rand(35,90);
	  $currency = "جنيه مصري";
	  //$dawam = "دوام كامل";
	  if($city == null)
		  $city = "القاهرة";
	  break;
	case "السعودية":
	  $salary = rand(30,45);
	  $currency = "ريال سعودي";
	  if($city == null)
		  $city = "الرياض";
	  break;
	case "الامارات":
	  $salary = rand(30,45);
	  $currency = "درهم اماراتي";
	  if($city == null)
		  $city = "دبي";
	  break;
	case "قطر":
	  $salary = rand(30,50);
	  $currency = "ريال قطري";
	  if($city == null)
		  $city = "الدوحة";
	  break;
	case "البحرين":
	  $salary = rand(30,45);
	  $currency = "دينار بحريني";
	  if($city == null)
		  $city = "المنامة";
	  break;
	case "الكويت":
	  $salary = rand(1,5);
	  $currency = "دينار كويتي";
	  if($city == null)
		  $city = "الكويت";
	  break;
	case "عمان":
	  $salary = rand(20,52);
	  $currency = "ريال عماني";
	  if($city == null)
		  $city = "مسقط";
	  break;
	case "الاردن":
	  $salary = rand(7,30);
	  $currency = "دينار أردني";
	  if($city == null)
		  $city = "عمان";
	  break;
	case "المغرب":
	  $salary = rand(150,400);
	  $currency = "درهم مغربي";
	  if($city == null)
		  $city = "الدار البيضاء";
	  break;
}



$message_array = file("companies.txt");
$message = array_rand($message_array);
$company = preg_replace('/\s+/', ' ', $message_array[$message]);

$c = $conn;
$values = ["مطلوب {$decoded_job} للعمل في {$company} بالمواصفات التالية :<br><br>- التواجد في {$city}<br><br>- خبرة كبيرة في نفس مجال الوظيفة<br><br>- الراتب المخصص للوظيفة معتمد على الخبرة <br><br>- رجاء ارسل السيرة الذاتية", 
"وظائف جديدة  {$country} بمدينة : {$city}.<br>اعلنت شركة - {$company} - عن فرص وشواغر جديدة بالشركة لأصحاب الخبرات<br>الوظائف المتاحة : {$decoded_job}.<br>الراتب : يعتمد على سنوات الخبرة.<br>مكان العمل : {$city}.<br>وظائف {$city} - وظائف {$decoded_job}",
"فرصة عمل جديدة والتعيين فوري 2024 اعلنت شركة {$company} عن شواغر بالشركة <br>
مطلوب على الفور اليوم {$decoded_job} , اذا كنت تبحث عن عمل فقدم الان , التقديم متاح على الموقع.<br>
مكان العمل في {$city}, اذا كنت من سكان مدينة {$city} فقدم الان يوجد العديد من الفرص والشواغر <br>
للمزيد من وظائف {$decoded_job}  تصفح صفحات الموقع فهناك المزيد<br>
او للمزيد من الوظائف الشاغرة في {$city} ايضا يوجد المزيد من الوظائف في كافة التخصصات.",
"فورا فورا مطلوب وظائف {$decoded_job} للعمل في {$city}<br>
التقديم من نموذج التقديم للتواصل <br><br>
الوظيفة لا تحتاج خبرة",
"مطلوب فورا للتعيين بعد المقابلة {$decoded_job} بشركة {$company}<br>
سارع الان الرواتب مميزة ونطلب الخبرات والكفاءات, يوجد تامينات وبدلات
<br>
التواصل من نموذج التقديم",
"نعلن نحن  {$company} عن شواغر بالشركة للباحثين عن عمل , تطلب الشركة  {$decoded_job} للعمل والانضمام لفريق العمل.
<br>
اذا كنت تبحث عن عمل في مجال تخصص  {$decoded_job} فراسلنا فورا للانضمام لنا.
<br><br>
وظائف {$decoded_job} - وظائف {$city} .
<br><br>
للتقديم من نموذج التقديم بالاسفل.",
"شواغر {$decoded_job} في {$city} ل{$company}<br>
ارسل السيرة الذاتية واملء جميع خانات نموذج التقديم بالاسفل",
"مطلوب للتعيين فورا بمدينة  {$city} - بشركة {$company} براتب متميز , سوف يتم الاتفاق عليه بعد المقابلة الشخصية.
<br>
متوفر فرصة عمل بوظيفة {$decoded_job} .
<br>
ارسل السيرة الذاتية من خلال نموذج التقديم
<br>
يفضل وجود خبرة في مجال الوظيفة المعلن عنها
<br>
لا تنسى كتابة مسمى الوظيفة في عنوان الرسالة بنموذج التقديم",
"فرصة عمل اليوم - اعلنت شركة {$company} لوظيفة  {$decoded_job}<br><br>
المواصفات :<br><br>
عنوان الشركة في {$city}- وترغب في توظيف {$decoded_job} للالتحاق بفريق عملها<br>
من المميزات الراتب والتأمين<br>
التواصل للجادين فقط",
"التعيين فوري مطلوب {$decoded_job} للتعيين بمدينة {$city}<br>
التواصل من خلال ارسال السيرة الذاتية على البريد الالكتروني من نموذج التقديم <br><br>
الخبرة ليست شرط اساسي",
"مطلوب {$decoded_job} بشركة - {$company} .
<br>
المقر : {$city}<br>
الراتب : حسب الخبرة
<br>
قدم الان من خلال نموذج التقديم , وللمزيد من {$decoded_job} تصفح الموقع.",
"فرص عمل شاغرة جديدة تعلن عنها {$company}<br>
تطلب الشركة {$decoded_job} ب{$city} 
<br>
من الافضل وجود خبرة سابقة في مجال الوظيفة المعلن عنها.
<br>
لا يشترط جنسية المتقدم<br>
يفضل الا يزيد السن عن 45 عام",
"فرصة عمل فورية اليوم بالصحيفة {$company} للمواطنين {$country} والوافدين المقيمين بالشركة ب{$city}<br>
قم بارسال السي في من النموذج اسفل تلك الصفحة",
"وظائف اليوم الجديدة , للباحثين عن فرص عمل شاغرة لهم 2024<br>
مطلوب فورا {$decoded_job} - التعيين فوري - العمل سيكون بمدينة {$city}<br>
<br>
الراتب سيتم مناقشته في المقابلة الشخصية, والتي ستكون بمقر الشركة ب {$city}<br>
قدم السيرة الذاتية ل{$company} من نموذج تقديم الوظيفة باسفل الصفحة.<br>
وظائف اليوم - وظائف {$city} - وظائف {$company} - وظائف {$country}",
"مطلوب وظائف في {$country} للعمل في {$company} بالمواصفات التالية :<br><br>
- التواجد في {$city}<br><br>
- خبرة جيدة في نفس مجال الوظيفة<br><br>
- الراتب حسب الخبرة <br><br>
- ارسل السيرة الذاتية",
"وظائف {$decoded_job} للعمل في {$company} بالمواصفات التالية :<br><br>
- التواجد في {$city}<br><br>
- خبرات كبيرة في نفس مجال العمل<br><br>
- الراتب حسب الخبرة <br><br>
- يرجى ارسال السيرة الذاتية",
"وظيفة جديدة تعلن عنها {$company} , فقد نشرت الشركة الوظائف المطلوبة ومنها<br>
{$decoded_job} , بالشروط والمواصفات التالية :
<br>
1- لا يشترط سنوات الخبرة
<br>
2- لا يشترط عمر المتقدم
<br>
3- التعيين فورا بعد المقابلة الشخصية
<br>
4- سجل سيرتك الذاتية الان للحصول على الوظيفة",
"فرصة عمل جديدة اعلنت عنها {$company} , فالشركة قد اعلنت عن رغبتها في توظيف<br>
{$decoded_job} , بالشروط والمواصفات التالية :
<br>
1- لا يشترط سنوات الخبرة
<br>
2- لا يشترط عمر المتقدم
<br>
3- التعيين فورا بعد المقابلة الشخصية
<br>
4- سجل سيرتك الذاتية الان للحصول على الوظيفة",
"مطلوب على الفور {$decoded_job} للالتحاق بالعمل في {$city}<br>
التقديم من نموذج التقديم للتواصل <br><br>
بدون خبرة",
"فرصة عمل اليوم - اعلنت شركة {$company} لتعيين  {$decoded_job}<br><br>
المواصفات :<br><br>
الشركة في {$city} - وتريد توظيف {$decoded_job} للالتحاق بفريق عملها<br>
تامين وبدلات<br>
تواصل معنا اذا كنت ترغب في الانضمام لنا",
"مطلوب على الفور للتعيين {$decoded_job} للالتحاق بالعمل في {$city}<br>
لا تتردد وراسلنا من نموذج التقديم <br><br>
بدون خبرة",
"شواغر {$decoded_job} بمدينة {$city} ل{$company}<br>
قدم الان على الوظيفة وقم بتعبئة جميع البيانات",
"تطلب شركة {$company} والتعيين فوري , تطلب {$decoded_job} .
<br>
شروط اعلان الوظيفة :
<br>
مطلوب خبرة لا تقل عن 3 سنوات في وظائف وزارة العمل معرض التوظيف .
<br>
يفضل التواجد في القاهرة 
<br>
التوظيف بشكل فوري بعد اجراء المقابلات",
"لشركة {$company} مطلوب والتعيين فوري {$decoded_job} بمدينة {$city}.
<br>
وظائف {$city} و وظائف {$decoded_job}<br>
التقديم باسفل الصفحة",
"من خلال بوابة الوظائف اعلنت {$company} عن شواغر بالمؤسسة<br>
ترغب في تعيين {$decoded_job} بشرط ان يكون من اصحاب الخبرات السابقة<br>
بمدينة {$city}",
"شواغر جديدة للباحثين عن عمل باعلان {$company}<br>
تبحث الشركة عن {$decoded_job} للتوظيف ب{$city} 
<br>
الخبرة شرط اساسي للحصول على الوظيفة.
<br>
فرصة العمل متاحة للجميع<br>
يفضل الا يزيد السن عن 45 عام",
"مطلوب على الفور {$decoded_job} للالتحاق بالعمل في {$city}<br>
لا تتردد وراسلنا من نموذج التقديم <br><br>
لا يشترط الخبرة للتقدم للوظيفة",
"فرصة عمل جديدة اليوم ننشرها لكم , مطلوب فورا {$decoded_job} للعمل بمدينة {$city}.
<br>
اعلنت {$company}  عن فرص شاغرة لسد العجز بها وذلك بوظيفة {$decoded_job}.
<br>
اذا كانت خبرتك في نفس المجال فقدم سيرتك الذاتية .
<br>
قم بتعبئة نموذج التقديم على الوظيفة بالاسفل للتواصل مع صاحب العمل.
<br>
لا تنسى كتابة تخصصك في عنوان النموذج.
<br>
مع خالص الامنيات بالتوفيق للجميع.",
"أعلان وظيفة لشركة {$company} عن شواغر بها بوظيفة {$decoded_job} شرط الخبرة السابقة<br><br>
- قدم سيرتك الذاتية 
مع خالص الامنيات بالتوفيق للجميع.",
"فرصة عمل اليوم - اعلنت شركة {$company} لفرصة عمل  {$decoded_job}<br><br>
اشتراطات الوظيفة :<br><br>
مقر الشركة في {$city} - وترغب في توظيف {$decoded_job} للالتحاق بفريق عملها<br>
تأمين شامل وبدل سكن وبدل اتصالات<br>
تواصل معنا اذا كنت ترغب في الانضمام لنا",
"عبر بوابة التوظيف الرسمية تعلن ادارة {$company} عن شواغر بالمؤسسة<br>
تطلب {$decoded_job} بشرط ان يكون من اصحاب الخبرات السابقة<br>
بمنطقة {$city}",
"شواغر اليوم نشرتها {$company}, واوضحت الشركة الشواغر بها وهي<br>
{$decoded_job} , بالشروط والمواصفات التالية :
<br>
1- لا يشترط سنوات الخبرة
<br>
2- لا يشترط عمر المتقدم
<br>
3- التعيين فورا بعد المقابلة الشخصية
<br>
4- سجل سيرتك الذاتية الان للحصول على الوظيفة",
"{$company} لديها شواغر جديدة اعلنت عنها بوظائف {$decoded_job}<br>
سوف يتم التعيين والالتحاق بالوظيفة بشكل فوري بعد الانترفيو بمقر الشركة - الراتب والبدلات والتامينات بعد المقابلة<br>
املأ نموذج التقديم الان للتقديم",
"تعلن شركة {$company} عن شواغر بها بوظيفة {$decoded_job} شريطة وجود خبرة<br><br>
- يرجى التواصل وارسال CV ",
"{$company} تعلن عن فرص عمل جديدة ل {$decoded_job}<br>
التوظيف بشكل فوري بعد المقابلة - راتب مميز - بدلات - تامينات<br>
قدم الان",
"تعلن شركة {$company} عن وظائف شاغرة في مجال {$decoded_job}، وتشترط الشركة خبرة لا تقل عن 1 سنة.

إذا كنت تمتلك الخبرة المطلوبة، فيمكنك التقدم للوظيفة.",
"اعلنت شركة {$company} عن وظائف شاغرة {$decoded_job} شريطة وجود خبرة<br><br>
- قدم سيرتك الذاتية ",
"تبحث شركة {$company} عن {$decoded_job} ذوي خبرة لا تقل عن 3 سنة.<br><br>
إذا كنت تمتلك الخبرة المطلوبة، فيمكنك تقديم سيرتك الذاتية إلى الشركة.",
"تعلن شركة {$company} عن وظائف شاغرة في مجال {$decoded_job}، وتتطلب الشركة خبرة في هذا المجال.<br><br>
إذا كنت تمتلك الخبرة المطلوبة، فيمكنك التقدم للوظيفة.",
"تبحث شركة {$company} عن {$decoded_job} ذوي خبرة.<br><br>
إذا كنت تمتلك الخبرة المطلوبة، فيمكنك تقديم سيرتك الذاتية إلى الشركة.",
"تعلن شركة {$company} عن وظائف شاغرة في مجال {$decoded_job}، وتشترط الشركة خبرة في هذا المجال.<br><br>
إذا كنت تمتلك الخبرة المطلوبة، فيمكنك تقديم سيرتك الذاتية إلى الشركة."

];


$index = array_rand($values);
$value = $values[$index];

function log_error($error_message, $error_file = 'errorsqlbug.log') {
    $ip_address = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'Unknown';
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Unknown';
    $timestamp = date('Y-m-d H:i:s');

    $log_message = "[{$timestamp}] [IP: {$ip_address}] [User-Agent: {$user_agent}] {$error_message}\n";
    
    // تسجيل الرسالة في ملف
    error_log($log_message, 3, $error_file);
}
if ($conn) 
{
if($res = $conn->query("SELECT * FROM jobs WHERE url = '$actual_link' ORDER BY id DESC LIMIT 1")){

	if($res->num_rows > 0){
		$resAssoc = $res->fetch_assoc();
		$postalcode = $resAssoc["postalcode"];
		$decoded_job = $resAssoc["job"];
		$country = $resAssoc["country"];
		$city = $resAssoc["city"];
		$company = $resAssoc["company"];
		$dawam = $resAssoc["dawam"];
		$salary = $resAssoc["salary"];
		$identifier = $resAssoc["identifier"];
		$enddate = date("Y-m-d\T00:00:00\Z", strtotime("+30 days"));
        $startdate = date("Y-m-d\TH:i:s\Z", strtotime("Today"));
		$enddate1 = date("Y-m-d", strtotime("+ 30 days"));
        $startdate1 = date("Y-m-d", strtotime("Today"));
		$value = $resAssoc["description"];
		$icon = $resAssoc["icon"];
		$job_url = $resAssoc["job_url"];
	
	}
	else
	{
            $jobs_list = "";
         if ($ress = $conn->query("SELECT job, country, city FROM jobs WHERE city = '$city' ORDER BY RAND() LIMIT 6")) {
           if ($ress->num_rows == 0) {
        // إذا لم يتم العثور على نتائج، قم بالبحث عن آخر 6 قيم في قاعدة البيانات
            $last_six_results = $conn->query("SELECT job, country, city FROM jobs ORDER BY id DESC LIMIT 6");
            while ($ressAssoc = $last_six_results->fetch_assoc()) {
                 $words = preg_split('/\s+/', $ressAssoc["job"]);
// Check if the number of words is less than or equal to 1
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
            $job_url = $jobs_list;
         }
        } 
         else 
         {
        // إذا تم العثور على نتائج، قم بمعالجتها كالمعتاد
        while ($ressAssoc = $ress->fetch_assoc()) {
              $words = preg_split('/\s+/', $ressAssoc["job"]);
// Check if the number of words is less than or equal to 1
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
              $job_url = $jobs_list;
        }
    }
}
           
       $randomid = rand(1000000000, 9999999999);
        $identifier = $randomid;
        $random_number = rand(115000, 9999999);
        $postalcode = $random_number;
		$files = glob(realpath('./icons') . '/*.*');
		$file = array_rand($files);
		$icon = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME']."/icons/" .basename($files[$file]);
		$enddate = date("Y-m-d\TH:i:s\Z", strtotime("+ 30 days"));
        $startdate = date("Y-m-d\TH:i:s\Z", strtotime("Today"));
        $enddate1 = date("Y-m-d", strtotime("+ 30 days")); 
        $startdate1 = date("Y-m-d", strtotime("Today"));
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Unknown';
		$sql = "INSERT INTO `jobs`(`job`, `country`, `city`, `salary`, `company`, `description`, `dawam`, `url`, `icon`, `postalcode`, `identifier`, `job_url`, `user_agent`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisssssiiss", $decoded_job, $country, $city, $salary, $company, $value, $dawam, $actual_link, $icon, $postalcode, $identifier, $job_url, $user_agent);
        if ($stmt->execute()) 
        {        
        } 
        else 
        {
    // Error handling
    $error_message = "SQL Error: " . $stmt->error;
    log_error($error_message);
       }
	}
}
}
else
{

   $error_message = "Connection Error: " . $conn->connect_error;
    log_error($error_message);
}
function getClientIP() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

// Function to save user agent data
function saveUserAgent() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $ip = getClientIP();
    $jobf = $_GET['job'];
    $ac = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $date = date('Y-m-d');
    $filename = "user_agents.txt";
    $data = "|Date: $date |job: $jobf | Link: $ac | IP: $ip | User Agent: $userAgent" . PHP_EOL;
    file_put_contents($filename, $data, FILE_APPEND | LOCK_EX);
}

// Check if user agent is set and save it
if (isset($_SERVER['HTTP_HOST'])) {
    saveUserAgent();
}

// Send email to admin with user agent statistics
function sendAdminEmail() {
    $date = date('Y-m-d');
    $filename = "user_agents.txt";
    $contents = file_get_contents($filename);
    $stats = array_count_values(explode(PHP_EOL, $contents));
    $message = "User Agent Statistics for $date:" . PHP_EOL . PHP_EOL;
    foreach ($stats as $ua => $count) {
        $message .= "$ua: $count visits" . PHP_EOL;
    }
    $to = "amrasd424@yahoo.com";
    $subject = "User Agent Statistics for $date";
    $headers = "From: mark@arabjobs.info";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    mail($to, $subject, $message, $headers);
}
?>




<!DOCTYPE html>
<html lang="ar">
<head>
    <title><?php echo $decoded_job; ?> - <?php echo $city; ?> - <?php echo $country; ?> | وظائف <?php echo $country; ?></title>
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
	</style>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="application/ld+json">{"@context": "https://schema.org/","@type": "JobPosting","title": "<?php echo $decoded_job; ?>","description": "<?php echo $value; ?>","identifier": {"@type": "PropertyValue","name": "<?php echo $company; ?>","value": "<?php echo $identifier; ?>"},"hiringOrganization" : {"@type": "Organization","name": "<?php echo $company; ?>","sameAs":"https://www.google.com/search?q=<?php echo $company; ?>","logo": "<?php echo $icon; ?>"},"datePosted": "<?php echo $startdate; ?>","validThrough": "<?php echo $enddate; ?>","employmentType": "<?php echo $dawam; ?>","jobLocation": {"@type": "Place","address": {"@type": "PostalAddress","streetAddress": "<?php echo $city; ?>","addressLocality": "<?php echo $city; ?>","addressRegion": "<?php echo $city; ?>","postalCode": "<?php echo $postalcode; ?>","addressCountry": "<?php echo $country; ?>"}},"baseSalary": {"@type":"MonetaryAmount","currency":"<?php echo $currency; ?>","value": {"@type":"QuantitativeValue","value":<?php echo $salary * 180; ?>,"unitText":"MONTH"}}}</script>
<meta name="description" content="<?php echo $value; ?>">
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
                console.log('Page view tracked successfully.');
            } else {
                console.error('Error tracking page view.');
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
	  <a href="/index.php">الرئيسية</a> &gt; 
	  <a href="/index.php">وظائف</a> &gt; 
	  <a href="/index.php"><?php echo $country; ?> &gt</a>   
	  <span class="current-page"><?php echo $decoded_job; ?></span>
	</div>
	<div id="content">
	<div class="job-suggestions">
	  <h2><?php echo $decoded_job; ?></h2>
	  </div>
	<div><div class="my-table">
<h2>ملخص الوظيفة</h2>
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
        <td><?php echo $salary * 180; ?> <?php echo $currency; ?></td>
      </tr>
      <tr>
        <td>تاريخ الإعلان</td>
        <td><?php echo $startdate1; ?></td>
      </tr>
      <tr>
        <td>تاريخ الإنتهاء</td>
        <td><?php echo $enddate1; ?></td>
      </tr>
    </tbody>
  </table>
</div>
</div>
	<h2>تفاصيل الوظيفة</h2>
	<div><?php echo $value; ?></div>
	 <h2>وظائف مشابهة</h2>
  <div class="job-suggestions">
	<?php
                                              // استعراض البيانات من جدول jobs_apply
                                             $sql = "SELECT job_url FROM jobs WHERE url = '$actual_link' ORDER BY id DESC LIMIT 1";
                                             $result = $conn->query($sql);

                                             if ($result->num_rows > 0) {
                                             $row = $result->fetch_assoc();
                                             if (!empty($row["job_url"])) {
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
                                             $domain = $parsed_url['host'];
                                             $path_with_params = $parsed_url['path'] . (isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '');
        
echo "<li><a href=\"https://{$domain}
{$path_with_params}\">" . htmlspecialchars($job_title) . "</a></li>
";
                                             }
                                        }
                                        } else {
                                        //echo "<li>لا توجد وظائف مقترحة حالياً.</li>";
                                        // إذا كانت قيمة "$row["job_url"]" فارغة، يمكنك إنشاء قيم جديدة لها
                                       
                                           }
                                             } else {
    // رسالة أو إجراء يتم اتخاذه عندما لا توجد صفوف في النتيجة
}
                                       ?></div>
	</div>	
	<h2>التقديم على الوظيفة</h2>
                                       
<?php $domain = $parsed_url['host'] ?? "fghb.xyz"; ?>
	<a href="https://<?php echo $domain; ?>
	
/job_apply.php?job=<?php echo $decoded_job; ?>&country=<?php echo $country; ?>&city=<?php echo $city; ?>&dawam=<?php echo $dawam; ?>&company=<?php echo $company; ?>&salary=<?php echo $salary * 180; ?>&submitted=false">قدم على الوظيفة من هنا</a>
	</div>
	<footer>
		<p>© 2024 - وظائف <?php echo $country; ?></p>
	</footer>
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo Config::$googletagid; ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?php echo Config::$googletagid; ?>');
</script>
</body>
</html>