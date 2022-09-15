<?php
require_once("templates/header.php");
require_once("dao/UserDAO.php");
require_once("dao/PetDAO.php");


$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);
$petDao = new PetDAO($conn, $BASE_URL);
$userData = $userDao->verifyToken(false);

$pets = [];
//Observações abaixo = O imput text manda mesmo vazio uma key
//por isso deve ser melhor observado na hhora do if
if (!$_POST == "") {
    $pet = $_POST;
    if (($pet['raca']) != "") {
        $pets = $petDao->findByRaca($pet['raca']);
    } else if ((isset($pet['especie']))) {

        $pets = $petDao->findByEspecie($pet['especie']);
    } else {
        $pets = $petDao->findAll();
    }
}


?>

<div id="main-container" class="container-fluid ">
    <div id="search-bar" class="container-fluid">
        <div class="row">
            <form action="" method="POST">
                <input type="radio" id="cat" name="especie" value="gato">
                <label for="cat"> <i class="fa fa-cat form-icon "></i></label>
                <input class="m-3" type="radio" id="dog" name="especie" value="cachorro">
                <label for="dog"> <i class="fa fa-dog form-icon "></i></label>
                <input id="input-search" type="text" name="raca" id="" placeholder="Digite a Raça">
                <input id="input-button" type="submit" value="Ir">
            </form>
        </div>
    </div>

    <div class="col-md-12 row" id="pet-list-container">
        <?php if (isset($pets)) : ?>
            <?php foreach ($pets as $pet) : ?>
                <?php require("templates/pet_card.php"); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php
require_once("templates/footer.php");

?>