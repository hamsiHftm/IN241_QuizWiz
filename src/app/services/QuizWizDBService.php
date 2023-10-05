<?php
require_once '../models/User.php';
require_once '../models/Category.php';

/**
 * Contains all the DB functions for postgres
 */

class QuizWizDBService
{
    private string $host;
    private string $port;
    private string $dbname;
    private string $username;
    private string $password;
    private ?PDO $pdo;

    public function __construct(string $host, string $port, string $dbname, string $username, string $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * It set variable pdo with a PDO objects on successful connection, or null on failure.
     * @return void
     */
    public function connect(): void
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

    /**
     * It set variable pdo with null, to close the DB connection.
     * @return void
     */
    public function closeConnection(): void
    {
        $this->pdo = null;
    }

    /**
     * Save user information to the Player table in the database.
     *
     * This function inserts a new user record into the Player table. It supports
     * optional fields such as first name, last name, and date of birth. Passwords
     * are hashed for security.
     *
     * @param string $username The username for the new user.
     * @param string $password The user's password (will be hashed).
     * @param string|null $first_name The user's first name (optional).
     * @param string|null $last_name The user's last name (optional).
     * @param string|null $date_of_birth The user's date of birth (optional).
     * @return bool Returns true if the user was successfully saved, false otherwise.
     */
    public function saveUser(string $username, string $password, ?string $first_name = null, ?string $last_name = null, ?string $date_of_birth = null): bool
    {
        try {
            // Prepare the SQL statement for inserting a new player
            $sql = "INSERT INTO Player (username, password";

            // Include optional fields in SQL and bind them if provided
            if ($first_name !== null) {
                $sql .= ", first_name";
            }
            if ($last_name !== null) {
                $sql .= ", last_name";
            }
            if ($date_of_birth !== null) {
                $sql .= ", date_of_birth";
            }

            $sql .= ") VALUES (:username, :password";

            // Include placeholders for optional fields in SQL
            if ($first_name !== null) {
                $sql .= ", :first_name";
            }
            if ($last_name !== null) {
                $sql .= ", :last_name";
            }
            if ($date_of_birth !== null) {
                $sql .= ", :date_of_birth";
            }

            $sql .= ")";

            // Hashing the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the SQL statement with the extended query
            $stmt = $this->pdo->prepare($sql);

            // Bind the parameters to the prepared statement
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);

            // Bind optional parameters if they are provided
            if ($first_name !== null) {
                $stmt->bindParam(':first_name', $first_name);
            }
            if ($last_name !== null) {
                $stmt->bindParam(':last_name', $last_name);
            }
            if ($date_of_birth !== null) {
                $stmt->bindParam(':date_of_birth', $date_of_birth);
            }

            // Execute the prepared statement
            $stmt->execute();

            // Return true to indicate successful registration
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Get a player by their username.
     *
     * @param string $username The username of the player to retrieve.
     * @return array|null Returns an associative array with player data if the player is found,
     *                   or null if not found.
     *
     */
    public function getUserByUsername(string $username): ?array
    {
        try {
            // Prepare the SQL statement to retrieve a player by username
            $stmt = $this->pdo->prepare("SELECT * FROM Player WHERE username = :username");

            // Bind the parameter for the username
            $stmt->bindParam(':username', $username);

            // Execute the prepared statement
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result !== false) {
                return $result;
            } else {
                return null; // Player not found
            }
        } catch (PDOException $e) {
            return null; // Query failed
        }
    }

    /**
     * Get a user's information by their username and verify their password.
     *
     * This function retrieves a user's information from the database based on the provided username.
     * It then verifies the provided password against the hashed password stored in the database.
     * If both the username and password match, the user's information is returned.
     * If no matching user is found or the password does not match, null is returned.
     *
     * @param string $username The username of the user to retrieve.
     * @param string $password The password to verify.
     *
     * @return array|null An associative array containing the user's information if authentication is successful,
     *                   or null if no user is found or the password is incorrect.
     *                   The returned array includes user details such as ID, username, and other relevant information.
     */
    public function getUserByUsernameAndPassword(string $username, string $password): ?array
    {
        try {
            // Prepare the SQL statement for get the player
            $stmt = $this->pdo->prepare("SELECT * FROM Player where username = :username");

            // Bind the parameters to the prepared statement
            $stmt->bindParam(':username', $username);

            // Execute the prepared statement
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result !== false && password_verify($password, $result['password'])) {
                return $result;
            } else {
                return null;// Incorrect password
            }

        } catch (PDOException $e) {
            return null;
        }
    }

    public function saveQuiz($playerId, $difficulty, $categoryId, $totalScore): bool
    {
        try {
            // Prepare the SQL statement for inserting a new player
            $stmt = $this->pdo->prepare("INSERT INTO Quiz (player_id, difficulty, category_id, total_score) 
                                        VALUES (:playerId, :difficulty, :categoryId, :totalScore)");

            // Bind parameters
            $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
            $stmt->bindParam(':difficulty', $difficulty, PDO::PARAM_STR);
            $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
            $stmt->bindParam(':totalScore', $totalScore, PDO::PARAM_INT);

            // Execute the statement to insert the record
            $stmt->execute();

            return true; // Record inserted successfully
        } catch (PDOException $e) {
            // Handle any database errors here
            echo "Error: " . $e->getMessage();
            return false; // Record insertion failed
        }
    }

    public function saveCategory($identifier, $name): bool
    {
        try {
            // Prepare the SQL statement for inserting a new player
            $stmt = $this->pdo->prepare("INSERT INTO Category (identifier, name) VALUES (:identifier, :name)");

            // Bind parameters
            $stmt->bindParam(':identifier', $identifier, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);

            // Execute the statement to insert the record
            $stmt->execute();

            return true; // Record inserted successfully
        } catch (PDOException $e) {
            // Handle any database errors here
            echo "Error: " . $e->getMessage();
            return false; // Record insertion failed
        }
    }

    public function getCategoryByIdentifierAndName($identifier, $name): ?array {
        try {
            // Prepare the SQL statement for get the player
            $stmt = $this->pdo->prepare("SELECT * FROM Category where identifier = :identifier and name = :name");

            // Bind the parameters to the prepared statement
            $stmt->bindParam(':identifier', $identifier, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);

            // Execute the prepared statement
            $stmt->execute();

            // Fetch the result (assuming there's only one matching record)
            return $stmt->fetch(PDO::FETCH_ASSOC); // Return the category record or false if not found
        } catch (PDOException $e) {
            // Handle any database errors here
            echo "Error: " . $e->getMessage();
            return null; // Query failed
        }
    }

    public function getQuizRecordsInDecOrderScore($limit) {
        try {
            // Prepare the SQL statement to retrieve the top quiz records
            $stmt = $this->pdo->prepare("
            SELECT Quiz.id, Player.username, Category.name, Quiz.difficulty, Quiz.total_score
            FROM Quiz
            INNER JOIN Player ON Quiz.player_id = Player.id
            INNER JOIN Category ON Quiz.category_id = Category.id
            ORDER BY Quiz.total_score DESC
            LIMIT :limit
        ");

            // Bind the parameter for the LIMIT clause
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

            // Execute the prepared statement
            $stmt->execute();

            // Fetch the results as an associative array
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
        } catch (PDOException $e) {
            // Handle any database errors here
            echo "Error: " . $e->getMessage();
            return null; // Query failed
        }
    }
}