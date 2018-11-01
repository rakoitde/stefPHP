<?php

require __DIR__ . '/../rakoitde/stefPHP/Engine.php';

// Data
$data = ["title"      =>"Sticky Footer Navbar Template for Bootstrap",
         "description"=>"Sticky Footer Navbar Template for Bootstrap",
         "author"     =>"Max Mustermann",
         "brand"      =>"My Navbar",
         "copyright"  =>"(c) Max Mustermann",
         "script"     =>""];

$template = "bs4template.tpl";

$stef = new \rakoitde\stefPHP\Engine($template, $data);
$stef->set("content","My Content");
$stef->set("script","console.log('MyScript')");
echo $stef->get();

?>
