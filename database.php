<?php

    $servername = "localhost";

    $username = "arabjobs";

    $password = "RseP6X2mZRZZxQQ";

    $dbname = "arabjobs"; 

    $conn = new mysqli($servername, $username, $password, $dbname);
    

    if($conn->connect_error) {

        die("Connection Failed" . $conn->connect_error);

    }
    
    $similarServers = array(
    "lwam.xyz",
    "lwbm.xyz",
    "saudia.arabjobs.info",
    "fghb.xyz",
    "jobs.fghb.xyz",
    "jobs-career.xyz",
    "lefm.xyz",
    "ksa-job.online",
    "jobgr.online",
    "jobsme.site",
    "arabjobs.info",
    "jobtry.cfd",
    "dailyjob.cfd",
    "earthjobs.online",
    "jobs7om.cfd",
    "jobs7om.site",
    "jobshag.store",
    "newjobs.cfd",
    "newjobs.fun",
    "tryjob.fun",
    "jobsnow.cfd",
    "joloig.site",
    "leqm.xyz",
    "jobshag.site",
    "bestjobdeal.cfd",
    "bestjobdeal.site",
    "hiringdeal.cfd",
    "hiringdeal.site",
    "jobku.cfd",
    "jobnij.cfd",
    "jobqat.site",
    "qatjobs.cfd",
    "qatjobs.site",
    "workks.cfd",
    "workks.site",
    "theevergreenemporium.com"
);

   // اختيار قيمة عشوائية من القائمة
   $similarserver = $similarServers[array_rand($similarServers)];
    
    $changedomain = TRUE;
?>