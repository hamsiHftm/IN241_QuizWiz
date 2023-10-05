<?php

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
            return null;
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

    /**
     * Update a user's first name, last name, and date of birth based on their username.
     *
     * @param string $username       The username of the user to update.
     * @param string|null $first_name The new first name (optional, set to null to not update).
     * @param string|null $last_name  The new last name (optional, set to null to not update).
     * @param string|null $date_of_birth The new date of birth (optional, set to null to not update).
     *
     * @return bool Returns true if the user's information was successfully updated, false otherwise.
     */
    public function updateUserProfile(string $username, ?string $first_name = null, ?string $last_name = null, ?string $date_of_birth = null): bool
    {
        try {
            // Prepare the SQL statement to update user information
            $sql = "UPDATE Player SET";

            // Add fields to update if provided
            $updates = [];
            if ($first_name !== null) {
                $updates[] = "first_name = :first_name";
            }
            if ($last_name !== null) {
                $updates[] = "last_name = :last_name";
            }
            if ($date_of_birth !== null) {
                $updates[] = "date_of_birth = :date_of_birth";
            }

            // Combine the update clauses
            $sql .= " " . implode(", ", $updates);

            // Add the WHERE clause to specify the user by username
            $sql .= " WHERE username = :username";

            // Prepare the SQL statement with the update query
            $stmt = $this->pdo->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':username', $username);
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

            // Check if any rows were affected
            if ($stmt->rowCount() > 0) {
                return true; // User profile updated successfully
            } else {
                return false; // No rows updated (user not found)
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Save a new quiz record in the database.
     *
     * @param int $playerId     The ID of the player associated with the quiz.
     * @param string $difficulty   The difficulty level of the quiz.
     * @param int $categoryId   The category ID of the quiz.
     * @param int $totalScore   The total score achieved in the quiz.
     *
     * @return bool Returns true if the quiz record was successfully inserted, false otherwise.
     */
    public function saveQuiz(int $playerId, string $difficulty, int $categoryId, int $totalScore): bool
    {
        try {
            // Prepare the SQL statement for inserting a new player
            $stmt = $this->pdo->prepare("INSERT INTO Quiz (player_id, difficulty, category_id, total_score) 
                                        VALUES (:playerId, :difficulty, :categoryId, :totalScore)");

            // Bind parameters
            $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
            $stmt->bindParam(':difficulty', $difficulty);
            $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
            $stmt->bindParam(':totalScore', $totalScore, PDO::PARAM_INT);

            // Execute the statement to insert the record
            $stmt->execute();

            return true; // Record inserted successfully
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Save a new category record in the database.
     *
     * @param string $identifier The identifier of the category.
     * @param string $name       The name of the category.
     *
     * @return bool Returns true if the category record was successfully inserted, false otherwise.
     */
    public function saveCategory(string $identifier, string $name): bool
    {
        try {
            // Prepare the SQL statement for inserting a new player
            $stmt = $this->pdo->prepare("INSERT INTO Category (identifier, name) VALUES (:identifier, :name)");

            // Bind parameters
            $stmt->bindParam(':identifier', $identifier);
            $stmt->bindParam(':name', $name);

            // Execute the statement to insert the record
            $stmt->execute();

            return true; // Record inserted successfully
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Get a category by its identifier and name.
     *
     * @param string $identifier The identifier of the category.
     * @param string $name       The name of the category.
     *
     * @return array|null Returns an associative array with category data if found,
     *                   or null if the category is not found.
     */
    public function getCategoryByIdentifierAndName(string $identifier, string $name): ?array {
        try {
            // Prepare the SQL statement for get the player
            $stmt = $this->pdo->prepare("SELECT * FROM Category where identifier = :identifier and name = :name");

            // Bind the parameters to the prepared statement
            $stmt->bindParam(':identifier', $identifier);
            $stmt->bindParam(':name', $name);

            // Execute the prepared statement
            $stmt->execute();

            // Fetch the result (assuming there's only one matching record)
            return $stmt->fetch(PDO::FETCH_ASSOC); // Return the category record or false if not found
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Retrieve quiz records in descending order of total score with a specified limit.
     *
     * @param int $limit The maximum number of quiz records to retrieve.
     *
     * @return array|null An array of associative arrays representing quiz records or null if the query fails.
     *                    Each associative array contains the following keys:
     *                    - 'id' (int): The unique identifier of the quiz record.
     *                    - 'username' (string): The username of the player who took the quiz.
     *                    - 'name' (string): The name of the category to which the quiz belongs.
     *                    - 'difficulty' (string): The difficulty level of the quiz.
     *                    - 'total_score' (int): The total score achieved in the quiz.
     *
     * @throws PDOException If there are any database-related errors, they will be caught and null will be returned.
     */
    public function getQuizRecordsInDecOrderScore(int $limit): ?array
    {
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
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result !== false) {
                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Get all quizzes played by a user with category information in descending order of score.
     *
     * @param int $playerId The ID of the user whose quizzes you want to retrieve.
     *
     * @return array Returns an array of quiz records with category information, ordered by total_score in descending order.
     */
    public function getAllQuizFromUserWithCategoryInDecOrderScore(int $playerId): array
    {
        try {
            // Prepare the SQL statement to retrieve all quizzes played by the user with category information
            $stmt = $this->pdo->prepare("
            SELECT Q.*, C.identifier AS category_identifier, C.name AS category_name
            FROM Quiz Q
            INNER JOIN Category C ON Q.category_id = C.id
            WHERE Q.player_id = :playerId
            ORDER BY Q.total_score DESC
        ");

            // Bind the parameter for player_id
            $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);

            // Execute the prepared statement
            $stmt->execute();

            // Fetch all results as an array of associative arrays
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Update a user's password in the database.
     *
     * This method allows updating a user's password in the database by providing the username
     * and the hashed new password.
     *
     * @param string $username The username of the user whose password is being updated.
     * @param string $hashedNewPassword The hashed new password to set for the user.
     *
     * @return bool True if the password was successfully updated, false otherwise.
     */
    public function updateUserPassword(string $username, string $hashedNewPassword): bool
    {
        try {
            // Prepare the SQL statement for updating the user's password
            $stmt = $this->pdo->prepare("
            UPDATE Player
            SET password = :hashedNewPassword
            WHERE username = :username
        ");

            // Bind parameters
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':hashedNewPassword', $hashedNewPassword, PDO::PARAM_STR);

            // Execute the statement to update the password
            $stmt->execute();

            // Check if any rows were affected (password updated)
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

}