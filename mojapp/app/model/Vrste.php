<?php

class Vrste
{

    public static function read()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("select id,gameName,description,pointsPerWin,pointsPerDraw,pointsPerLoss from gameType");
        $izraz->execute();
        return $izraz->fetchAll();
    }


    public static function add()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("insert into gameType(gameName,pointsPerWin,pointsPerDraw,pointsPerLoss,description) 
        values (:gameName,:pointsPerWin,:pointsPerDraw,:pointsPerLoss,:description)");
         $izraz->execute(self::podaci());
    }

    private static function podaci()
    {
        return [
            "gameName"=>Request::post("gameName"),
            "pointsPerWin"=>Request::post("pointsPerWin"),
            "pointsPerDraw"=>Request::post("pointsPerDraw"),
            "pointsPerLoss"=>Request::post("pointsPerLoss"),
            "description"=>Request::post("description")

         ];
    }


    private static function podaciEdit()
    {
        return [
            "gameName"=>Request::post("gameName"),
            "pointsPerWin"=>Request::post("pointsPerWin"),
            "pointsPerDraw"=>Request::post("pointsPerDraw"),
            "pointsPerLoss"=>Request::post("pointsPerLoss"),
            "id"=>Request::post("id"),
            "description"=>Request::post("description")

         ];
    }



    public static function readSport($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("
        select * from gameType where id=$id;");
        $izraz->execute();
        return $izraz->fetchAll();
    }



    public static function update()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("update gameType set 
        gameName=:gameName,
        pointsPerWin=:pointsPerWin,
        pointsPerDraw=:pointsPerDraw,
        pointsPerLoss=:pointsPerLoss,
        description=:description
        where id=:id");
        $izraz->execute(self::podaciEdit());
    }


    public static function delete($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("delete from gameType where id=:id");
        $podaci = [];
        $podaci["id"]=$id;
        $izraz->execute($podaci);
    }




}