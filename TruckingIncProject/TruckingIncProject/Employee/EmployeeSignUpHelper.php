<?php

session_start();
include ('../mysqli_connect.php');
require ('CheckSignedOut.php');

$user = $_POST['EmployeeUsername']; $user = htmlentities($user);
$pass = $_POST['EmployeePassword']; $pass = htmlentities($pass);
$fn = $_POST['EmployeeFirstName']; $fn = htmlentities($fn);
$mi = $_POST['EmployeeMiddleInitial']; $mi = htmlentities($mi);
$ln = $_POST['EmployeeLastName']; $ln = htmlentities($ln);
$str = $_POST['EmployeeStreet']; $str = htmlentities($str);
$cty = $_POST['EmployeeCity']; $cty = htmlentities($cty);
$stt = $_POST['EmployeeState']; $stt = htmlentities($stt);
$zp = $_POST['EmployeeZip']; $zp = htmlentities($zp);
$phn = $_POST['EmployeePhone']; $phn = htmlentities($phn);
$eml = $_POST['EmployeeEmail']; $eml = htmlentities($eml);
$rptPass = $_POST['EmployeeRepeatPassword']; $rptPass = htmlentities($rptPass);

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

  if ($_POST['EmployeeSubmitButton'] == 'RegisterEmployee')
  {

    if (empty($user) || empty($pass) || empty($rptPass) || empty($fn) || empty($mi) || empty($ln) || empty($str) || empty($cty) ||
        empty($stt) || empty($zp) || empty($phn) || empty($eml))
    {
      echo '<form action="EmployeeSignUp.php">';
      echo '<p>ERROR! You must to fill out all fields!</p>';
      echo '<button>Ok</button>';
      echo '</form>';
    }
    else if ($pass != $rptPass)
    {
      echo '<form action="EmployeeSignUp.php">';
      echo '<p>ERROR! The passwords do not match!</p>';
      echo '<button>Ok</button>';
      echo '</form>';
    }
    else
    {
      $createEmployeeQuery =
  		"Insert Into Employee (firstName, middleInitial, lastName, street, city, state, zip, phone, email, WebsiteUsername, WebsitePassword)
  		 Values ('$fn', '$mi', '$ln', '$str', '$cty', '$stt', '$zp', '$phn', '$eml', '$user', AES_ENCRYPT('$pass', 'NACL'))";
      $createEmployeeExecution = @mysqli_query($dbc, $createEmployeeQuery);
      if ($createEmployeeExecution)
      {
        $_SESSION['EmployeeUsername'] = $user;
        $_SESSION['EmployeePassword'] = $pass;
        header('Location: EmployeeHome.php');
      }
      else
      {
        echo '<h1>System Error</h1>';
        echo '<form action="EmployeeSignUp.php">';
        echo '<p>Something went wrong...</p>';
        echo '<button>Ok</button>';
        echo '</form>';

      }
      mysqli_close($dbc);
    }
  }
}
