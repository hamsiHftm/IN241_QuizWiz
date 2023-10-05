<?php

class User
{
    private ?int $dbId;
    private ?string $username;
    private ?string $firstname;
    private ?string $lastname;
    private ?string $dateOfBirth;
    private ?int $scoredHighScore;
    private ?int $nrOfPlayedGames;

    public function __construct($dbId, $username, $firstname, $lastname, $dateOfBirth)
    {
        $this->dbId = $dbId;
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->dateOfBirth = $dateOfBirth;
        $this->scoredHighScore = null;
        $this->nrOfPlayedGames = null;
    }

    public function getDBId(): int
    {
        return $this->dbId;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function getDateOfBirth(): ?string
    {
        return $this->dateOfBirth;
    }

    public function getScoredHighScore(): ?int
    {
        return $this->scoredHighScore;
    }

    public function getNrOfPlayedGames(): ?int
    {
        return $this->nrOfPlayedGames;
    }

    public function setDBId($dbId): void
    {
        $this->dbId = $dbId;
    }

    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    public function setDateOfBirth($dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function setScoredHighScore($scoredHighScore): void
    {
        $this->scoredHighScore = $scoredHighScore;
    }

    public function setNrOfPlayedGames($nrOfPlayedGames): void
    {
        $this->nrOfPlayedGames = $nrOfPlayedGames;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->dbId,
            'username' => $this->username,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname
        ];
    }

    public static function fromArray(array $data): User
    {
        return new self(
            $data['id'],
            $data['username'],
            $data['firstname'],
            $data['lastname'],
            null
        );
    }
}