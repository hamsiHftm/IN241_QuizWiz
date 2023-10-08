-- Example data for the Player table (without session_token and hashed_password)
-- The password can be set with the Forgot password function without any verification with the username
INSERT INTO Player (username, password, first_name, last_name, date_of_birth)
VALUES
    ('john_15', '12345', 'John', 'Doe', '1990-05-15'),
    ('alice_10', '12345', 'Alice', 'Smith', '1985-12-10'),
    ('bob_25', '12345', 'Bob', 'Johnson', '1995-07-25'),
    ('eve_03', '12345', 'Eve', 'Wilson', '1980-03-03'),
    ('grace_20', '12345',  'Grace', 'Brown', '2000-09-20');

-- Example data for the Category table
INSERT INTO Category (identifier, name)
VALUES
    ('9', 'General Knowledge'),
    ('14', 'Entertainment: Television'),
    ('19', 'Science: Mathematics');

-- Example data for the Quiz table
INSERT INTO Quiz (player_id, difficulty, category_id, total_score)
VALUES
    (1, 'easy', 1, 100),
    (2, 'medium', 2, 85),
    (3, 'hard', 3, 70),
    (4, 'easy', 1, 95),
    (5, 'medium', 2, 80),
    (1, 'hard', 3, 60),
    (2, 'easy', 1, 90),
    (3, 'medium', 2, 75),
    (4, 'hard', 3, 55),
    (5, 'easy', 1, 105),
    (1, 'medium', 2, 88),
    (2, 'hard', 3, 68),
    (3, 'easy', 1, 92),
    (4, 'medium', 2, 78),
    (5, 'hard', 3, 58);
