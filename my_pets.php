<?php
require_once("templates/header.php");
require_once("dao/UserDAO.php");
require_once("dao/PetDAO.php");
require_once("models/Message.php");
require_once("models/User.php");
require_once("models/Pet.php");


$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);
$petDao = new PetDAO($conn, $BASE_URL);
$userData = $userDao->verifyToken(true);
//Pegando os pets por usuario logado
$petsByUser = $petDao->findByUserId($userData->{"id"});
//$fullName = $user->getFullName($userData);
?>




<div id="main-container" class="container-fluid">
    <h2 id="edicao">Meus PETs</h2>
    
    <?php if(isset($petsByUser)) : ?>
        <?php foreach ($petsByUser as $byUserID) : ?>

            <div class="col-md-12 row" id="edit-container">

                <div class="col-md-4" id="edit-form">
                    <form action="<?= $BASE_URL ?>pet_process.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="update-pet">

                        <h2>Editar Pet</h2>
                        <div hidden>
                            <label class="edit-label-form" for="id">Id:</label>
                            <input readonly type="text" class="form-control mb-2" id="id" name="id" value="<?= $byUserID->id ?>">
                        </div>
                        <div>
                            <label class="edit-label-form" for="especie">Especie:</label>
                            <input readonly type="text" class="form-control mb-2" id="especie" name="especie" value="<?= $byUserID->especie ?>">
                        </div>
                        <div hidden>
                            <label class="edit-label-form" for="image">Imagem:</label>
                            <input readonly type="text" class="form-control mb-2" id="image" name="image" value="<?= $byUserID->image ?>">
                        </div>
                        <div>
                            <label class="edit-label-form" for="sexo">Sexo:</label>
                            <input readonly type="text" class="form-control mb-2" id="sexo" name="sexo" value="<?= $byUserID->sexo ?>">
                        </div>
                        <div>
                            <label class="edit-label-form" for="name">Nome:</label>
                            <input type="text" class="form-control mb-2" id="name" name="name" value="<?= $byUserID->name ?>">
                        </div>
                        <div>
                            <label class="edit-label-form" for="raca">Raça:</label>
                            <input type="text" class="form-control mb-2" id="raca" name="raca" value="<?= $byUserID->raca ?>">
                        </div>
                        <div>
                            <label class="edit-label-form" for="color">Cor:</label>
                            <input type="text" class="form-control mb-2" id="color" name="color" value="<?= $byUserID->color ?>">
                        </div>
                       
                        
                        <div>
                            <label class="edit-label-form" for="description">Sobre seu Pet:</label>
                            <!-- em textarea é preciso fechar a tag e colocar o value entre elas -->
                            <textarea name="description" class="form-control mb-2" id="description" rows="5"><?= $byUserID->description ?></textarea>
                        </div>
                        <div>
                        
                            <input type="file" class="mb-2" name="image" >
                        </div>
                                              
                        <input type="submit" class="btn card-btn mr-2" value="Atualiza">
                    </form>
                    
                    <form action="<?= $BASE_URL ?>pet_process.php" method="POST">
                        <input type="hidden" name="type" value="delete">
                        <input hidden type="text" class="form-control mb-2" id="id" name="id" value="<?= $byUserID->id ?>">
                        <input type="submit" class="btn card-btn" value="Apagar">
                    </form>
                </div>
                <div class="col-md-4" id="edit-pets-img">
                    <h2>Imagem Pet</h2>
                    <div id="pet-card" style="background-image: url('<?= $BASE_URL ?>img/pet/<?= $byUserID->image ?>')">
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>






<?php
require_once("templates/footer.php");

?>