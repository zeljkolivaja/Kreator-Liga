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



    public static function readUpdate($id)
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
        where b.id=$id;");
        $izraz->execute();
        return $izraz->fetchAll();
    }



    public static function delete($id)
    {
        $db = Db::getInstance();
        //online
        // $izraz = $db->prepare("delete from dioniz_liga . leagueTable where id=:id");
        //offline
        $izraz = $db->prepare("delete from dionizliga . leagueTable where id=:id");
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




private static function podaciUpdateHome(){
    return [
         "homeTeamGoals"=>Request::post("homeTeamGoals"),
        "awayTeamGoals"=>Request::post("awayTeamGoals"),
        "totalPointsWin"=>Request::post("totalPointsWin"),
        "league"=>Request::post("league")

 
    ];
}

private static function podaciUpdateAwayLost(){
    return [
        "homeTeamGoals"=>Request::post("homeTeamGoals"),
        "awayTeamGoals"=>Request::post("awayTeamGoals"),
        "league"=>Request::post("league")

 
    ];
}

private static function draw(){
    return [
        "homeTeamGoals"=>Request::post("homeTeamGoals"),
        "totalPointsDraw"=>Request::post("totalPointsDraw"),
        "awayTeamGoals"=>Request::post("awayTeamGoals"),
        "league"=>Request::post("league"),
        
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

     $homeGoals = Request::post("homeTeamGoals");
    $awayGoals = Request::post("awayTeamGoals");
 

//update rezultata (leaguetable)

if ($homeGoals > $awayGoals) {
    $izraz = $db->prepare("update leagueTable set 
    totalPoints=totalPoints + :totalPointsWin,
    totalGoalsScored=totalGoalsScored + :homeTeamGoals,
    totalGoalsConceded=totalGoalsConceded + :awayTeamGoals,
    league=:league
    where id=$homeTeam");
    $izraz->execute(self::podaciUpdateHome());


    $izraz = $db->prepare("update leagueTable set 
    totalGoalsScored=totalGoalsScored + :awayTeamGoals,
    totalGoalsConceded=totalGoalsConceded + :homeTeamGoals,
    league=:league
    where id=$awayTeam");
    $izraz->execute(self::podaciUpdateAwayLost());


}elseif ($homeGoals<$awayGoals) {
    $izraz = $db->prepare("update leagueTable set 
    totalPoints=totalPoints + :totalPointsWin,
    totalGoalsScored=totalGoalsScored + :awayTeamGoals,
    totalGoalsConceded=totalGoalsConceded + :homeTeamGoals,
    league=:league
    where id=$awayTeam");
    $izraz->execute(self::podaciUpdateHome());

    $izraz = $db->prepare("update leagueTable set 
    totalGoalsScored=totalGoalsScored + :homeTeamGoals,
    totalGoalsConceded=totalGoalsConceded + :awayTeamGoals,
    league=:league
    where id=$homeTeam");
    $izraz->execute(self::podaciUpdateAwayLost());

    
}
elseif ($homeGoals===$awayGoals) {
    $izraz = $db->prepare("update leagueTable set 
    totalPoints=totalPoints + :totalPointsDraw,
    totalGoalsScored=totalGoalsScored + :homeTeamGoals,
    totalGoalsConceded=totalGoalsConceded + :awayTeamGoals,
    league=:league
    where id=$homeTeam");
    $izraz->execute(self::draw());

    $izraz = $db->prepare("update leagueTable set 
    totalPoints=totalPoints + :totalPointsDraw,
    totalGoalsScored=totalGoalsScored + :awayTeamGoals,
    totalGoalsConceded=totalGoalsConceded + :homeTeamGoals,
    league=:league
    where id=$awayTeam");
    $izraz->execute(self::draw());

    
}

  
}

 
    public static function rezultati($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("
        select 
            game.*
            , a.nameOfTeam AS hometeam
            , b.nameOfTeam AS awayteam 
            FROM game 
            inner join leagueTable as a on a.id = game.homeTeam 
            inner join leagueTable as b on b.id = game.awayTeam
            where game.league=$id; 
        ");
        $izraz->execute();
        return $izraz->fetchAll();
    }




    public static function deleteutakmice($id)
    {
        

        $db = Db::getInstance();
        $izraz = $db->prepare("select homeTeamGoals from game where id=:id;");
        $podaci = [];
        $podaci["id"]=$id;
        $izraz->execute($podaci);
        $homeGoals = $izraz->fetchColumn();

        $db = Db::getInstance();
        $izraz = $db->prepare("select homeTeam from game where id=:id;");
        $podaci = [];
        $podaci["id"]=$id;
        $izraz->execute($podaci);
        $homeTeam = $izraz->fetchColumn();

        $db = Db::getInstance();
        $izraz = $db->prepare("select homeTeamGoals from game where id=:id;");
        $podaci = [];
        $podaci["id"]=$id;
        $izraz->execute($podaci);
        $homeGoals = $izraz->fetchColumn();


        $db = Db::getInstance();
        $izraz = $db->prepare("select awayTeamGoals from game where id=:id;");
        $podaci = [];
        $podaci["id"]=$id;
        $izraz->execute($podaci);
        $awayGoals = $izraz->fetchColumn();


        $db = Db::getInstance();
        $izraz = $db->prepare("select league from game where id=:id;");
        $podaci = [];
        $podaci["id"]=$id;
        $izraz->execute($podaci);
        $league = $izraz->fetchColumn();



        $db = Db::getInstance();
        $izraz = $db->prepare("select awayTeam from game where id=:id;");
        $podaci = [];
        $podaci["id"]=$id;
        $izraz->execute($podaci);
        $awayTeam = $izraz->fetchColumn();




        $db = Db::getInstance();
        $izraz = $db->prepare("
            select
            b.pointsPerWin
            from league a inner join gameType b on b.id=a.gameType
            where a.id=$league; 
            ");
        $izraz->execute();
        $win = $izraz->fetchColumn();




        $db = Db::getInstance();
        $izraz = $db->prepare("
            select
            b.pointsPerDraw
            from league a inner join gameType b on b.id=a.gameType
            where a.id=$league; 
            ");
        $izraz->execute();
        $draw = $izraz->fetchColumn();


        $db = Db::getInstance();
        $izraz = $db->prepare("update leagueTable set 
        totalGoalsScored= totalGoalsScored - $homeGoals,
        totalGoalsConceded=totalGoalsConceded - $awayGoals
        where id=:id");
        $podaci = [];
        $podaci["id"]=$homeTeam;
        $izraz->execute($podaci);


        $db = Db::getInstance();
        $izraz = $db->prepare("update leagueTable set 
        totalGoalsScored= totalGoalsScored - $awayGoals,
        totalGoalsConceded=totalGoalsConceded - $homeGoals
        where id=:id");
        $podaci = [];
        $podaci["id"]=$awayTeam;
        $izraz->execute($podaci);


        if($homeGoals == $awayGoals){

            $db = Db::getInstance();
            $izraz = $db->prepare("update leagueTable set 
            totalPoints=totalPoints - $draw
             where id=:id");
            $podaci = [];
            $podaci["id"]=$homeTeam;
            $izraz->execute($podaci); 
            
            $db = Db::getInstance();
            $izraz = $db->prepare("update leagueTable set 
            totalPoints=totalPoints - $draw
             where id=:id");
            $podaci = [];
            $podaci["id"]=$awayTeam;
            $izraz->execute($podaci);  

        }


        if($homeGoals > $awayGoals){

            $db = Db::getInstance();
            $izraz = $db->prepare("update leagueTable set 
            totalPoints=totalPoints - $win
             where id=:id");
            $podaci = [];
            $podaci["id"]=$homeTeam;
            $izraz->execute($podaci);    

        }

        if($homeGoals < $awayGoals){

            $db = Db::getInstance();
            $izraz = $db->prepare("update leagueTable set 
            totalPoints=totalPoints - $win
             where id=:id");
            $podaci = [];
            $podaci["id"]=$awayTeam;
            $izraz->execute($podaci);    

        }


        $db = Db::getInstance();
        $izraz = $db->prepare("delete from game where id=:id");
        $podaci = [];
        $podaci["id"]=$id;
        $izraz->execute($podaci);
    }





 
}
