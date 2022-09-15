<?php
require_once("globals.php");
require_once("config/db.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");


$message = new Message($BASE_URL);

$flassMessage = $message->getMessage();

if (!empty($flassMessage["msg"])) {
  // Limpar a mensagem
  $message->clearMessage();
}

$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(false);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Configurações fontes do google-->
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Arimo&family=Fredoka+One&family=Montserrat:wght@300;700&family=Secular+One&family=Source+Serif+Pro:ital,wght@0,200;0,300;0,400;1,300;1,900&display=swap" rel="stylesheet">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.css" integrity="sha512-drnvWxqfgcU6sLzAJttJv7LKdjWn0nxWCSbEAtxJ/YYaZMyoNLovG7lPqZRdhgL1gAUfa+V7tbin8y+2llC1cw==" crossorigin="anonymous" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
  <!-- CSS do projeto -->
  <link rel="stylesheet" href="<?= $BASE_URL ?>css/styles.css">
</head>

<body>


  <header>


    <!-- logo -->
    <div class="logo">
      <div id="image">
        <a href="<?= $BASE_URL ?>index.php" class="image">
          <img src="<?= $BASE_URL ?>img/logo1.jpg" alt="logo">
        </a>
      </div>
      <div id="title">
        <h3>Pets Club Imperatriz</h3>
      </div>
    </div>

    <!-- Navigator -->


    <nav class="nav-bar">
      <div class="container fluid">
        <ul>

          <?php if ($userData) : ?>

            <li><a href="<?= $BASE_URL ?>editprofile.php">
                <i class='far fa-user'></i>
                <?= $userData->name ?>
              </a>
            </li>
            <li><a href="<?= $BASE_URL ?>my_pets.php">Meus Pets</a></li>
            <li><a href="<?= $BASE_URL ?>cad_pet.php">Cadastrar PET</a></li>
            <li><a href="<?= $BASE_URL ?>index.php">Início</a></li>
            <li><a href="<?= $BASE_URL ?>logout.php">Sair</a> </li>
            <li><a href="<?= $BASE_URL ?>lista_pets.php"><i class="fas fa-search"> </i></a></li>

          <?php else : ?>
            <li><a href="<?= $BASE_URL ?>auth.php">Entrar</a></li>
            <li><a href="<?= $BASE_URL ?>lista_pets.php"><i class="fas fa-search"> </i></a></li>
          <?php endif; ?>



        </ul>

      </div>

    </nav>
    <!--Barra para toggle -->

    <div class="toggle-container container-fluid">
      <input type="checkbox" id="check" hidden>
      <nav>
        <ul>
        <?php if ($userData) : ?>
          <li><a href="<?= $BASE_URL ?>editprofile.php">
                <i class='far fa-user'></i>
                <?= $userData->name ?>
              </a>
            </li>
            <li><a href="<?= $BASE_URL ?>my_pets.php">Meus Pets</a></li>
            <li><a href="<?= $BASE_URL ?>cad_pet.php">Cadastrar PET</a></li>
            <li><a href="<?= $BASE_URL ?>index.php">Início</a></li>
            <li><a href="<?= $BASE_URL ?>logout.php">Sair</a> </li>
            <li><a href="<?= $BASE_URL ?>lista_pets.php"><i class="fas fa-search"> </i></a></li>

          <?php else : ?>
            <li ><a href="<?= $BASE_URL ?>auth.php">Entrar</a></li>
            <li><a href="<?= $BASE_URL ?>lista_pets.php"><i class="fas fa-search"> </i></a></li>
             <?php endif; ?>
          </ul>
      </nav>
      <label class="toggle" for="check">
        <i class="fa fa-bars"></i>
      </label>
    </div>
  </header>

  <!--Template para mensagem, no type vai pegar o typo que muda de cor segundo o css -->
  <?php if (!empty($flassMessage["msg"])) : ?>
    <div class="msg-container">
      <p class="msg <?= $flassMessage["type"] ?>"><?= $flassMessage["msg"] ?></p>
    </div>
  <?php endif; ?>