<?php
ini_set('display_errors',"1");
class StatsTracker {
    
    public function grabStats($player) {
        $url = 'http://services.runescape.com/m=hiscore_oldschool/index_lite.ws?player=' . $player;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.001 (windows; U; NT4.0; en-US; rv:1.0) Gecko/25250101');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $jagexdb = curl_exec($ch);
        //$info = curl_getinfo($ch);
        //print_r($info);
        //echo "<br />";
        curl_close($ch);
        if(strpos($jagexdb,'Page not found') != false) {
            echo "<span style='color:red';>" . $player ." NOT found!</span><br />";
            //$skills = array(3.00, 1, 1, 1, 1, 1, 1, 1, 1, 1, $player);
            //$this->insertStats($skills);
        } else {
            $playerStats = preg_split('/[\s]+/', $jagexdb);

            $overall = $playerStats[0];
            $att = $playerStats[1];
            $def = $playerStats[2];
            $str = $playerStats[3];
            $hp = $playerStats[4];
            $ranged = $playerStats[5];
            $prayer = $playerStats[6];
            $magic = $playerStats[7];
            $woodcutting = $playerStats[9];

            list($overallRank, $overallLvl, $overallXP) = explode(",", $overall);
            list($attRank, $attLvl, $attXP) = explode(",", $att);
            list($defRank, $defLvl, $defXP) = explode(",", $def);
            list($strRank, $strLvl, $strXP) = explode(",", $str);
            list($hpRank, $hpLvl, $hpXP) = explode(",", $hp);
            list($rangedRank, $rangedLvl, $rangedXP) = explode(",", $ranged);
            list($prayerRank, $prayerLvl, $prayerXP) = explode(",", $prayer);
            list($magicRank, $magicLvl, $magicXP) = explode(",", $magic);
            list($wcRank, $wcLvl, $wcXP) = explode(",", $woodcutting);

            $base_cb = (0.25 * ($defLvl + $hpLvl + floor($prayerLvl / 2.0)));
            $melee_cb = (0.325 * ($attLvl + $strLvl));
            $range_cb = (0.325 * (floor($rangedLvl / 2.0) + $rangedLvl));
            $mage_cb = (0.325 * (floor($magicLvl / 2.0) + $magicLvl));
            $cb = ($base_cb + max($melee_cb, max($range_cb, $mage_cb)));   
            $combat = round($cb, 2);
            
            $skills = array($combat, $overallLvl, $attLvl, $strLvl, $defLvl, $rangedLvl, $hpLvl, $magicLvl, $prayerLvl, $wcLvl, $player);

            $this->insertStats($skills);
        }
    }
    
    public function insertStats($skills) {
        global $mysqli;
        $stmnt = $mysqli->prepare("UPDATE memberlist SET combat=:cb, overall=:overall, attack=:att, strength=:str, defence=:def, ranged=:range , hp=:HP, magic=:mage, prayer=:pray, wc=:WC WHERE rsn=:rsn");
        $stmnt->execute(array(
            'cb' => $skills[0],
            'overall' => $skills[1],
            'att' => $skills[2],
            'str' => $skills[3],
            'def' => $skills[4],
            'range' => $skills[5],
            'HP' => $skills[6],
            'mage' => $skills[7],
            'pray' => $skills[8],
            'WC' => $skills[9],
            'rsn' => $skills[10]
        ));
        if ($stmnt->rowCount() == 0 || $stmnt->rowCount() == 1) {
            echo "<span style='color:#33CC33';>Username " . $skills[10] . " has been found.</span><br />";
        }
    }
    
}

?>