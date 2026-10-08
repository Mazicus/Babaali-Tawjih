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
