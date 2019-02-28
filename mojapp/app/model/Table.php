<?php

class Table{

    public static function read($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("
            select
            a.id,
            a.nameOfTeam,
            a.totalPoints,
            a.totalGoalsScored,
            a.totalGoalsConceded,
            b.nameOfLeague
            from leagueTable a left join league b on b.id=a.league
            where b.id=$id
            order by a.totalPoints DESC;
            ");
        $izraz->execute();
        return $izraz->fetchAll();
    }


    public static function delete($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("delete from dionizliga . leagueTable where id=:id");
        $podaci = [];
        $podaci["id"]=$id;
        $izraz->execute($podaci);
    }

    
    public static function find($id){
        $db = Db::getInstance();
        $izraz = $db->prepare("select * from users where id=:id");
        $izraz->execute(["id"=>$id]);
        return $izraz->fetch();
    }

    public static function add()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("insert into leagueTable(nameOfTeam,league) 
        values (:nameOfTeam,:league)");
        $izraz->execute(self::podaci());
    }


    private static function podaci(){
        return [
            "nameOfTeam"=>Request::post("nameOfTeam"),
            "league"=>Request::post("league")
         ];
    }

 

}