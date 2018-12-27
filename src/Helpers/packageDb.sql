-- auto-generated definition
CREATE TABLE projects
(
  id             INTEGER NOT NULL,
  name           VARCHAR(255),
  project_status INT,
  start_date     TIMESTAMP
);
CREATE UNIQUE INDEX projects_id_uindex
  ON projects (id);


-- auto-generated definition
CREATE TABLE modules
(
  id   INTEGER NOT NULL,
  name VARCHAR(255)
);
CREATE UNIQUE INDEX modules_id_uindex
  ON modules (id);
