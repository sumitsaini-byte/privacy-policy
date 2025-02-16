<?php
  require('inc/db-config.php');
  
  $id=$_GET['booking_id'];
  $booking_status=$_GET['booking_status'];
  $q="UPDATE booking_order set booking_status='$booking_status' where booking_id=$id ";
  mysqli_query($con,$q);
  header('location:booking_record.php')
  
  ?>