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
        $izraz = $db->prepare("delete from dioniz_liga . leagueTable where id=:id");
        // $izraz = $db->prepare("delete from dionizliga . leagueTable where id=:id");
        $podaci = [];
        $podaci["id"]=$id;
        $izraz->execute($podaci);
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



    public static function find($id){
        $db = Db::getInstance();
        $izraz = $db->prepare("select * from leagueTable where id=:id");
        $izraz->execute(["id"=>$id]);
        return $izraz->fetch();
    }

    public static function update($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("update leagueTable set 
        nameOfTeam=:nameOfTeam,
        totalPoints=:totalPoints,
        totalGoalsScored=:totalGoalsScored,
        totalGoalsConceded=:totalGoalsConceded,
        league=:league
        where id=:id");
        $podaci = self::podaciupdate();
        $podaci["id"]=$id;
        $izraz->execute($podaci);
    }
    
    

    private static function podaciupdate(){
        return [
            "nameOfTeam"=>Request::post("nameOfTeam"),
            "totalPoints"=>Request::post("totalPoints"),
            "totalGoalsScored"=>Request::post("totalGoalsScored"),
            "totalGoalsConceded"=>Request::post("totalGoalsConceded"),
            "league"=>Request::post("league")
     
        ];
    
 

}



}