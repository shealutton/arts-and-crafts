ALTER TABLE documents ADD COLUMN mime varchar(256);
UPDATE documents SET mime = 'text/enriched' where document_id > '0';
ALTER TABLE documents ALTER COLUMN mime SET NOT NULL;
