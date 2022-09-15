<?php

  require_once("models/Pet.php");
  require_once("models/Message.php");

  class PetDAO implements PetDAOInterface {
    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url) {
      $this->conn = $conn;
      $this->url = $url;
      $this->message = new Message($url);
    }

    public function buildPet($data){
        $pet = new Pet();

        $pet->id = $data["id"];
        $pet->especie = $data["especie"];
        $pet->sexo = $data["sexo"];
        $pet->raca = $data["raca"];
        $pet->name = $data["name"];
        $pet->color = $data["color"];
        $pet->description = $data["description"];
        $pet->image = $data["image"];
        $pet->user_id = $data["user_id"];
  
        return $pet;
    }
    
    public function create(Pet $pet) {

        $stmt = $this->conn->prepare("INSERT INTO pet (
          especie, sexo, raca, name, color, description, image, user_id
        ) VALUES (
          :especie, :sexo, :raca, :name, :color, :description, :image, :user_id
        )");
  
        $stmt->bindParam(":especie", $pet->especie);
        $stmt->bindParam(":sexo", $pet->sexo);
        $stmt->bindParam(":raca", $pet->raca);
        $stmt->bindParam(":name", $pet->name);
        $stmt->bindParam(":color", $pet->color);
        $stmt->bindParam(":description", $pet->description);
        $stmt->bindParam(":image", $pet->image);
        $stmt->bindParam(":user_id", $pet->user_id);
  
        $stmt->execute();
  
        // Mensagem de sucesso por adicionar filme
        $this->message->setMessage("Pet adicionado com sucesso!", "success", "cad_pet.php");
  
      }

    public function findAll(){
        $pets = [];

        $stmt = $this->conn->query("SELECT * FROM pet");
        $stmt->execute();

        if($stmt->rowCount() >0){
            $petArrays = $stmt->fetchAll();
            
            foreach ($petArrays as $petArray) {
                $pets[]= $this->buildPet($petArray);
                
            }
        }
        return $pets;
    }

    public function findByUserId($user_id){
      $porUserId = [];
      if ($user_id != ""){
        $stmt = $this->conn->prepare("SELECT * FROM pet WHERE user_id = :user_id");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        if($stmt->rowCount() >0){
          $porUserIds = $stmt->fetchAll();
          
          foreach ($porUserIds as $poriduser) {
            $porUserId[]= $this->buildPet($poriduser);
              
          }
      }
      return $porUserId;
  }
  }

    public function findAllDesc(){
      $pets = [];

      $stmt = $this->conn->query("SELECT * FROM pet ORDER BY id DESC");
      $stmt->execute();

      if($stmt->rowCount() >0){
          $petArrays = $stmt->fetchAll();
          
          foreach ($petArrays as $petArray) {
              $pets[]= $this->buildPet($petArray);
              
          }
      }
      return $pets;
  }


    public function findByRaca($raca){
      $porRaca = [];
      if ($raca != ""){
        $stmt = $this->conn->prepare("SELECT * FROM pet WHERE raca = :raca");
        $stmt->bindParam(":raca", $raca);
        $stmt->execute();

        if($stmt->rowCount() >0){
            $racaArrays = $stmt->fetchAll();
            
            foreach ($racaArrays as $racaArray) {
                $porRaca[]= $this->buildPet($racaArray);
                
            }
        }
        return $porRaca;
    }
  }
  public function findByEspecie($especie){
    $porEspecie = [];
      if ($especie != ""){
        $stmt = $this->conn->prepare("SELECT * FROM pet WHERE especie = :especie");
        $stmt->bindParam(":especie", $especie);
        $stmt->execute();

        if($stmt->rowCount() >0){
            $especieArrays = $stmt->fetchAll();
            
            foreach ($especieArrays as $especieArray) {
                $porEspecie[]= $this->buildPet($especieArray);
                
            }
        }
        return $porEspecie;
    }
  }
  
  public function update(Pet $pet, $redirect = true){
    $stmt = $this->conn->prepare("UPDATE pet SET
    name = :name,
    raca = :raca,
    especie = :especie,
    sexo = :sexo,
    color = :color,
    description = :description,
    image = :image,
    user_id = :user_id
    WHERE id = :id
  ");
   $stmt->bindParam(":name", $pet->name);
   $stmt->bindParam(":raca", $pet->raca);
   $stmt->bindParam(":color", $pet->color);
   $stmt->bindParam(":especie", $pet->especie);
   $stmt->bindParam(":sexo", $pet->sexo);
   $stmt->bindParam(":description", $pet->description);
   $stmt->bindParam(":image", $pet->image);
   $stmt->bindParam(":id", $pet->id);
   $stmt->bindParam(":user_id", $pet->user_id);

   $stmt->execute();
  
  
  if ($redirect) {

   // Redireciona para o perfil do usuario
   $this->message->setMessage("Dados atualizados com sucesso!", "success", "my_pets.php");
 }
}

   public function deletePet($id, $redirect = true){
  if($id !=""){
  $stmt = $this->conn->prepare("DELETE FROM pet WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  if ($redirect) {

    // Redireciona para lista de pets
    $this->message->setMessage("Pet apagado com sucesso!", "success", "my_pets.php");
  }
}
}

public function findBySexo($sexo){}
public function findByColor($color){}  
}

