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
        $izraz = $db->prepare("select * from Players where Leaguetable=$id;");
        $izraz->execute();
        return $izraz->fetchall();


    }



    public static function topScorers($id)
    {

        $db = Db::getInstance();
        $izraz = $db->prepare("select
        play.firstName,
        play.lastName,
        play.totalGoalsScored,
        lt.league,
        lt.nameOfTeam
        from Players play inner join
        leagueTable lt on 
        lt.id=play.LeagueTable
        where league=$id
        order by play.totalGoalsScored DESC;");
        $izraz->execute();
        return $izraz->fetchall();


    }




    public static function igracEdit($id)
    {

        $db = Db::getInstance();
        $izraz = $db->prepare("select * from Players where id=$id;");
        $izraz->execute();
        return $izraz->fetchall();

 

    }


    public static function update()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("update Players set 
        firstName=:firstName,
        lastName=:lastName,
        totalGoalsScored=:totalGoalsScored,
        totallYellowCards=:totallYellowCards,
        totallRedCards=:totallRedCards
        where id=:id");
        $podaci = self::podaci();
        $izraz->execute($podaci);

    }


    private static function podaci()
{
    return [
        "firstName"=>Request::post("firstName"),
        "lastName"=>Request::post("lastName"),
        "totalGoalsScored"=>Request::post("totalGoalsScored"),
        "totallYellowCards"=>Request::post("totallYellowCards"),
        "totallRedCards"=>Request::post("totallRedCards"),
        "id"=>Request::post("id")
    ];
}



public static function delete($id)
{
    $db = Db::getInstance();
    $izraz = $db->prepare("delete from Players where id=:id");
    $podaci = [];
    $podaci["id"]=$id;
    $izraz->execute($podaci);
}


}