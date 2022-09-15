<?php

  require_once("globals.php");
  require_once("config/db.php");
  require_once("models/User.php");
  require_once("models/Message.php");
  require_once("dao/UserDAO.php");
  require_once("dao/PetDAO.php");

  $message = new Message($BASE_URL);

  $userDao = new UserDAO($conn, $BASE_URL);
  $petDao = new PetDAO($conn, $BASE_URL);
  // Resgata o tipo do formulário
  $type = filter_input(INPUT_POST, "type");
  $dados=false;

//deleta usuário
if($type === "deleteuser"){
$idUser = filter_input(INPUT_POST, "id");
$petsByUser = $petDao->findByUserId($idUser);

if(count($petsByUser) > 0){
  $message->setMessage("Apague primeiro os pets deste usuário!", "error", "back");
} else{
  $userDao->deleteById($idUser , $dados);
  $message->setMessage("Usuário Deletado!", "success", "back");
  }
}
  

  // Atualizar usuário
  if($type === "update") {
   
    // Resgata dados do usuário
    $userData = $userDao->verifyToken();

    // Receber dados do post
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $contato = filter_input(INPUT_POST, "contato");
    $email = filter_input(INPUT_POST, "email");
    
    // Criar um novo objeto de usuário
    $user = new User();

    // Preencher os dados do usuário
    $userData->name = $name;
    $userData->lastname = $lastname;
    $userData->contato = $contato;
    $userData->email = $email;
        

    $userDao->update($userData);

  // Atualizar senha do usuário
  } 
  if($type === "changepassword") {
     // Receber dados do post
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

    // Resgata dados do usuário
    $userData = $userDao->verifyToken();
    
    $id = $userData->id;

    if($password == $confirmpassword) {

      // Criar um novo objeto de usuário
      $user = new User();

      $finalPassword = $user->generatePassword($password);

      $user->password = $finalPassword;
      $user->id = $id;

      $userDao->changePassword($user);

    } else {
      $message->setMessage("As senhas não são iguais!", "error", "back");
    }

  } 