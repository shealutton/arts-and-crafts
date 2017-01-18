-- Add a filesize to help calculate user space usage
-- Applies to all uploaded/created documents

ALTER TABLE documents ADD COLUMN filesize integer;
UPDATE documents SET filesize = '0' where document_id > '0';
ALTER TABLE documents ALTER COLUMN filesize SET NOT NULL;
