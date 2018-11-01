<?php

require __DIR__ . '/../rakoitde/stefPHP/Engine.php';

// Key Value Loop
$data = ["name"=>"Ralf",
         "surname"=>"Kornberger",
         "location"=>"Germany"];
$template = "[%loop]<p><b>Key:</b> [@key] <b>Value:</b> [@value]</p>[/%loop]";

echo "<h2>Key Value Loop</h2>";
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


// Array Loops
$data = ["persons"=> [["name"=>"Ralf", "surname"=>"Kornberger"],
                      ["name"=>"Max",  "surname"=>"Mustermann"]]];
$template = "[%persons]<p>[@surname], [@name]</p>[/%persons]";

echo "<h2>Array Loop</h2>";
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
