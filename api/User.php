<?php

class User {
  public $conn;
  public $usersTable = 'users';

  public function __construct($conn) {
    $this->conn = $conn;
  }

  public function create(string $username, string $password, string $email): bool {
    $hashed_password = strtoupper(hash('sha1', $password));

    $stmt = $this->conn->prepare("
      INSERT INTO {$this->usersTable} (User, Password, Email)
      VALUES (?, ?, ?)
    ");
    
    $stmt->bind_param('sss', $username, $hashed_password, $email);

    if ($stmt->execute()) {
      return true;
    } else {
      // Manejar errores (por ejemplo, lanzar una excepción)
      throw new Exception($stmt->error);
    }
  }

    public function read(string $username): ?array {
        $stmt = $this->conn->prepare("
        SELECT * FROM {$this->usersTable} WHERE User = ?
        ");

        $stmt->bind_param('s', $username);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}

?>