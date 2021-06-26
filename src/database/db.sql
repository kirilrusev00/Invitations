DROP DATABASE if EXISTS invitations;

CREATE DATABASE invitations;

USE invitations;

CREATE TABLE users (
  id                INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  email             VARCHAR(50) NOT NULL UNIQUE,
  password          VARCHAR(50) NOT NULL,
  first_name        VARCHAR(50) NOT NULL,
  last_name         VARCHAR(50) NOT NULL,
  fn                INT(10) NOT NULL UNIQUE,
  course            INT(2) NOT NULL,
  specialty         VARCHAR(50) NOT NULL,
  created_at        DATETIME DEFAULT NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE events ( 
  id                INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  start_time        DATETIME NOT NULL,
  end_time          DATETIME NOT NULL,
  venue             VARCHAR(255) NOT NULL,
  name              VARCHAR(255) NOT NULL,
  meeting_link      VARCHAR(255) NULL,
  meeting_password  VARCHAR(255) NULL,
  created_by        INT NOT NULL,
  created_at        DATETIME DEFAULT NOW()
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE resources (
  id                INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  file_name         VARCHAR(255) NOT NULL,
  status            ENUM('1','0') NOT NULL DEFAULT '1',
  uploaded_at       DATETIME NOT NULL,
  event_id          INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE responses (
  id                INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  user_id           INT NOT NULL,
  event_id          INT NOT NULL,
  status            ENUM('going','not going', 'interested', 'invited') NOT NULL DEFAULT 'invited',
  created_at        DATETIME NOT NULL DEFAULT NOW(),
  updated_at        DATETIME NOT NULL DEFAULT NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE
  events
ADD
  CONSTRAINT foreign_key_events_created_by FOREIGN KEY (created_by) REFERENCES users(id);

ALTER TABLE
  resources
ADD
  CONSTRAINT foreign_key_resources_event FOREIGN KEY (event_id) REFERENCES events(id);

ALTER TABLE
  responses
ADD
  CONSTRAINT foreign_key_responses_user FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE
  responses
ADD
  CONSTRAINT foreign_key_responses_event FOREIGN KEY (event_id) REFERENCES events(id);