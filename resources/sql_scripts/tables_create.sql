DROP TABLE IF EXISTS Quiz;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Player;

CREATE TABLE IF NOT EXISTS Player (
	id serial PRIMARY KEY,
	username VARCHAR(50) UNIQUE NOT NULL,
	password VARCHAR(500) NOT NULL,
	first_name VARCHAR(150),
	last_name VARCHAR(150),
	date_of_birth DATE
);

CREATE TABLE IF NOT EXISTS Category (
  id SERIAL PRIMARY KEY,
  identifier VARCHAR(50) NOT NULL,
  name VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS Quiz (
  id SERIAL PRIMARY KEY,
  player_id INT REFERENCES Player(id),
  difficulty VARCHAR(10) CHECK (difficulty IN ('easy', 'medium', 'hard', 'mixed')),
  category_id INT REFERENCES Category(id),
  total_score INT NOT NULL
);


