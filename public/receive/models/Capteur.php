<?php
  class Capteur {
    private $conn;
    private $table = 'capteurs';

    public $id;
    public $code_capteur;
    public $etat;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
      $this->conn = $db;
    }

    public function read() {
      $query = 'SELECT *  FROM ' . $this->table . '
                                ORDER BY
                                  created_at DESC';

      $stmt = $this->conn->prepare($query);

      $stmt->execute();

      return $stmt;
    }

    public function read_single() {
          $query = 'SELECT *  FROM ' . $this->table . '
                                      where id = ?
                                    LIMIT 0,1';

          $stmt = $this->conn->prepare($query);

          $stmt->bindParam(1, $this->id);

          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          $this->id = $row['id'];
          $this->code_capteur = $row['code_capteur'];
          $this->etat = $row['etat'];
          $this->etab = $row['etab'];
          $this->created_at = $row['created_at'];
          $this->updated_at = $row['updated_at'];
    }

    public function create() {
          $query = 'INSERT INTO ' . $this->table . ' SET code_capteur = :code_capteur, etat = :etat, created_at = :created_at, updated_at = :updated_at';

          $stmt = $this->conn->prepare($query);

          $this->code_capteur = htmlspecialchars(strip_tags($this->code_capteur));
          $this->etat = htmlspecialchars(strip_tags($this->etat));
          $this->created_at = htmlspecialchars(strip_tags($this->created_at));
          $this->updated_at = htmlspecialchars(strip_tags($this->updated_at));

          $stmt->bindParam(':code_capteur', $this->code_capteur);
          $stmt->bindParam(':etat', $this->etat);
          $stmt->bindParam(':created_at', $this->created_at);
          $stmt->bindParam(':updated_at', $this->updated_at);

          if($stmt->execute()) {
            return true;
      }

      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    public function update() {
          $query = 'UPDATE ' . $this->table . '
                                SET code_capteur = :code_capteur, etat = :etat, created_at = :created_at, updated_at = :updated_at
                                WHERE id = :id';

          $stmt = $this->conn->prepare($query);

          $this->code_capteur = htmlspecialchars(strip_tags($this->code_capteur));
          $this->etat = htmlspecialchars(strip_tags($this->etat));
          $this->created_at = htmlspecialchars(strip_tags($this->created_at));
          $this->updated_at = htmlspecialchars(strip_tags($this->updated_at));
          $this->id = htmlspecialchars(strip_tags($this->id));

          $stmt->bindParam(':code_capteur', $this->code_capteur);
          $stmt->bindParam(':etat', $this->etat);
          $stmt->bindParam(':created_at', $this->created_at);
          $stmt->bindParam(':updated_at', $this->updated_at);
          $stmt->bindParam(':id', $this->id);

          if($stmt->execute()) {
            return true;
          }

          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    public function delete() {
          $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

          $stmt = $this->conn->prepare($query);

          $this->id = htmlspecialchars(strip_tags($this->id));

          $stmt->bindParam(':id', $this->id);

          if($stmt->execute()) {
            return true;
          }

          printf("Error: %s.\n", $stmt->error);

          return false;
    }

  }
