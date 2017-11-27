<link rel="stylesheet" href="common.css" type="text/css">
<?php
/**
 * Created by PhpStorm.
 * User: josephcantrell14
 * Date: 7/20/2017
 * Time: 3:26 PM
 */

require "database.php";
$db = new Database(true);

$id = $_POST['id'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$status = $_POST['status'];
$Mgr = $_POST['Mgr'];
$supervisor = $_POST['supervisor'];
$dept = $_POST['dept'];

echo "<div align='center' id='main'>
    <a class='button' href='index.php'>Return to Table</a><br><br><br>";

if ($id == '' || $firstName == '' || $lastName == '' || $email == '') {
    die("Error!  All fields are required.");
}
if ($status == 'Error') {
    die("Error!  Please choose a status.");
}
if ($Mgr == 'None') {
    $Mgr = '';
} else if ($Mgr == 'Error') {
    die("Error!  Please choose a manager.");
}
if ($supervisor == 'Error') {
    die("Error!  Please choose a supervisor.");
}/*
$supervisorResultArray = mysqli_fetch_array($db->query("SELECT firstName, lastName FROM `person` WHERE gtAccount = '$supervisorId'"));
$supervisorName = $supervisorResultArray[0]." ".$supervisorResultArray[1];*/
if ($dept == 'None') {
    $dept = '';
} else if ($dept == 'Error') {
    die("Error!  Please choose a department.");
} else if ($dept == 'CoC') {
    $dept = 'Computing College of';
}

$idQuery = mysqli_fetch_array($db->query("SELECT gtAccount FROM `person` WHERE gtAccount = '$id'"))['gtAccount'];
if ($idQuery == $id) {
    die("Error: This user with id $id already exists in the database.");
}

$db->query("INSERT INTO `person`
    (`gtAccount`, `firstName`, `lastName`, `email`, `status`, `Mgr`, `supervisor`, `dept`)
    VALUES ('$id', '$firstName', '$lastName', '$email', '$status', '$Mgr', '$supervisor', '$dept')");

echo "<p>Successfully added user.</p>
    </div>";
?>