<?php

require __DIR__ . '/../rakoitde/stefPHP/Engine.php';

// IF not empty / not false / not 0
$data = ["is_new"=>"is_new is not empty",
         "title"=>"yes, it's new",
         "no"=>"no, it's not new"];
$template = "<h4>[?is_new][@title][/?is_new]</h4>";

echo "<h2>If not empty / not false / not 0</h2>";
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

// IF equal
$data = ["is_new"=>"Yes",
         "title"=>"yes, it's new",
         "no"=>"no, it's not new"];
$template = "<h4>[?is_new eq Yes][@title][/?is_new]</h4>";

echo "<h2>If equal</h2>";
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

// IF not equal
$data = ["is_new"=>"Yes",
         "title"=>"yes, it's new",
         "no"=>"no, it's not new"];
$template = "<h4>[?is_new != No][@title][/?is_new]</h4>";

echo "<h2>If not equal</h2>";
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


// Lower / Greater Than and Equal Numeric
$data = ["count"=>"2"];
$template = "
<h4>[?count < 2][@count]<2[/?count]</h4>
<h4>[?count = 2][@count]=2[/?count]</h4>
<h4>[?count > 2][@count]>2[/?count]</h4>
";

echo "<h2>If lower / greater / equal (numeric)</h2>";
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

// Lower or Equal / Greater or Equal Numeric
$data = ["count"=>"2"];
$template = "
<h4>[?count <= 2][@count] is lower or equal to 2[/?count]</h4>
<h4>[?count >= 2][@count] is greater or equal to 2[/?count]</h4>
";

echo "<h2>If lower or equal / greater or equal (numeric)</h2>";
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


// Logical
$data = ["a"=>"1",
         "b"=>"0"];
$template = "
<h4>[@a] and 0 = [?a and 0]true[/?a]</h4>
<h4>[@a] or 0 = [?a or 0]true[/?a]</h4>
<h4>[@a] and 1 = [?a and 1]true[/?a]</h4>
<h4>[@a] or 1 = [?a or 1]true[/?a]</h4>
<h4>[@a] xor 0 = [?a xor 0]true[/?a] <--- ToDo</h4>
<h4>[@a] xor 1 = [?a xor 1]true[/?a] <--- ToDo</h4>
<h4>not [@a] / ![@a] = [?a not]true[/?a]</h4>

<h4>[@b] and 0 = [?b and 0]true[/?b]</h4>
<h4>[@b] or 0 = [?b or 0]true[/?b]</h4>
<h4>[@b] and 1 = [?b and 1]true[/?b]</h4>
<h4>[@b] or 1 = [?b or 1]true[/?b]</h4>
<h4>[@b] xor 0 = [?b xor 0]true[/?b] <--- ToDo</h4>
<h4>[@b] xor 1 = [?b xor 1]true[/?b] <--- ToDo</h4>
<h4>not [@b] / ![@b] = [?b not]true[/?b]</h4>
";
echo "<h2>and / or / xor / not (boolean)</h2>";
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
