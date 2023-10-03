<?php

class User
{
    private $dbId;
    private $username;
    private $firstname;
    private $lastname;
    private $dateOfBirth;
    private $scoredHighScore;
    private $nrOfPlayedGames;

    public function __construct($dbId, $username, $firstname, $lastname, $dateOfBirth)
    {
        $this->dbId = $dbId;
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @return mixed
     */
    public function getScoredHighScore()
    {
        return $this->scoredHighScore;
    }

    /**
     * @return mixed
     */
    public function getNrOfPlayedGames()
    {
        return $this->nrOfPlayedGames;
    }

    /**
     * @param mixed $scoredHighScore
     */
    public function setScoredHighScore($scoredHighScore): void
    {
        $this->scoredHighScore = $scoredHighScore;
    }

    /**
     * @param mixed $nrOfPlayedGames
     */
    public function setNrOfPlayedGames($nrOfPlayedGames): void
    {
        $this->nrOfPlayedGames = $nrOfPlayedGames;
    }

    public function toArray()
    {
        return [
            'id' => $this->dbId,
            'username' => $this->username,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname
        ];
    }


}