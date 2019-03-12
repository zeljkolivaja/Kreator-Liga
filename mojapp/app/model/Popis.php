<?php

class Popis{

    public static function read(){
        $db = Db::getInstance();
        $izraz = $db->prepare("select
		a.nameOfLeague,
        a.id,
		a.leagueEmblem,
        a.users,
		a.description,
        c.gameName,
        count(b.league) as ukupno
        from league a 
        left join leagueTable b on a.id=b.league
        left join gameType c on c.id=a.gameType 
        
        group by
        a.nameOfLeague,
        a.id,
        a.leagueEmblem,
        a.users,
		a.description,
        c.gameName");
        $izraz->execute();
        return $izraz->fetchAll();
    }


public static function find($id){
        $db = Db::getInstance();
        $izraz = $db->prepare("select * from league where id=:id");
        $izraz->execute(["id"=>$id]);
        return $izraz->fetch();
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
    $izraz->execute(self::podaciupdate());
}




public static function update($id)
{
    $db = Db::getInstance();
    $izraz = $db->prepare("update league set 
    nameOfLeague=:nameOfLeague,
    description=:description,
    gameType=:gameType,
    users=:users
    where id=:id");
    $podaci = self::podaci();
    $podaci["id"]=$id;
    $izraz->execute($podaci);
}



 

private static function podaci(){
    return [
        "nameOfLeague"=>Request::post("nameOfLeague"),
        "description"=>Request::post("description"),
        "gameType"=>Request::post("gameType"),
        "users"=>Request::post("users"),
        "id"=>Request::post("id")


    ];
}


private static function podaciupdate(){
    return [
        "nameOfLeague"=>Request::post("nameOfLeague"),
        "description"=>Request::post("description"),
        "gameType"=>Request::post("gameType"),
        "users"=>Request::post("users")
 

    ];
}
 

}

 