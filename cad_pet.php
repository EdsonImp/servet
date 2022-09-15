<?php
require_once("templates/header.php");
require_once("models/User.php");
require_once("dao/UserDAO.php");
require_once("dao/PetDAO.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);
$userData = $userDao->verifyToken(true);
$petDao = new PetDAO($conn, $BASE_URL);

// Pego todos os pets por ordem decrescente
//Elimito todos a partir do segundo array, ficando com os ultimos dois pets adicionados
$pets = $petDao->findAllDesc();
array_splice($pets, 2);

?>


<div id="main-container" class="container-fluid">
<h2>Cadastre seu PET</h2>
  <div class="col-md-12 row" id="pet-container">

    <div class="col-md-4" id="pet-container-form">
      <form action="<?= $BASE_URL ?>pet_process.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="type" value="create">

        <h2>Cadastro Pet</h2>
        <label  class="form-label" for="especie">Espécie:</label>
        <div class="row">
          <input class="m-3" type="radio" id="cat" name="especie" value="Gato">
          <label  class="form-label" for="cat">Gato</label>
          <input class="m-3" type="radio" id="dog" name="especie" value="Cachorro">
          <label  class="form-label" for="dog">Cachorro</label>
        </div>

        <label class="form-label"  for="sexo">Sexo:</label>
        <div class="row">
          <input class="m-3" type="radio" id="macho" name="sexo" value="Macho">
          <label  class="form-label" for="macho">Macho</label>
          <input class="m-3" type="radio" id="femea" name="sexo" value="Femea">
          <label  class="form-label" for="femea">Fêmea</label>
        </div>

        <div class="pet-form">
          <label  class="form-label"for="name">Nome:</label>
          <input type="text" class="form-control mb-2" id="name" name="name" placeholder="Digite o nome">
        </div>
        <div class="pet-form">
          <label  class="form-label" for="raca">Raça:</label>
          <input type="text" class="form-control mb-2" id="raca" name="raca" placeholder="Digite a Raça">
        </div>
        <div class="pet-form">
          <label  class="form-label" for="color">Cor:</label>
          <input type="text" class="form-control mb-2" id="color" name="color" placeholder="Digite a Cor">
        </div>
        <div class="pet-form">
          <label class="form-label" for="description">Sobre seu Pet:</label>
          <textarea name="description" class="form-control mb-2" id="description" rows="5" placeholder="Conte detalhes do seu pet, idade, pedigri e outros..."></textarea>
        </div>

        <div >
        <input hidden id="file-cadastro" type="file" class="mb-2" name="image">
       <label id="btn-label-cad" for="file-cadastro" >Imagem</label>   
      </div>

        <input type="submit" class="btn card-btn" value="Cadastra Pet">
      </form>
    </div>


    <div class="col-md-4" id="pet-image-container">
      <h2>Ultimos cadastros</h2>
      <?php foreach ($pets as $pet): ?>
        <div>
          <?php require("templates/pet_card.php"); ?>
        </div>
        <?php endforeach; ?>
    </div>


  </div>
</div>

<?php

require_once("templates/footer.php");
?>

