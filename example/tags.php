<?php

require __DIR__ . '/../rakoitde/stefPHP/Engine.php';

// Tag in template file
echo "<pre>".htmlspecialchars("<h4>[@title]</h4>")."</pre>";
$stef = new \rakoitde\stefPHP\Engine("tags.tpl");
$stef->set("title","Simple Template Engine for PHP - tags.tpl");
echo $stef->get();
echo "<hr>";

// tag in template string
echo "<pre>".htmlspecialchars("<h4>[@title]</h4>")."</pre>";
$stef = new \rakoitde\stefPHP\Engine("<h4>[@title]</h4>");
$stef->set("title","Simple Template Engine for PHP - string");
echo $stef->get();
echo "<hr>";

// tag in template file with data array
echo "<pre>".htmlspecialchars("<h4>[@title] - [@section]</h4>")."</pre>";
$data = array("title"=>"Simple Template Engine for PHP",
              "section"=>"data array");
$stef = new \rakoitde\stefPHP\Engine("<h4>[@title] - [@section]</h4>", $data);
echo $stef->get();
echo "<hr>";

?>
