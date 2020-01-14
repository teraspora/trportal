CREATE TABLE users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(128) NOT NULL,
    email VARCHAR(512) NOT NULL UNIQUE,
    admin TINYINT(1) UNSIGNED DEFAULT 0,
    password VARCHAR(128) NOT NULL,
    status TINYINT(1) UNSIGNED DEFAULT 1,
    created_by INT(11) UNSIGNED,
    FOREIGN KEY (created_by) REFERENCES users(id),
    created_on DATETIME
);

CREATE TABLE results (
    job_processing_uid INT(11) UNSIGNED,
    test_type_uid INT(5) UNSIGNED,
    test_counter INT(5) UNSIGNED,
    number VARCHAR(20),
    country VARCHAR(100),
    start_time DATETIME,
    end_time DATETIME,
    connect_time DATETIME,
    score FLOAT(5, 2) UNSIGNED,
    url VARCHAR(1024),
    added_by INT(11) UNSIGNED,
    added_on DATETIME,
    FOREIGN KEY (added_by) REFERENCES users(id),
    PRIMARY KEY (job_processing_uid, test_type_uid, test_counter)
);

CREATE TRIGGER tr_insert_added_on
BEFORE INSERT ON results
FOR EACH ROW
SET new.added_on = CURRENT_TIMESTAMP;

CREATE TRIGGER tr_insert_user_created_on
BEFORE INSERT ON users
FOR EACH ROW
SET new.created_on = CURRENT_TIMESTAMP;
