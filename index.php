<?php include('config.php');
include('database.php');
include('alaisstyle.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>وظائف</title>
	<style type="text/css">
		@font-face {
			font-family: 'Jazeera';
			src: url('fonts/Al-Jazeera-Arabic-Bold.eot');
			src: url('fonts/Al-Jazeera-Arabic-Boldd41d.eot?#iefix') format('embedded-opentype'),
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
		
		body {
			min-width: 400px;
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
			min-height: 300px;
			background-image: url(background.png);
            height: 200px;
			background-color: #eee;
			padding: 30px;
			text-align: center;
			display: flex;
		    justify-content: center;
		    align-items: center;
		}
#main-txt1 {
		  
		  color: #ae3d3c;
		  background-image: url(background.png);		
		  background-repeat: repeat;
		  height: 100%;
		  padding: 30px;
		  font-size: 22px;
		}
		#search-bar input[type="text"] {
			font-family: "Jazeera",sans-serif ;
			padding: 10px;
			border: none;
			width: 70%;
			margin-right: 10px;
			border-radius: 20px;
		}

		#search-bar button[type="submit"] {
			font-family: "Jazeera",sans-serif ;
			padding: 10px;
			border: none;
			background-color: <?php echo $headerStyle['background-color']; ?>;
			color: #fff;
			cursor: pointer;
			border-radius: 10px;
		}

		footer {
			background-color: #333;
			color: #fff;
			padding: 20px;
			text-align: center;
		}

		#main-txt {
		  min-height: 300px;
		  color: #ae3d3c;
		  background-image: url(background.png);		
		  background-repeat: repeat;
		  display: flex;
		  justify-content: center;
		  align-items: center;
		  height: 100%;
		  padding: 30px;
		  font-size: 25px;
		}

		#main-txt span {
		  text-align: center;
		}
		.search-form {
		  /* optional: set a max-width for the form */
		  width: 100%;
		}		
		.search-select {
			width: 25%;
			height: 30px;
			margin-top: 20px;
			border-radius: 20px;
			font-family: 'JAZEERA';
			text-align: center;
		}
	</style>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
	<header>
		<h1>وظائف</h1>
	</header>
	<div id="search-bar">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<form method="get" class="search-form" action="/jobs.php">
	<button type="submit">ابحث</button>
	<input type="text" name="job" id="search" placeholder="ابحث في ملايين فرص العمل">
	<select class="search-select" name="country" id="country">
		<option value="">اختر الدولة</option>
		<option value="مصر">مصر</option>
		<option value="السعودية">السعودية</option>
		<option value="الامارات">الامارات</option>
		<option value="قطر">قطر</option>
		<option value="البحرين">البحرين</option>
		<option value="الكويت">الكويت</option>
		<option value="عمان">عمان</option>
		<option value="الاردن">الاردن</option>
		<!-- Add more options as needed -->
	</select>
	<select class="search-select" name="city" id="city">
		<option value="">اختر المدينة</option>
	</select>
</form>
<script>
$(document).ready(function() {
  $('form').submit(function(e) {
    var searchInput = $('#search').val();
    if (searchInput.trim() === '') {
      e.preventDefault(); // prevent form submission
      $('#search').val('وظائف اليوم'); // set default search text
      $(this).submit(); // submit form again with default search text
    }
  });
});
</script>

<script>
// Get references to the country and city select elements
var countrySelect = document.getElementById("country");
var citySelect = document.getElementById("city");

// Define a function to load cities based on the selected country
function loadCities() {
	// Get the selected country value
	var countryValue = countrySelect.value;
	
	// Only load cities if a country is selected
	if (countryValue !== "") {
		// Make an AJAX request to a PHP script that returns the cities for the selected country
		var xhr = new XMLHttpRequest();
		xhr.open("GET", "get_cities.php?country=" + countryValue, true);
		xhr.onload = function() {
			if (xhr.status === 200) {
				// Clear the current city options
				citySelect.innerHTML = "<option value=''>اختر المدينة</option>";
				
				// Add the new city options based on the response
				var cities = JSON.parse(xhr.responseText);
				for (var i = 0; i < cities.length; i++) {
					var option = document.createElement("option");
					option.value = cities[i];
					option.textContent = cities[i];
					citySelect.appendChild(option);
				}
			}
		};
		xhr.send();
	}
}

// Add an event listener to the country select element to update the cities when the country is changed
countrySelect.addEventListener("change", loadCities);
</script>

	</div>
		<div id="main-txt"> 
	  <span>اغتنم الفرصة الان وابحث عن وظيفة أحلامك. لدينا ملايين فرص العمل الشاغرة بانتظارك !!!</span>
</div>
<div id="main-txt1">
</div>
	<footer>
		<p>2024 - وظائف</p>
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