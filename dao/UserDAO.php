<?php

require_once("models/User.php");
require_once("models/Message.php");

class UserDAO implements UserDAOInterface
{

  //sempre que for instanciar essa classe será nescessario passar esses dois parametros
  private $conn;
  private $url;
  private $message;

  public function __construct(PDO $conn, $url)
  {
    $this->conn = $conn;
    $this->url = $url;
    $this->message = new Message($url);
  }
  public function buildUser($data)
  {

    $user = new User();

    $user->id = $data["id"];
    $user->name = $data["name"];
    $user->lastname = $data["lastname"];
    $user->contato = $data["contato"];
    $user->email = $data["email"];
    $user->password = $data["password"];
    $user->token = $data["token"];

    return $user;
  }
  public function create(User $user, $authUser = false)
  {

    $stmt = $this->conn->prepare("INSERT INTO user(
            name, lastname, contato, email, password, token
          ) VALUES (
            :name, :lastname, :contato, :email, :password, :token
          )");

    $stmt->bindParam(":name", $user->name);
    $stmt->bindParam(":lastname", $user->lastname);
    $stmt->bindParam(":contato", $user->contato);
    $stmt->bindParam(":email", $user->email);
    $stmt->bindParam(":password", $user->password);
    $stmt->bindParam(":token", $user->token);

    $stmt->execute();

    // Autenticar usuário, caso auth seja true
    //A autenticação consiste em jogar o token do usuario na session e verificar em cada sessão se confere
    if ($authUser) {
      $this->setTokenToSession($user->token);
    }
  }
  public function update(User $user, $redirect = true)
  {

    $stmt = $this->conn->prepare("UPDATE user SET
          name = :name,
          lastname = :lastname,
          contato = :contato,
          email = :email,
          token = :token
          WHERE id = :id
        ");

    $stmt->bindParam(":name", $user->name);
    $stmt->bindParam(":lastname", $user->lastname);
    $stmt->bindParam(":contato", $user->contato);
    $stmt->bindParam(":email", $user->email);
    $stmt->bindParam(":token", $user->token);
    $stmt->bindParam(":id", $user->id);

    $stmt->execute();

    if ($redirect) {

      // Redireciona para o perfil do usuario
      $this->message->setMessage("Dados atualizados com sucesso!", "success", "editprofile.php");
    }
  }

  public function verifyToken($protected = false)
  {

    if (!empty($_SESSION["token"])) {

      // Pega o token da session
      $token = $_SESSION["token"];
      //verifica se existe no banco e se seim salva em $user
      $user = $this->findByToken($token);

      //Havendo no banco salva ele no $user e retorna para  a session esse user
      if ($user) {
        return $user;
        //Quem invocar a funcao acima vai mandar um boolean para essa variavel, se for true esse endereço nao sera visivel caso nao autentique
      } else if ($protected) {

        // Redireciona usuário não autenticado
        $this->message->setMessage("Faça a autenticação para acessar esta página!", "error", "index.php");
      }
    } else if ($protected) {

      // Redireciona usuário não autenticado
      $this->message->setMessage("Faça a autenticação para acessar esta página!", "error", "index.php");
    }
  }


  public function setTokenToSession($token, $redirect = true)
  {

    // Salvar token na session
    $_SESSION["token"] = $token;

    if ($redirect) {

      // Redireciona para o perfil do usuario
      $this->message->setMessage("Seja bem-vindo!", "success", "editprofile.php");
    }
  }
  //função para autenticar usuário chamado do login em auth process
  public function authenticateUser($email, $password)
  {

    $user = $this->findByEmail($email);

    if ($user) {

      // Checar se as senhas batem
      if (password_verify($password, $user->password)) {

        // Gerar um token e inserir na session
        $token = $user->generateToken();

        $this->setTokenToSession($token, false);

        // Atualizar token no usuário
        $user->token = $token;

        $this->update($user, false);

        return true;
      } else {
        return false;
      }
    } else {

      return false;
    }
  }
  public function findByEmail($email)
  {

    if ($email != "") {

      $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = :email");

      $stmt->bindParam(":email", $email);

      $stmt->execute();

      if ($stmt->rowCount() > 0) {

        $data = $stmt->fetch();
        $user = $this->buildUser($data);

        return $user;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function findById($id)
  {

    if ($id != "") {

      $stmt = $this->conn->prepare("SELECT * FROM user WHERE id = :id");

      $stmt->bindParam(":id", $id);

      $stmt->execute();

      if ($stmt->rowCount() > 0) {

        $data = $stmt->fetch();
        $user = $this->buildUser($data);

        return $user;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }
  public function findAll()
  {
    $users = [];

    $stmt = $this->conn->query("SELECT * FROM user");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $userArrays = $stmt->fetchAll();

      foreach ($userArrays as $useArray) {
        $users[] = $this->buildUser($useArray);
        return $userArrays;
      }
    }
  }



  public function findByToken($token)
  {

    if ($token != "") {

      $stmt = $this->conn->prepare("SELECT * FROM user WHERE token = :token");

      $stmt->bindParam(":token", $token);

      $stmt->execute();

      if ($stmt->rowCount() > 0) {

        $data = $stmt->fetch();
        $user = $this->buildUser($data);

        return $user;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function destroyToken()
  {

    // Remove o token da session
    $_SESSION["token"] = "";

    // Redirecionar e apresentar a mensagem de sucesso
    $this->message->setMessage("Você fez o logout com sucesso!", "success", "index.php");
  }


  public function changePassword(User $user)
  {

    $stmt = $this->conn->prepare("UPDATE user SET
          password = :password
          WHERE id = :id
        ");

    $stmt->bindParam(":password", $user->password);
    $stmt->bindParam(":id", $user->id);

    $stmt->execute();

    // Redirecionar e apresentar a mensagem de sucesso
    $this->message->setMessage("Senha alterada com sucesso!", "success", "editprofile.php");
  }

  public function deleteById($idUser){
       if (!$idUser == ""){
     
      $stmt = $this->conn->prepare("DELETE FROM user 
            WHERE id = :id
    ");
    $stmt->bindParam(":id", $idUser);

    $stmt->execute();
    
    $this->message->setMessage("Usuário excluído do banco!", "success", "back");
    }
  }
}
