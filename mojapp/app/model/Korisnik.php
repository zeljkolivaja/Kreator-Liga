<?php

class Korisnik{

    public static function read()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("
        
                    select 
                    a.id,
                    a.administrator,
                    a.firstName,
                    a.lastName,
                    a.username,
                    count(b.id) as ukupno from 
                    users a left join league b on a.id=b.users
                    group by 
                    a.administrator,
                    a.firstName,
                    a.lastName,
                    a.username
                    order by a.administrator

        ");
        $izraz->execute();
        return $izraz->fetchAll();
    }


    public static function delete($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("delete from users where id=:id");
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
        $izraz = $db->prepare("insert into users (administrator,firstName,lastName,username) 
        values (:administrator,:firstName,:lastName,:username)");
        $izraz->execute(self::podaci());
    }


    private static function podaci(){
        return [
            "administrator"=>Request::post("administrator")==="on" ? true : false,
            "firstName"=>Request::post("firstName"),
            "lastName"=>Request::post("lastName"),
            "username"=>Request::post("username"),
        ];
    }

    public static function update($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("update users set 
        administrator=:administrator,
        firstName=:firstName,
        lastName=:lastName,
        username=:username
        where id=:id");
        $podaci = self::podaci();
        $podaci["id"]=$id;
        $izraz->execute($podaci);
    }


}