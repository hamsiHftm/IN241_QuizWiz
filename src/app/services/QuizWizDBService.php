<?php

require '../models/User.php';

/*
 * Contains all the DB functions
 *
 * 1. Connect DB
 * 2. Save user
 * 3. Get User by username & password
 * 4. Show high-score list
 *
 */

class QuizWizDBService
{
    private $host;
    private $port;
    private $dbname;
    private $username;
    private $password;
    private $pdo;

    public function __construct($host, $port, $dbname, $username, $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;

        $this->connect();
    }

    private function connect()
    {
        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname};user={$this->username};password={$this->password}";

        try {
            $this->pdo = new PDO($dsn);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            error_log('Connected to DB.', LOG_INFO);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }

    public function saveUser($username, $password, $first_name = null, $last_name = null, $date_of_birth = null): bool
    {
        try {
            // Prepare the SQL statement for inserting a new player
            $stmt = $this->pdo->prepare("
                INSERT INTO Player (username, password, first_name, last_name, date_of_birth)
                VALUES (:username, :password, :first_name, :last_name, :date_of_birth)
            ");
            // Hashing the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Bind the parameters to the prepared statement
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
            $stmt->bindParam(':date_of_birth', $date_of_birth, PDO::PARAM_STR);

            // Execute the prepared statement
            $stmt->execute();

            // Return true to indicate successful registration
            return true;
        } catch (PDOException $e) {
            // Handle any database errors and return false to indicate failure
            return false;
        }
    }

    public function getUserByUsernameAndPassword($username, $password): ?User
    {
        try {
            // Prepare the SQL statement for get the player
            $stmt = $this->pdo->prepare("SELECT * FROM Player where username = :username");

            // Bind the parameters to the prepared statement
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);

            // Execute the prepared statement
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result !== false && password_verify($password, $result['password'])) {
                // User found, verify password
                return new User(
                    $result['id'],
                    $result['username'],
                    $result['first_name'],
                    $result['last_name'],
                    $result['date_of_birth']
                );
            } else {
                return null;// Incorrect password
            }

        } catch (PDOException $e) {
            // Handle any database errors and return false to indicate failure
            return null;
        }
    }
}