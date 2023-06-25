<?php 


    namespace App\crud;

    class CRUDFactory{


        public static function getArticleCRUD(){
            return new ArticleCRUD();
        } 

        public static function getUserCRUD(){
            return new UserCRUD();
        }         


    }