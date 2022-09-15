<?php
class Pet {
    public $id;
    public $especie;
    public  $sexo;
    public  $raca;
    public  $name;
    public  $color;
    public  $description;
    public  $image;
    public  $user_id;
    
    //funcao para gerar uma hash para ao nome da imagem
    public function imageGenerateName() {
        return bin2hex(random_bytes(60)) . ".jpg";
      }

}

interface PetDAOInterface {
    public function findAll();
    public function findByRaca($raca);
    public function findBySexo($sexo);
    public function findByEspecie($especie);
    public function findByColor($color);
    public function buildPet($data);
    public function create(Pet $pet);
    public function update(Pet $pet);
    public function deletePet($id);

}



?>