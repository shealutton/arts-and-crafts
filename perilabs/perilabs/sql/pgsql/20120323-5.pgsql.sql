-- The triggers to keep rowcount updated does not initialize, only update.
-- A second trigger is required to initialize the rowcount values. 
-- This trigger and function is called on the experiments table to set
-- an initial value or do nothing if already set. 

CREATE FUNCTION initialize_rowcount() 
RETURNS TRIGGER AS
'
DECLARE
  m_tables TEXT;
BEGIN
  IF TG_OP = ''INSERT'' THEN
    FOR m_tables IN SELECT tablename FROM pg_tables WHERE tablename LIKE E''m\\\\_%'' LOOP
      INSERT INTO rowcount (total_rows, table_name, user__id) VALUES ( ''0'', m_tables, NEW.user__id);
    END LOOP;
  END IF;
  RETURN NULL;
EXCEPTION
 WHEN UNIQUE_VIOLATION THEN
 -- do nothing
 RETURN NULL;
END;
'LANGUAGE plpgsql;

BEGIN;
  LOCK TABLE experiments IN SHARE ROW EXCLUSIVE MODE;	
  create TRIGGER init_rowcount
    AFTER INSERT on experiments
    FOR EACH ROW EXECUTE PROCEDURE initialize_rowcount();
COMMIT;

