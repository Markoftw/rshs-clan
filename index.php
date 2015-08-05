<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Memberlist</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <?php
        include 'db.conn.php';
        $stmnt = $mysqli->prepare("SELECT * FROM memberlist ORDER BY combat DESC, overall DESC");
        $stmnt->execute();
        echo"<table id='myTable' class='tablesorter'>";
        echo"<thead><th style='width:10%;'># Rank</th><th style='width:10%;'>Member</th><th style='width:10%;'>RSN</th><th style='width:5%;'><img src='img/combat.png' alt='cb' height='20' width='20'></th><th style='width:5%;'><img src='img/total.png' alt='cb' height='27' width='27'></th><th style='width:5%;'><img src='img/attack.gif' alt='cb' height='20' width='20'></th><th style='width:5%;'><img src='img/strength.gif' alt='cb' height='25' width='25'></th><th style='width:5%;'><img src='img/defence.gif' alt='cb' height='25' width='25'></th><th style='width:5%;'><img src='img/range.gif' alt='cb' height='25' width='25'></th><th style='width:5%;'><img src='img/hitpoints.gif' alt='cb' height='25' width='25'></th><th style='width:5%;'><img src='img/magic.gif' alt='cb' height='25' width='25'></th><th style='width:5%;'><img src='img/prayer.gif' alt='cb' height='25' width='25'></th><th style='width:5%;'><img src='img/woodcutting.gif' alt='cb' height='25' width='25'></th></thead>";
        echo "<tbody>";
        $r = 1;
        while($hs = $stmnt->fetch()){
            echo "<tr style='height:37px;'><td>". $r ."</td><td style='color:".$hs['color'].";'>". $hs['realName'] ."</td><td>". $hs['rsn'] ."</td><td>". $hs['combat'] ."</td><td>". $hs['overall'] ."</td><td>". $hs['attack'] ."</td><td>". $hs['strength'] ."</td><td>". $hs['defence'] ."</td><td>". $hs['ranged'] ."</td><td>". $hs['hp'] ."</td><td>". $hs['magic'] ."</td><td>". $hs['prayer'] ."</td><td>". $hs['wc'] ."</td></tr>";
            $r = $r + 1;
        }
        echo"</tbody>";
        echo"</table>";
        ?>
        <a href="admin/index.php">AdminCP</a>
    </body>
</html>
