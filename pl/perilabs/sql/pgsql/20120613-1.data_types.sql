ALTER TABLE data_types ADD COLUMN tablename varchar(10);
UPDATE data_types SET tablename = 'm_bool' WHERE data_type_id = '1';
UPDATE data_types SET tablename = 'm_int' WHERE data_type_id = '2';
UPDATE data_types SET tablename = 'm_real' WHERE data_type_id = '3';
UPDATE data_types SET tablename = 'm_text' WHERE data_type_id = '4';
UPDATE data_types SET tablename = 'm_time' WHERE data_type_id = '6';
ALTER TABLE data_types ALTER COLUMN tablename SET DEFAULT NOT NULL; 
