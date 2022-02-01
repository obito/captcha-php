<?php

session_start();

header("Content-Type: Image/png");

$width = 300;
$height = 150;

/*
    Consignes: 
        - Crée un dossier "font" avec dedans 3 polices au format TTF (dafont)
        - Intégrer dans l'image le texte en respectant:
            - Une couleur aléatoire pour le fond
            - Une couleur aléatoire par char
            - Une angle aléatoire par char
            - Une taille et position aléatoires par char
            - Une police aléatoire par char en cherchant dans le dossier font
            - Des formes aléatoires derrière les caractères avec des couleurs déjà utilisées
*/

$xChar = ($width/2)-130;
$yChar = 20;

function generateColors() {
    $colors = [];

    for ($i=0;$i<=9;$i++) {
        array_push($colors, array(rand(0, 255), rand(0, 255), rand(0, 255)));
    }

    return $colors;
}

function getFonts() {
    $scandir = scandir("./font");
    $fontFile = [];

    foreach ($scandir as $file) {
        $fullPath = realpath($file);
        if (!$fullPath) {
            array_push($fontFile, "./font/" . $file);
        }
    }

    return $fontFile;
}

function generateRandomString() {
    $char = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    return substr(str_shuffle($char), 0, 1);
}


$image = imagecreate($width, $height);

// we only generate dark color backgrounds, so from 0 to 100
$back = imagecolorallocate($image, rand(0, 100), rand(0, 100), rand(0, 100));

$fonts = getFonts();

$captchaCode = "";

for ($i=0;$i<=rand(6,8);$i++) {
    // generate only clear color from char, from 100 to 255
    $color1 = imagecolorallocate($image, rand(100, 255), rand(100, 255), rand(100, 255));
    $yChar = rand(40, 60);
    $dot = rand(0, 1);

    if ($dot == 1) {
        imageellipse($image, $xChar, $yChar, rand(10, 30), rand(10, 30), $color1);
    } else {
        imageline($image, $xChar, $yChar, rand($xChar, 300), rand($yChar, 150), $color1);
    }

    $char = generateRandomString();

    // append char to captchaCode
    $captchaCode .= $char;

    imagettftext($image, rand(20, 30), rand(-5, 5), $xChar, $yChar, $color1, $fonts[array_rand($fonts)], $char);

    $xChar += rand(20, 35);
}

$_SESSION["captchaCode"] = $captchaCode;

imagepng($image);

imagedestroy($image);

