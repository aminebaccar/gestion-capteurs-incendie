<?php
  class Historique {
    private $conn;
    private $table = 'historiques';

    public $id;
    public $evenement;
    public $capteur;
    public $user;
    public $img;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
      $this->conn = $db;
    }

    public function create() {
          $query = 'INSERT INTO ' . $this->table . ' SET evenement = :evenement, capteur = :capteur, img = :img, consulte = null, created_at = :created_at, updated_at = :updated_at';

          $stmt = $this->conn->prepare($query);

          $this->evenement = htmlspecialchars(strip_tags($this->evenement));
          $this->capteur = htmlspecialchars(strip_tags($this->capteur));
          $this->user = null;
          $this->img = htmlspecialchars(strip_tags($this->img));
          $this->created_at = htmlspecialchars(strip_tags($this->created_at));
          $this->updated_at = htmlspecialchars(strip_tags($this->updated_at));

          $stmt->bindParam(':evenement', $this->evenement);
          $stmt->bindParam(':capteur', $this->capteur);
          $stmt->bindParam(':img', $this->img);
          $stmt->bindParam(':created_at', $this->created_at);
          $stmt->bindParam(':updated_at', $this->updated_at);

          if($stmt->execute()) {
            return true;
      }

      printf("Error: %s.\n", $stmt->error);

      return false;
    }
    public function getConn() {
    return $this->conn;
  }
  }
