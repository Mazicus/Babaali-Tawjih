-- Run against a NEW hosted MySQL database. This creates tables, not existing accounts.
CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    adress_email VARCHAR(254) NOT NULL UNIQUE,
    phonenumber VARCHAR(32) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS contact (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    adresse_email VARCHAR(254) NOT NULL,
    message_TEXT TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS site_sessions (
    id VARCHAR(128) CHARACTER SET ascii COLLATE ascii_bin NOT NULL PRIMARY KEY,
    data MEDIUMBLOB NOT NULL,
    expires_at BIGINT NOT NULL,
    INDEX sessions_expiry (expires_at)
) ENGINE=InnoDB;
