<?php
// Get the current domain
$domain = $_SERVER['HTTP_HOST']; 

// Default header style for amr.com
$headerStyle = [
    'background-color' => '#8eb74d',
    'color' => '#fff',
    'padding' => '20px',
    'text-align' => 'right'
];

// Adjust header style based on domain
if ($domain == 'ahmed.com') {
    $headerStyle = [
        'background-color' => '#ffffff'
    ];
} elseif ($domain == 'mego.com') {
    $headerStyle = [
        'background-color' => '#0564fw'
    ];
}
?>