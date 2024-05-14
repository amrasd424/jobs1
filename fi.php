<?php include('config.php');
include('database.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta name="robots" content="noindex, nofollow">
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
			background-color: #8e96b1;
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
			background-color: #8e96b1;
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
		  color: #8e96b1;
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
<button id="button1">Show English Letters Only</button>
<button id="button2">Show All</button>

<ul id="jobsList">
<?php
if ($ress = $conn->query("SELECT url, job FROM jobs")) {
    while ($ressAssoc = $ress->fetch_assoc()) {
        // Display all jobs initially
        echo '<li><a href="' . $ressAssoc["url"] . '">' . $ressAssoc["job"] . '</a></li>';
    }
}
?>
</ul>

<script>
document.getElementById("button1").addEventListener("click", function() {
    toggleJobs(true);
});

document.getElementById("button2").addEventListener("click", function() {
    toggleJobs(false);
});

function toggleJobs(showOnlyEnglish) {
    var jobs = document.querySelectorAll("#jobsList li");
    jobs.forEach(function(job) {
        var jobText = job.querySelector("a").innerText;
        var isEnglish = /^[a-zA-Z0-9\s\(\)\[\]]+$/.test(jobText);
        //var isEnglish = /^[a-zA-Z0-9\s]+$/.test(jobText);
        if (showOnlyEnglish && isEnglish) {
            job.style.display = "block";
        } else if (!showOnlyEnglish) {
            job.style.display = "block";
        } else {
            job.style.display = "none";
        }
    });
}
</script>

</body>
</html>