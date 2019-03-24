<?php

class TableController
{

    public function __construct()
    {
    if(!Session::getInstance()->isLogiran()){
        $view = new View();
        $view->render('index',["poruka"=>"Nemate ovlasti"]);
        exit;
    }
    }

 
    function index($id)
    {
        $array = json_decode(json_encode(Table::readUpdate($id)), true); 
        $members = array_column($array , 'nameOfTeam');
        // print_r($members);
        
         
        function scheduler($members){
            if (count($members)%2 != 0){
                array_push($members,"slobodan");
            }
            $away = array_splice($members,(count($members)/2));
            $home = $members;
            for ($i=0; $i < count($home)+count($away)-1; $i++){
                for ($j=0; $j<count($home); $j++){
                    $round[$i][$j]["Home"]=$home[$j];
                    $round[$i][$j]["Away"]=$away[$j];
                }
                if(count($home)+count($away)-1 > 2){
                    // array_unshift($away,array_shift(array_splice($home,1,1)));
                    array_unshift($away, current(array_splice($home,1,1)) ); 
                    array_push($home,array_pop($away));
                }
            }
            return $round;
        }
        $schedule = scheduler($members);
    

        $view = new View();
        $view->render('tables/index',
        ["tablica"=>Table::read($id),
        "schedule"=>$schedule
        ]
    );
    }
    
    



    function delete($id)
    {
            Table::delete($id);
            $this->home();
    }


    function resetiraj($id)
    {
        Table::resetiraj($id);
        $this->home();

    }


    function prepareadd($id)
    {
        $view = new View();
        $view->render(
            'tables/noviklub',
            [
            "poruka"=>$id
            ]
        );
    }


    function add()
    {
            $kontrola = $this->kontrolaadd();
            if($kontrola===true){
            Table::add();
            $this->home();
        }else{
            $view = new View();
            $view->render(
                'tables/poruka',
                [
                "poruka"=>$kontrola
                ]
            );
    
    }
}

    
    function home()
    {
        $view = new View();
        $view->render(
            'lige/index',
            [
            "popis"=>Popis::read()
            ]
        );
    }


    function prepareedit($id)
    {
        $view = new View();
        $korisnik = Table::find($id);
        $_POST["id"]=$korisnik->id;
        $_POST["nameOfTeam"]=$korisnik->nameOfTeam;
        $_POST["totalPoints"]=$korisnik->totalPoints;
        $_POST["totalGoalsScored"]=$korisnik->totalGoalsScored;
        $_POST["totalGoalsConceded"]=$korisnik->totalGoalsConceded;
        $_POST["league"]=$korisnik->league;
    
    
        $view->render(
            'tables/edit',
            [
            "poruka"=>""
            ]
        );
    }
    

    function edit($id)
    {
        $_POST["id"]=$id;
        $kontrola = $this -> kontrolaedit();
        if ($kontrola===true) {
            Table::update($id);
            $this->home();
        }else{
            $view = new View();
            $view->render(
                'tables/poruka',
                [
                "poruka"=>$kontrola
                ]
            );
        }               
    }

        
    function kontrolainsert2(){

        $db = Db::getInstance();
        $izraz = $db->prepare("select id from leagueTable where nameOfTeam=:homeTeam;");
        $izraz->execute(self::podacigameHomeTeam());
        $homeTeam = $izraz->fetchColumn();
         
        $db = Db::getInstance();
        $izraz = $db->prepare("select id from leagueTable where nameOfTeam=:awayTeam;");
        $izraz->execute(self::podacigameAwayTeam());
        $awayTeam = $izraz->fetchColumn();
 

        $krug = Request::post("description");
        
     
    
        $db = Db::getInstance();
        $izraz = $db->prepare("select id from game where homeTeam=$homeTeam and awayTeam=$awayTeam and description=$krug;");
        $izraz->execute();
        $ukupno = $izraz->fetchColumn();
        if($ukupno>0){
            // return "Utakmica je vec unesena";
            // header('Location: http://localhost/mojapp/index');

            $view = new View();
            $view->render(
                'tables/editutakmice',
                [
                "poruka"=>$ukupno,
                ]
            );
            return;

        }

          return true;
        }


    function kontrolainsert()
    {
        if(Request::post("homeTeamGoals")===""){
            return "Golovi su obavezni";
        }
        
        if(Request::post("awayTeamGoals")===""){
            return "Golovi su obavezni";
        }
    

        if(!ctype_digit(Request::post("awayTeamGoals"))){
            return "Golovi moraju biti brojevi";
        }

        
        if(!ctype_digit(Request::post("homeTeamGoals"))){
            return "Golovi moraju biti brojevi";
        }
    
        return true;
        }


    function kontrolaadd()
    {
       if(Request::post("nameOfTeam")===""){
           return "Ime ekipe je obavezno";
       }

       $db = Db::getInstance();
       $izraz = $db->prepare("select count(id) from leagueTable where nameOfTeam=:nameOfTeam and id<>:id");
       $izraz->execute(["nameOfTeam"=>Request::post("nameOfTeam"), "id" => Request::post("id")]);
       $ukupno = $izraz->fetchColumn();
       if($ukupno>0){
           return "Naziv tima već postoji, odaberite drugi";
       }



       return true;
    }



    function kontrolaedit()
        {
         if(Request::post("nameOfTeam")===""){
             return "Ime tima je obavezno";
         }
     
    
    
         if(strlen(Request::post("nameOfTeam"))>50){
             return "Ime tima ne smije biti veći od 50 znakova";
         }
     
    
         $db = Db::getInstance();
         $izraz = $db->prepare("select count(id) from leagueTable where nameOfTeam=:nameOfTeam and id<>:id");
         $izraz->execute(["nameOfTeam"=>Request::post("nameOfTeam"), "id" => Request::post("id")]);
         $ukupno = $izraz->fetchColumn();
         if($ukupno>0){
             return "Naziv tima već postoji, odaberite drugi";
         }
    
         return true;
        }

    
        function insert()
        {        
            $kontrola2 = $this->kontrolainsert2();
            $kontrola = $this->kontrolainsert();

            if($kontrola2===true){
             
    }else{
        return;
        
    }

     if($kontrola===true){

                Table::insert();
                $this->index(Request::post("league"));
     
    }else{
        $view = new View();
        $view->render(
            'tables/poruka',
            [
            "poruka"=>$kontrola
            ]
        );


    }
}


    function rezultati($id)
    {
        $view = new View();
        $view->render('tables/rezultati',
        ["tablica"=>Table::rezultati($id)
        ]
    );
    }


    private static function podacigameHomeTeam()
    {
        return [
            "homeTeam"=>Request::post("homeTeam")
      
        ];
    }
    
    
    private static function podacigameAwayTeam()
    {
        return [
            "awayTeam"=>Request::post("awayTeam")
      
        ];
    }


    function kontrola()
    {
        if(Request::post("nameOfLeague")===""){
            return "Ime lige je obavezno";
        }

        if(Request::post("gameType")===""){
            return "Vrsta igre je obavezna";
        } 

        if(strlen(Request::post("nameOfLeague"))>50){
            return "Ime lige ne smije biti veći od 50 znakova";
        }
    
        return true;
    }


    function deleteutakmice($id)
    {
            Table::deleteutakmice($id);
            $this->home();

           
    }
    
}