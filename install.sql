CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(32) NOT NULL UNIQUE,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  is_admin TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL,
  slug VARCHAR(80) NOT NULL UNIQUE,
  description VARCHAR(255) NULL,
  sort_order INT NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE threads (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL,
  user_id INT NOT NULL,
  title VARCHAR(140) NOT NULL,
  is_locked TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX (category_id),
  INDEX (created_at)
);

CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  thread_id INT NOT NULL,
  user_id INT NOT NULL,
  body TEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL,
  FOREIGN KEY (thread_id) REFERENCES threads(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX (thread_id),
  INDEX (created_at)
);

-- Seed categories
INSERT INTO categories (name, slug, description, sort_order) VALUES
('Announcements','announcements','Official announcements and news',1),
('Updates','updates','Patch notes and changes',2),
('Support','support','Help, bug reports, and questions',3),
('Applications','applications','Whitelist and staff applications',4),
('Suggestions','suggestions','Ideas and feedback',5);

