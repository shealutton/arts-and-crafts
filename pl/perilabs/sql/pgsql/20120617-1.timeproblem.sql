ALTER TABLE variables_time DROP COLUMN value;
ALTER TABLE variables_time ADD COLUMN value timestamp without time zone;

ALTER TABLE users ALTER COLUMN role SET DEFAULT 'user';


