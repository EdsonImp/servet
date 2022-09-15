<?php
require_once("templates/header.php");

require_once("models/User.php");
require_once("dao/UserDAO.php");


//aqui abaixo a regra para deixar ou não exibir esse endereço sem autenticação, pois se nao autenticar vai passar um valor
//true para uma variavel no else que vai encerrer e redirecionar para index.

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);
$userData = $userDao->verifyToken(true);

$fullName = $user->getFullName($userData);

?>

<div id="main-container" class="container-fluid ">
  <h2>Edição de PERFIL</h2>
  <div class="col-md-12 row container-edit" id="container-form-edit">
    <div class="col-md-4" id="container-form-edit-user">
      <form action="<?= $BASE_URL ?>user_process.php" method="POST">
        <input type="hidden" name="type" value="update">
        <div>
          <div>
            <h2><?= $fullName ?></h2>
            <p class="page-description">Altere seus dados no formulário abaixo:</p>
            <div>
              <label for="name">Nome:</label>
              <input type="text" class="form-control mb-2" id="name" name="name" placeholder="Digite o seu nome" value="<?= $userData->name ?>">
            </div>
            <div>
              <label for="lastname">Sobrenome:</label>
              <input type="text" class="form-control mb-2" id="lastname" name="lastname" placeholder="Digite o seu nome" value="<?= $userData->lastname ?>">
            </div>
            <div class="form-group">
              <label for="contato">Contato:</label>
              <input type="text" class="form-control" id="contato" name="contato" placeholder="Digite seu telefone" value="<?= $userData->contato ?>">
            </div>
            <div>
              <label for="email">E-mail:</label>
              <input type="text" readonly class="form-control disabled" id="email" name="email" placeholder="Digite o seu nome" value="<?= $userData->email ?>">
            </div>
            <input type="submit" class="btn card-btn mt-3" value="Alterar">
          </div>

        </div>

      </form>
      <form action="<?= $BASE_URL ?>user_process.php" method="POST">
        <input type="hidden" name="type" value="deleteuser">
        <input type="text" id="id" name="id" value="<?= $userData->id ?>" hidden>
        <input type="submit" class="btn card-btn mt-3" value="Apagar Usuário">
      </form>
    </div>

    <!--Formulario troca de senha -->

    <div class="col-md-4" id="container-form-edit-senha">
      <div class=" form-edit">

        <form action="<?= $BASE_URL ?>user_process.php" method="POST">
        <input type="hidden" name="type" value="changepassword">
          <h2>Alterar a senha:</h2>
          <p class="page-description">Digite a nova senha e confirme, para alterar sua senha:</p>
          <input type="hidden" name="type" value="changepassword">
          <div class="form-edit">
            <label for="password">Senha:</label>
            <input type="password" class="form-control mb-2" id="password" name="password" placeholder="Digite a sua nova senha">
          </div>
          <div class="form-edit">
            <label for="confirmpassword">Confirmação de senha:</label>
            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirme a sua nova senha">
          </div>
          <input type="submit" class="btn card-btn mt-3" value="Alterar Senha">
        </form>
        
      </div>
    </div>

  </div>
</div>
<?php
require_once("templates/footer.php");
?>