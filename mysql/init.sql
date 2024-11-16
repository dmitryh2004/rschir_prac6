CREATE DATABASE IF NOT EXISTS appDb;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON appDb.* TO 'user'@'%';
FLUSH PRIVILEGES;
USE appDb;

CREATE TABLE IF NOT EXISTS users (
    ID INT(10) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) CHARACTER SET ascii NOT NULL,
    password VARCHAR(50) CHARACTER SET ascii NOT NULL,
    PRIMARY KEY (ID)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS services (
    ID INT(10) NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    cost INT(10) NOT NULL,
    PRIMARY KEY (ID)
    ) DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS entries (
    entry_id int(10) not null AUTO_INCREMENT,
    customer_name text not null,
    service_id int(10) not null,
    amount int(10) not null,
    comment text null,
    primary key(entry_id),
    foreign key (service_id) references services(ID)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- htpasswd -bns admin admin
INSERT INTO users (name, password)
SELECT * FROM (SELECT 'admin', '{SHA}0DPiKuNIrrVmD8IUCuw1hQxNqZc=') AS temp
WHERE NOT EXISTS (
        SELECT name FROM users WHERE name = 'admin' AND password = '{SHA}0DPiKuNIrrVmD8IUCuw1hQxNqZc='
    ) LIMIT 1;

INSERT INTO services (title, description, cost)
VALUES ('Technical inspection', 'General vehicle inspection', 500),
    ('Wheel Replacement', 'Replacing a car wheel with another one. The cost of the wheel is not included in the price of the service.', 1500),
    ("Inflating tires", "Pumping tires on a car. The price for one wheel is indicated.", 250);