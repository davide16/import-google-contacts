<?php
session_start();

        include 'cont.php';
        include 'database.php';
$db = new Database();
$conn = $db->db_connect();
$contat = new Contacts($conn);
        
        
  
                          			
                                               
                      $nome='aaaa';
                      $cognome="dsdsdsd";
                      $email ="aaaaaaaaaaaaaa";
                      
                                                
                                                
                 $contat->insert($nome, $cognome, $email);
                if($res==true){
                    echo 'inserito';
                }                                

?>

