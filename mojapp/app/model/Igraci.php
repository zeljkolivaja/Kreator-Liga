<?php 

class Igraci
{
    public static function popis()
    {

        $db = Db::getInstance();
        $izraz = $db->prepare("select id,nameOfLeague from league");
        $izraz->execute();
        return $izraz->fetchall();
 

    }


    public static function popisKlubova($id)
    {

        $db = Db::getInstance();
        $izraz = $db->prepare("select id,nameOfTeam from leagueTable where league=$id");
        $izraz->execute();
        return $izraz->fetchall();
 

    }


    public static function insert()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("insert into Players(firstName,lastName,LeagueTable) 
        values (:firstName,:lastName,:LeagueTable)");
        $izraz->execute(self::podaciInsert());
     }



     private static function podaciInsert()
{
    return [
        "firstName"=>Request::post("firstName"),
        "lastName"=>Request::post("lastName"),
        "LeagueTable"=>Request::post("LeagueTable")
  
    ];
}


public static function lista($id)
    {

        $db = Db::getInstance();
        $izraz = $db->prepare("select id,firstName,lastName from Players where Leaguetable=$id;");
        $izraz->execute();
        return $izraz->fetchall();
 

    }



















}