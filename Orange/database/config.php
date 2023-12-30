<?php
abstract class Connexion {
    protected $pdo;

    function __construct()
    {
        try {
            // Establish a connection to the database
            $this->pdo = new PDO('mysql:host=localhost;dbname=club', 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Handle connection errors
            echo "Connection failed: " . $e->getMessage();
            die();
        }
    }

    function __destruct()
    {
        // Close the database connection when the object is destroyed
        $this->pdo = null;
    }
}
?>
