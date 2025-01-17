<?php

class Items {
  public $conn;
  public $itemsTable = 'items';

  public function __construct($conn) {
    $this->conn = $conn;
  }

  public function create(string $name, string $description, float $price, int $category_id, DateTime $created): bool {
    $stmt = $this->conn->prepare("
      INSERT INTO {$this->itemsTable} (`name`, `description`, `price`, `category_id`, `created`)
      VALUES (?, ?, ?, ?, ?)
    ");
    $createdFormatted = $created->format('Y-m-d H:i:s');

    $stmt->bind_param('ssdis', $name, $description, $price, $category_id, $createdFormatted);

    if ($stmt->execute()) {
      return true;
    } else {
      // Handle errors (e.g., throw an exception)
      throw new PDOException($stmt->error);
    }
  }

  public function read(int $id = null): mysqli_result {
    $stmt = $this->conn->prepare($id ?
      "SELECT * FROM {$this->itemsTable} WHERE id = ?" :
      "SELECT * FROM {$this->itemsTable}"
    );

    if ($id) {
      $stmt->bind_param('i', $id);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    return $result;
  }

  public function update(int $id, string $name, string $description, float $price, int $category_id, DateTime $created): bool {
      $stmt = $this->conn->prepare("
        UPDATE {$this->itemsTable}
        SET name = ?, description = ?, price = ?, category_id = ?, created = ?
        WHERE id = ?
      ");

      // Convertir la fecha a formato 'Y-m-d H:i:s'
      $createdFormatted = $created->format('Y-m-d H:i:s');
      $stmt->bind_param('sssisi', $name, $description, $price, $category_id, $createdFormatted, $id);

      if ($stmt->execute()) {
        return true;
      } else {
        // Handle errors (e.g., throw an exception)
        throw new PDOException($stmt->error);
      }
  }

  public function delete(int $id): bool {
    $stmt = $this->conn->prepare("
      DELETE FROM {$this->itemsTable}
      WHERE id = ?
    ");

    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
      return true;
    } else {
      // Handle errors (e.g., throw an exception)
      throw new PDOException($stmt->error);
    }
  }
}


?>