CREATE TABLE IF NOT EXISTS decapitated_user (
  id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role int(6) NOT NULL DEFAULT 0,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO decapitated_user (id, username, password, role) VALUES (1, 'admin', 'admin', 1);