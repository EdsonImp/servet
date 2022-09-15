<?php

require_once("globals.php");
require_once("config/db.php");
require_once("models/Pet.php");
require_once("models/Message.php");
require_once("dao/PetDAO.php");
require_once("dao/UserDAO.php");


$message = new Message($BASE_URL);

$userDao = new UserDAO($conn, $BASE_URL);

$petDao = new PetDAO($conn, $BASE_URL);

// Resgata o tipo do formulário
$type = filter_input(INPUT_POST, "type");

// Resgata dados do usuário
$userData = $userDao->verifyToken();
if($type === "delete"){
    $id= filter_input(INPUT_POST, "id");
    $petDao->deletePet($id);
}


/*UPDATE */

else if($type === "update-pet"){
  
//regata dados vindos do formulario do pet
    $id = filter_input(INPUT_POST, "id");
    $especie = filter_input(INPUT_POST, "especie");
    $sexo = filter_input(INPUT_POST, "sexo");
    $raca = filter_input(INPUT_POST, "raca");
    $image = filter_input(INPUT_POST, "image");
    $name = filter_input(INPUT_POST, "name");
    $color = filter_input(INPUT_POST, "color");
    $description = filter_input(INPUT_POST, "description");
    $user_id = filter_input(INPUT_POST, "user_id");

    $pet = new Pet();
      
    //veja se vem os dados nescessarios para cadastro do pet
    if (!empty($raca) && !empty($name) && !empty($sexo) && !empty($especie)) {
      $pet->id =$id;
      $pet->especie = $especie;
      $pet->sexo = $sexo;
      $pet->raca = $raca;
      $pet->image = $image;
      $pet->name = $name;
      $pet->color = $color;
      $pet->description = $description;
      $pet->user_id = $userData->id;
       
    }else{

      $message->setMessage("Campos obrigatórios não preenchidos", "error", "back");
  
    }
    
      // Upload de imagem do pet
      if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
        $image = $_FILES["image"];
        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
        $jpgArray = ["image/jpeg", "image/jpg"];

        // Checa se imagem é jpg
        if (in_array($image["type"], $jpgArray)) {
            $imageFile = imagecreatefromjpeg($image["tmp_name"]);
        } else {
            $imageFile = imagecreatefrompng($image["tmp_name"]);
        }
          // Gerando o nome da imagem a pardir da funcao do model pet
      $imageName = $pet->imageGenerateName();

      imagejpeg($imageFile, "./img/pet/" . $imageName, 100);

      $pet->image = $imageName;
      
    }else {
      
      $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");
      
    }
   // print_r($pet); exit;
      
    $petDao->update($pet);
  
}else if ($type === "create") {
    // Receber os dados dos inputs
    $especie = filter_input(INPUT_POST, "especie");
    $sexo = filter_input(INPUT_POST, "sexo");
    $raca = filter_input(INPUT_POST, "raca");
    $name = filter_input(INPUT_POST, "name");
    $color = filter_input(INPUT_POST, "color");
    $description = filter_input(INPUT_POST, "description");

    $pet = new Pet();
    // Validação mínima de dados
    if (!empty($raca) && !empty($name) && !empty($sexo) && !empty($especie)) {

        $pet->especie = $especie;
        $pet->sexo = $sexo;
        $pet->raca = $raca;
        $pet->name = $name;
        $pet->color = $color;
        $pet->description = $description;
        $pet->user_id = $userData->id;

        
        // Upload de imagem do pet
        if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
      
            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            // Checa se imagem é jpg
            if (in_array($image["type"], $jpgArray)) {
                $imageFile = imagecreatefromjpeg($image["tmp_name"]);
            } else {
                $imageFile = imagecreatefrompng($image["tmp_name"]);
            }
              // Gerando o nome da imagem a pardir da funcao do model pet
          $imageName = $pet->imageGenerateName();

          imagejpeg($imageFile, "./img/pet/" . $imageName, 100);

          $pet->image = $imageName;

        } else {

          $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");

        }
        }
        $petDao->create($pet);
      }
        else {

            $message->setMessage("Campos obrigatórios não preenchidos", "error", "back");
  
          }

?>