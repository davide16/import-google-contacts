<?php


class Contacts{


    private $nome;
    private $cognome;
    private $email;
    private $data;
    private $attivo;
    private $conn;
            function __construct($conn) {
        
        $this->conn = $conn;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCognome() {
        return $this->cognome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getData() {
        return $this->data;
    }

    public function getAttivo() {
        return $this->attivo;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setCognome($cognome) {
        $this->cognome = $cognome;
    }
    public function setEmail($email) {
        $this->email = $email;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setAttivo($attivo) {
        $this->attivo = $attivo;
    }

    
    
    public function insert($nome, $cognome, $email) {
        $sql ="INSERT INTO contatti VALUES ('','".$nome."','".$cognome."','".$email."')";
        $res= mysqli_query($this->conn, $sql);
        return $res;
        }
   

    


}




?>