<?php

class Vrste{

    public static function read(){
        $db = Db::getInstance();
        $izraz = $db->prepare("select gameName,description,pointsPerWin,pointsPerDraw,pointsPerLoss from gameType");
        $izraz->execute();
        return $izraz->fetchAll();
    }

}