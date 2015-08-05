<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>AdminCP</title>
        <style>
            body{background-color: #C0C0C0;}
        </style>
    </head>
    <body>
        <?php
		ini_set('display_errors',"1");
        session_start();
        include '../class.php';
        include '../db.conn.php';
        $logged = !empty($_SESSION['admin']);
        if (!$logged){
            header('Location: index.php');
            exit;
        }
        if(isset($_POST['update']) && $_POST['update'] == "manual"){
            $sqlrsn = $mysqli->prepare("SELECT rsn FROM memberlist");
            $sqlrsn->execute();
            while ($row = $sqlrsn->fetch()){
                $getstats = new StatsTracker();
                $getstats->grabStats("{$row["rsn"]}");                       
            }
        }elseif (isset($_POST['upload'])) {
            if(!empty($_POST['list'])){      
                $clear = $mysqli->prepare("TRUNCATE TABLE memberlist");
                $clear->execute();
                $text = htmlspecialchars(trim($_POST['list']));
                $text1 = nl2br($text);
                $text2 = explode("<br />", $text1);
                $num_lines = count($text2);
                foreach($text2 as $line_num => $line){
                    $line = preg_replace( "/\r|\n/", "", $line );
                    $line2 = explode(".",$line);
                    if(!empty($line)){
                    $insertMembers = $mysqli->prepare("INSERT INTO memberlist (realName,rsn,color,combat,overall,attack,strength,defence,ranged,hp,magic,prayer,wc) VALUES (:realName,:rsn,:rank,3.00,1,1,1,1,1,1,1,1,1)");
                    $insertMembers->execute(array(
                        "realName" => $line2[0],
                        "rsn" => $line2[1],
                        "rank" => "white"
                        ));
                    }
                }
				echo "<span>Added ". $num_lines ." members. Use the <b>Manual update</b> button to update the memberlist.</span>";
            } else {
                echo "<span>Empty field.</span>";
            }
        } elseif(isset($_POST['mId']) && isset($_POST['membcolor'])){
            $sqlrsn = $mysqli->prepare("UPDATE memberlist SET color=:color WHERE id=:mId");
            $sqlrsn->execute(array(
                "color" => $_POST['membcolor'],
                "mId" => $_POST['mId']
            ));
            echo "<b>Member updated!</b><br/>";
        }
        if(isset($_GET['p']) && $_GET['p'] == "colors"){
            echo "Edit member colors<br/><br/><br/>";
            $stmnt = $mysqli->prepare("SELECT * FROM memberlist ORDER BY combat DESC, overall DESC");
            $stmnt->execute();
            echo"<table border='1'>";
            echo"<thead><th style='width:33%;'>Member</th><th style='width:33%;'>Color</th><th style='width:33%;'>Edit</th></thead>";
            echo "<tbody>";
            while($hs = $stmnt->fetch()){
                echo "<tr><td style='color:".$hs['color'].";'>". $hs['realName'] ."</td><td>".$hs['color']."</td><td><form name='colors' method='post' action='admincp.php?p=colors'><input type='hidden' name='mId' value='".$hs['id']."'><select name='membcolor'><option value='white'>Applicant</option><option value='#FF6EB4'>Member</option><option value='#FF1493'>Advanced</option><option value='#FF4500'>Elite</option><option value='#FD0'>Council</option><option value='purple'>Warlord</option><option value='#FF7F00'>Advisor</option><option value='red'>Leader</option></select><input type='submit' value='Submit'></form></td></tr>";
            }
            echo"</tbody>";
            echo"</table><br/>";
            
        } else { ?>
            <form name="manualUpdate" action="admincp.php" method="POST">
                <input type="hidden" name="update" value="manual">
                <input type="submit" value="Manual update">
            </form>
            (Warning: This may take a while!)
            <br/>
            <br/>
            <span>One member per line</span>
            <form name="memberUpload" action="admincp.php" method="POST">
                <textarea rows='30' cols='20' name='list'>Name.RSN1&#13;&#10;Name.RSN2&#13;&#10;Name.RSN3&#13;&#10;...&#13;&#10;Name.RSN100</textarea><br/>
                <input type="submit" name="upload" value="Update memberlist"/>
            </form>
        <?php                
        } 
        ?>
        <br/>
        <a href="admincp.php?p=colors">Edit ranks</a>
        <br/>
        <a href="admincp.php">Edit memberlist</a>
        <br/>
        <br/>
        <a href="index.php?p=logout">Logout</a>
    </body>
</html>