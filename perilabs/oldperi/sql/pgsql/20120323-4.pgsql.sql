-- Preliminary trigger to keep rowcount updated. Three parts:
-- 1. Create a view to extract user__id from a m_value_id
-- 2. Create function to counter++ when a row is added/removed
-- 3. Add trigger on m_* to call function 

DROP TRIGGER countrows_m_int ON m_int;
DROP TRIGGER countrows_m_bin ON m_bin;
DROP TRIGGER countrows_m_bool ON m_bool;
DROP TRIGGER countrows_m_real ON m_real;
DROP TRIGGER countrows_m_time ON m_time;
DROP TRIGGER countrows_m_text ON m_text;

DROP TRIGGER countrows_m_time ON m_time;
DROP VIEW vi_m_time_users;

CREATE VIEW vi_m_time_users AS
SELECT e.user__id,
 e.experiment_id,
 t.trial_id,
 r.result_id,
 m.m_value_id
FROM experiments e, trials t, results r, m_time m
 WHERE m.result__id = r.result_id
 AND r.trial__id = t.trial_id
 AND e.experiment_id = t.experiment__id;


CREATE OR REPLACE FUNCTION count_rows_m_time()
RETURNS TRIGGER AS
'
   BEGIN
      IF TG_OP = ''INSERT'' THEN
        UPDATE rowcount
          SET total_rows = total_rows + 1
          WHERE table_name = TG_RELNAME 
          AND user__id = (SELECT user__id from vi_m_time_users where m_value_id = NEW.m_value_id);
      END IF;
      RETURN NULL;
   END;
' LANGUAGE plpgsql;

BEGIN;
LOCK TABLE m_time IN SHARE ROW EXCLUSIVE MODE;
 create TRIGGER countrows_m_time
  AFTER INSERT on m_time
  FOR EACH ROW EXECUTE PROCEDURE count_rows_m_time();
COMMIT;

DROP TRIGGER countrows_m_text ON m_text;
DROP VIEW vi_m_text_users;

CREATE VIEW vi_m_text_users AS
SELECT e.user__id,
 e.experiment_id,
 t.trial_id,
 r.result_id,
 m.m_value_id
FROM experiments e, trials t, results r, m_text m
 WHERE m.result__id = r.result_id
 AND r.trial__id = t.trial_id
 AND e.experiment_id = t.experiment__id;


CREATE OR REPLACE FUNCTION count_rows_m_text()
RETURNS TRIGGER AS
'
   BEGIN
      IF TG_OP = ''INSERT'' THEN
        UPDATE rowcount
          SET total_rows = total_rows + 1
          WHERE table_name = TG_RELNAME 
          AND user__id = (SELECT user__id from vi_m_text_users where m_value_id = NEW.m_value_id);
      END IF;
      RETURN NULL;
   END;
' LANGUAGE plpgsql;

BEGIN;
LOCK TABLE m_text IN SHARE ROW EXCLUSIVE MODE;
 create TRIGGER countrows_m_text
  AFTER INSERT on m_text
  FOR EACH ROW EXECUTE PROCEDURE count_rows_m_text();
COMMIT;

DROP TRIGGER countrows_m_bin ON m_bin;
DROP VIEW vi_m_bin_users;

CREATE VIEW vi_m_bin_users AS
SELECT e.user__id,
 e.experiment_id,
 t.trial_id,
 r.result_id,
 m.m_value_id
FROM experiments e, trials t, results r, m_bin m
 WHERE m.result__id = r.result_id
 AND r.trial__id = t.trial_id
 AND e.experiment_id = t.experiment__id;


CREATE OR REPLACE FUNCTION count_rows_m_bin()
RETURNS TRIGGER AS
'
   BEGIN
      IF TG_OP = ''INSERT'' THEN
        UPDATE rowcount
          SET total_rows = total_rows + 1
          WHERE table_name = TG_RELNAME 
          AND user__id = (SELECT user__id from vi_m_bin_users where m_value_id = NEW.m_value_id);
      END IF;
      RETURN NULL;
   END;
' LANGUAGE plpgsql;

BEGIN;
LOCK TABLE m_bin IN SHARE ROW EXCLUSIVE MODE;
 create TRIGGER countrows_m_bin
  AFTER INSERT on m_bin
  FOR EACH ROW EXECUTE PROCEDURE count_rows_m_bin();
COMMIT;

DROP TRIGGER countrows_m_bool ON m_bool;
DROP VIEW vi_m_bool_users;

CREATE VIEW vi_m_bool_users AS
SELECT e.user__id,
 e.experiment_id,
 t.trial_id,
 r.result_id,
 m.m_value_id
FROM experiments e, trials t, results r, m_bool m
 WHERE m.result__id = r.result_id
 AND r.trial__id = t.trial_id
 AND e.experiment_id = t.experiment__id;


CREATE OR REPLACE FUNCTION count_rows_m_bool()
RETURNS TRIGGER AS
'
   BEGIN
      IF TG_OP = ''INSERT'' THEN
        UPDATE rowcount
          SET total_rows = total_rows + 1
          WHERE table_name = TG_RELNAME 
          AND user__id = (SELECT user__id from vi_m_bool_users where m_value_id = NEW.m_value_id);
      END IF;
      RETURN NULL;
   END;
' LANGUAGE plpgsql;

BEGIN;
LOCK TABLE m_bool IN SHARE ROW EXCLUSIVE MODE;
 create TRIGGER countrows_m_bool
  AFTER INSERT on m_bool
  FOR EACH ROW EXECUTE PROCEDURE count_rows_m_bool();
COMMIT;

DROP TRIGGER countrows_m_int ON m_int;
DROP VIEW vi_m_int_users;

CREATE VIEW vi_m_int_users AS
SELECT e.user__id,
 e.experiment_id,
 t.trial_id,
 r.result_id,
 m.m_value_id
FROM experiments e, trials t, results r, m_int m
 WHERE m.result__id = r.result_id
 AND r.trial__id = t.trial_id
 AND e.experiment_id = t.experiment__id;


CREATE OR REPLACE FUNCTION count_rows_m_int()
RETURNS TRIGGER AS
'
   BEGIN
      IF TG_OP = ''INSERT'' THEN
        UPDATE rowcount
          SET total_rows = total_rows + 1
          WHERE table_name = TG_RELNAME 
          AND user__id = (SELECT user__id from vi_m_int_users where m_value_id = NEW.m_value_id);
      END IF;
      RETURN NULL;
   END;
' LANGUAGE plpgsql;

BEGIN;
LOCK TABLE m_int IN SHARE ROW EXCLUSIVE MODE;
 create TRIGGER countrows_m_int
  AFTER INSERT on m_int
  FOR EACH ROW EXECUTE PROCEDURE count_rows_m_int();
COMMIT;

DROP TRIGGER countrows_m_real ON m_real;
DROP VIEW vi_m_real_users;

CREATE VIEW vi_m_real_users AS
SELECT e.user__id,
 e.experiment_id,
 t.trial_id,
 r.result_id,
 m.m_value_id
FROM experiments e, trials t, results r, m_real m
 WHERE m.result__id = r.result_id
 AND r.trial__id = t.trial_id
 AND e.experiment_id = t.experiment__id;


CREATE OR REPLACE FUNCTION count_rows_m_real()
RETURNS TRIGGER AS
'
   BEGIN
      IF TG_OP = ''INSERT'' THEN
        UPDATE rowcount
          SET total_rows = total_rows + 1
          WHERE table_name = TG_RELNAME 
          AND user__id = (SELECT user__id from vi_m_real_users where m_value_id = NEW.m_value_id);
      END IF;
      RETURN NULL;
   END;
' LANGUAGE plpgsql;

BEGIN;
LOCK TABLE m_real IN SHARE ROW EXCLUSIVE MODE;
 create TRIGGER countrows_m_real
  AFTER INSERT on m_real
  FOR EACH ROW EXECUTE PROCEDURE count_rows_m_real();
COMMIT;



