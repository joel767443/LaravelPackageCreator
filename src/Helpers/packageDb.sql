-- auto-generated definition
CREATE TABLE IF NOT EXISTS projects
(
  id INTEGER NOT NULL,
  name           VARCHAR(255),
  project_status INT,
  start_date     TIMESTAMP
);
CREATE UNIQUE INDEX projects_id_uindex
  ON projects (id);


-- auto-generated definition
CREATE TABLE modules
(
  id INTEGER NOT NULL,
  name VARCHAR(255)
);
CREATE UNIQUE INDEX modules_id_uindex
  ON modules (id);


-- auto-generated definition
CREATE TABLE module_attributes
(
  id        INTEGER NOT NULL,
  module_id INTEGER,
  desc      VARCHAR(255)
);
CREATE UNIQUE INDEX module_attributes_id_uindex
  ON module_attributes (id);
