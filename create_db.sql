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
    id VARCHAR(23) PRIMARY KEY,
    job_processing_id INT(11) UNSIGNED,
    test_type_id INT(5) UNSIGNED,
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
    FOREIGN KEY (added_by) REFERENCES users(id)
);

CREATE TRIGGER insert_result_id_generator
BEFORE INSERT ON results
FOR EACH ROW
SET new.id = CONCAT(new.job_processing_id, '_', new.test_type_id, '_', new.test_counter);

CREATE TRIGGER update_result_id_generator
BEFORE UPDATE ON results
FOR EACH ROW
SET new.id = CONCAT(new.job_processing_id, '_', new.test_type_id, '_', new.test_counter);
