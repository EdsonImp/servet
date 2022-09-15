<?php
?>

    <div id="pet-card" style="background-image: url('<?= $BASE_URL ?>img/pet/<?= $pet->{"image"} ?>')">
        <div >
           
                <div class="card-information">
                    <a href="#"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
<!-- Abaixo a variável de array $pet vem de quem usa esse template-->
<!-- A variavel userName é para mostrar o nome e o contato do tutor no card, pegando o id pelo user_id-->                    

                    <?php 
                    $user_id = $pet->{"user_id"};
                    $userName = $userDao->findById($user_id);
                    ?>
                    <div class="pet-dados">
                        <p class="font-weight-bold text-uppercase"><?= $pet->{"name"} ?></p>
                        <p>Raça:<?= $pet->{"raca"}  ?></p>
                        <p>Sobre:<?= $pet->{"description"} ?></p>
                        <p>Tutor: <?= $userName->name ?></p>
                        <p>Contato Tel:<?= $userName->contato ?></p>
                    </div>
                </div>

        </div>
    </div>
