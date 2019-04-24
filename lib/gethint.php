<?php
// get the q parameter from URL
$q = $_REQUEST["q"];

echo $q === "" ? "no suggestion" : $q;
?>