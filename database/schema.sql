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

-- Run once on the existing database before enabling Google sign-in.
CREATE TABLE IF NOT EXISTS google_accounts (
    google_sub VARCHAR(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL UNIQUE,
    CONSTRAINT google_accounts_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Add persistent personal data to the existing hosted MySQL database.
CREATE TABLE IF NOT EXISTS user_favorites (
    user_id BIGINT UNSIGNED NOT NULL,
    school_id INT UNSIGNED NOT NULL,
    saved_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, school_id),
    CONSTRAINT user_favorites_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS user_avatars (
    user_id BIGINT UNSIGNED NOT NULL PRIMARY KEY,
    mime_type VARCHAR(32) NOT NULL,
    image_data MEDIUMBLOB NOT NULL,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT user_avatars_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS password_reset_tokens (
    token_hash CHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    expires_at BIGINT NOT NULL,
    INDEX reset_user (user_id),
    INDEX reset_expiry (expires_at),
    CONSTRAINT password_reset_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS password_reset_requests (
    request_key CHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL PRIMARY KEY,
    requested_at BIGINT NOT NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS account_auth_versions (
    user_id BIGINT UNSIGNED NOT NULL PRIMARY KEY,
    version BIGINT UNSIGNED NOT NULL DEFAULT 0,
    CONSTRAINT auth_version_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;
