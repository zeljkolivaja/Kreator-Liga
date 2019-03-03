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
        inner join leagueTable b on a.id=b.league
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


    read file koji skoro radi





    <?php (array_chunk($tablica, 2)); 
$array = json_decode(json_encode($tablica), true); 



$count = count($array);
 
for ($i=1; $i <= $count -1 ; $i++) { 
    $a = -1;
    $b =0;
    $b+=$i;
    $a+=$i;
    echo "Klub " . $array[$a]["nameOfTeam"] . " vs " . "Klub " . $array[$b]["nameOfTeam"];
    echo "<br />";
 }

?>



<?php
foreach($schedule AS $round => $games){
    echo "Round: ".($round+1)."<BR>";
    foreach($games AS $play){
        echo $play["Home"]." - ".$play["Away"]."<BR>";
    }
    echo "<BR>";
}
?>