<?php

class Korisnik{

    public static function read(){
        $db = Db::getInstance();
        $izraz = $db->prepare("select administrator,firstName,lastName,username,id from users");
        $izraz->execute();
        return $izraz->fetchAll();
    }


    
    public static function find($id){
        $db = Db::getInstance();
        $izraz = $db->prepare("select * from users where id=:id");
        $izraz->execute(["id"=>$id]);
        return $izraz->fetch();
    }



}