<?php
  class Alive {
    private $conn;
    private $table = 'alive';

    public $id;
    public $date;
    public $capteur;

    public function __construct($db) {
      $this->conn = $db;
    }

    public function create() {
          $query = 'INSERT INTO ' . $this->table . ' SET created_at = CURRENT_TIMESTAMP(), capteur = :capteur';

          $stmt = $this->conn->prepare($query);
          $this->capteur = htmlspecialchars(strip_tags($this->capteur));

          $stmt->bindParam(':capteur', $this->capteur);


          if($stmt->execute()) {
            return true;
      }

      printf("Error: %s.\n", $stmt->error);

      return false;
    }
  }
