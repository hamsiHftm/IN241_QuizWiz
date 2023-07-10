CREATE TABLE IF NOT EXISTS Player (
	id serial PRIMARY KEY,
	username VARCHAR(50) UNIQUE NOT NULL,
	password VARCHAR(500) NOT NULL,
	salt VARCHAR(250) NOT NULL,
	first_name VARCHAR(150),
	last_name VARCHAR(150),
	date_of_birth DATE,
	quiz_session_token VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS Category (
  id SERIAL PRIMARY KEY,
  identifier VARCHAR(50) NOT NULL,
  name VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS Game (
  id SERIAL PRIMARY KEY,
  player_id INT REFERENCES Player(id),
  mode VARCHAR(10) CHECK (mode IN ('easy', 'medium', 'hard')),
  category_id INT REFERENCES Category(id),
  total_score INT NOT NULL
);


