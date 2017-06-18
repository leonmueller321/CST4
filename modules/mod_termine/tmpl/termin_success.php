<?php
//include('../model/termin.class.php');

$db = new Database();
$vname = $_POST['vorname'];
$nachname = $_POST['nachname'];
$date = $_POST['date'];
$uhrzeit = $_POST['uhrzeit'];


$user = JFactory::getUser();
$userid = $user->id;

echo "<p>Vielen Dank für Ihr Interesse! Ihr Termin wird so schnell wie möglich bearbeitet.</p>";

$newd = $date . $uhrzeit;
$timestamp = strtotime($newd );
echo "</br>";

$date = date("Y-m-d H:i:s", $timestamp);


$db->insertTermin($date, $vname, $nachname, $userid, 0, "noch nicht bearbeitet");