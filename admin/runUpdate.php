<?php
include '../class.php';
include '../db.conn.php';
ini_set('display_errors',"1");

$sqlrsn = $mysqli->prepare("SELECT rsn FROM memberlist");
$sqlrsn->execute();
while ($row = $sqlrsn->fetch()){
    $getstats = new StatsTracker();
    $getstats->grabStats("{$row["rsn"]}");                       
}