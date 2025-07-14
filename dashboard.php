<?php
include 'session.php';

switch ($_SESSION['role']) {
  case 'admin':
    header("Location: dashboard_admin.php");
    break;
  case 'artisan':
    header("Location: dashboard_artisan.php");
    break;
  case 'user':
    header("Location: dashboard_user.php");
    break;
  default:
    echo "Invalid role.";
}
?>
