<?php

require __DIR__ . '/../rakoitde/stefPHP/Engine.php';

// Import
$data = ["is_new"=>"is_new is not empty",
         "title"=>"yes, it's new",
         "no"=>"no, it's not new"];
$template = "<p>[!import import.tpl]</p>";

echo "<h2>Import</h2>";
echo "<h3>Data:</h3>";
echo "<pre>".print_r($data,true)."</pre>";
echo "<h3>Template:</h3>";
echo "<pre>".htmlspecialchars($template)."</pre>";
echo "<h3>HTML Result:</h3>";
$stef = new \rakoitde\stefPHP\Engine($template, $data);
echo htmlspecialchars($stef->get());
echo "<h3>Result:</h3>";
echo $stef->get();
echo "<hr>";



?>
