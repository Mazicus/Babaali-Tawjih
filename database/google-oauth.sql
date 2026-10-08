-- Run once on the existing database before enabling Google sign-in.
CREATE TABLE IF NOT EXISTS google_accounts (
    google_sub VARCHAR(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL UNIQUE,
    CONSTRAINT google_accounts_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;
