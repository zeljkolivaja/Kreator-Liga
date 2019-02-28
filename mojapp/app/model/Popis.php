<?php

class Popis{

    public static function read(){
        $db = Db::getInstance();
        $izraz = $db->prepare("select
        a.id,
        a.nameOfLeague,
        a.leagueEmblem,
        a.users,
        a.description,
        b.gameName
        gameType from league a inner join gameType b on b.id=a.gameType;");
        $izraz->execute();
        return $izraz->fetchAll();
    }


    

public static function delete($id)
{
    $db = Db::getInstance();
    $izraz = $db->prepare("delete from league where id=:id");
    $podaci = [];
    $podaci["id"]=$id;
    $izraz->execute($podaci);
}



public static function readgametype(){
    $db = Db::getInstance();
    $izraz = $db->prepare("select id,gameName from gameType");
    $izraz->execute();
    return $izraz->fetchAll();
}





public static function add()
{
    $db = Db::getInstance();
    $izraz = $db->prepare("insert into league (nameOfLeague,description,gameType,users) 
    values (:nameOfLeague,:description,:gameType,:users)");
    $izraz->execute(self::podaci());
}


 

private static function podaci(){
    return [
        "nameOfLeague"=>Request::post("nameOfLeague"),
        "description"=>Request::post("description"),
        "gameType"=>Request::post("gameType"),
        "users"=>Request::post("users")

    ];
}

 

}

 