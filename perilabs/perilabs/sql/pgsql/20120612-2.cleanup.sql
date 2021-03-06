DROP FUNCTION update_timestamp_column();
DROP FUNCTION update_experiments_time() CASCADE;
DROP FUNCTION update_exp_last_updated_v2();

CREATE OR REPLACE FUNCTION update_exp_last_updated()
RETURNS TRIGGER AS
'
BEGIN
  IF (TG_OP = ''UPDATE'') OR (TG_OP = ''DELETE'') THEN
    UPDATE experiments SET last_updated = now() WHERE experiment_id = OLD.experiment__id;
    RETURN OLD;
  ELSIF (TG_OP = ''INSERT'') THEN
    UPDATE experiments SET last_updated = now() WHERE experiment_id = NEW.experiment__id;
    RETURN NEW;
  END IF;
  RETURN NULL;
EXCEPTION
 WHEN UNIQUE_VIOLATION THEN
 -- do nothing
 RETURN NULL;
END;
'
LANGUAGE plpgsql;

BEGIN;
  CREATE TRIGGER time_last_updated
    AFTER UPDATE OR INSERT OR DELETE ON variables
    FOR EACH ROW EXECUTE PROCEDURE update_exp_last_updated();
COMMIT;

BEGIN;
  CREATE TRIGGER time_last_updated
    AFTER UPDATE OR INSERT OR DELETE ON constants
    FOR EACH ROW EXECUTE PROCEDURE update_exp_last_updated();
COMMIT;

BEGIN;
  CREATE TRIGGER time_last_updated
    AFTER UPDATE OR INSERT OR DELETE ON metrics
    FOR EACH ROW EXECUTE PROCEDURE update_exp_last_updated();
COMMIT;

BEGIN;
  CREATE TRIGGER time_last_updated
    AFTER UPDATE OR INSERT OR DELETE ON trials
    FOR EACH ROW EXECUTE PROCEDURE update_exp_last_updated();
COMMIT;


