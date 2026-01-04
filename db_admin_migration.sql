
ALTER TABLE users ADD COLUMN is_admin TINYINT(1) DEFAULT 0 AFTER email_verified;

--  notices table
CREATE TABLE IF NOT EXISTS notices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  is_published TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--  news table
CREATE TABLE IF NOT EXISTS news (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  image VARCHAR(255) DEFAULT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  is_published TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--  gallery table
CREATE TABLE IF NOT EXISTS gallery (
  id INT AUTO_INCREMENT PRIMARY KEY,
  filename VARCHAR(255) NOT NULL,
  caption VARCHAR(255) DEFAULT NULL,
  uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- admin user 
INSERT INTO users (username, password, full_name, email, email_verified, is_admin)
VALUES ('admin', MD5('naeembadhanpstu'), 'Site Admin', 'admin@local', 1, 1);


CREATE INDEX idx_notices_published ON notices (is_published);
CREATE INDEX idx_news_published ON news (is_published);
