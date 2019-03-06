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
        b.nameOfLeague,
        c.pointsPerWin,
        b.id as sifra,
        c.pointsPerDraw
        from leagueTable a left join league b on b.id=a.league
        inner join gameType c on b.gameType=c.id
        where b.id=$id
        order by a.totalPoints DESC, a.totalGoalsScored DESC, a.totalGoalsConceded ASC;");
        $izraz->execute();
        return $izraz->fetchAll();
    }


    public static function delete($id)
    {
        $db = Db::getInstance();
        //online
        $izraz = $db->prepare("delete from dioniz_liga . leagueTable where id=:id");
        //offline
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

private static function podacigame(){
    return [
        "homeTeamGoals"=>Request::post("homeTeamGoals"),
        "awayTeamGoals"=>Request::post("awayTeamGoals"),
        "league"=>Request::post("league")

 
    ];
}


private static function podacigameHomeTeam(){
    return [
        "homeTeam"=>Request::post("homeTeam")
  
    ];
}


private static function podacigameAwayTeam(){
    return [
        "awayTeam"=>Request::post("awayTeam")
  
    ];
}




public static function insert()
{
    $db = Db::getInstance();
    $izraz = $db->prepare("select id from leagueTable where nameOfTeam=:homeTeam;");
    $izraz->execute(self::podacigameHomeTeam());
    $homeTeam = $izraz->fetchColumn();
 
    $db = Db::getInstance();
    $izraz = $db->prepare("select id from leagueTable where nameOfTeam=:awayTeam;");
    $izraz->execute(self::podacigameAwayTeam());
    $awayTeam = $izraz->fetchColumn();



    $izraz = $db->prepare("insert into game(homeTeamGoals,awayTeamGoals,league,homeTeam,AwayTeam)
    values (:homeTeamGoals,:awayTeamGoals,:league,$homeTeam,$awayTeam);");
    $izraz->execute(self::podacigame());
 
}


 
    public static function rezultati($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("
        select 
        *
        from game where league=$id;");
        $izraz->execute();
        return $izraz->fetchAll();
    }


//  a.id,
// b.nameOfTeam,
// c.homeTeamGoals
// from league a right join leagueTable b on a.id=b.league
// inner join game c on a.id=b.league 
// where a.id=6;

}