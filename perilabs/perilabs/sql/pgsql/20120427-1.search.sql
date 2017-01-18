ALTER TABLE experiments ADD COLUMN ts_en tsvector;
ALTER TABLE constants ADD COLUMN ts_en tsvector;
ALTER TABLE variables ADD COLUMN ts_en tsvector;
ALTER TABLE metrics ADD COLUMN ts_en tsvector;
ALTER TABLE trials ADD COLUMN ts_en tsvector;
ALTER TABLE documents ADD COLUMN ts_en tsvector;

UPDATE experiments SET ts_en =
  setweight(to_tsvector('english', coalesce(experiments.title,'')), 'A') ||
  setweight(to_tsvector('english', coalesce(experiments.goal,'')), 'B');
UPDATE constants SET ts_en =
  setweight(to_tsvector('english', coalesce(constants.title,'')), 'B') ||
  setweight(to_tsvector('english', coalesce(constants.description,'')), 'C');
UPDATE variables SET ts_en =
  setweight(to_tsvector('english', coalesce(variables.title,'')), 'B') ||
  setweight(to_tsvector('english', coalesce(variables.description,'')), 'C');
UPDATE metrics SET ts_en =
  setweight(to_tsvector('english', coalesce(metrics.title,'')), 'B') ||
  setweight(to_tsvector('english', coalesce(metrics.description,'')), 'C');
UPDATE trials SET ts_en =
  setweight(to_tsvector('english', coalesce(trials.title,'')), 'C');
UPDATE documents SET ts_en =
  setweight(to_tsvector('english', coalesce(documents.file_name,'')), 'C');

CREATE INDEX index_experiments_ts_en ON experiments USING gin(ts_en);
CREATE INDEX index_constants_ts_en ON constants USING gin(ts_en);
CREATE INDEX index_variables_ts_en ON variables USING gin(ts_en);
CREATE INDEX index_metrics_ts_en ON metrics USING gin(ts_en);
CREATE INDEX index_documents_ts_en ON documents USING gin(ts_en);
CREATE INDEX index_trials_ts_en ON trials USING gin(ts_en);

CREATE FUNCTION update_ts_en_experiments() RETURNS trigger AS $$
begin
  new.ts_en :=
     setweight(to_tsvector('pg_catalog.english', coalesce(new.title,'')), 'A') ||
     setweight(to_tsvector('pg_catalog.english', coalesce(new.goal,'')), 'B');
  return new;
end
$$ LANGUAGE plpgsql;

CREATE FUNCTION update_ts_en_var_con_met() RETURNS trigger AS $$
begin
  new.ts_en :=
     setweight(to_tsvector('pg_catalog.english', coalesce(new.title,'')), 'B') ||
     setweight(to_tsvector('pg_catalog.english', coalesce(new.description,'')), 'C');
  return new;
end
$$ LANGUAGE plpgsql;

CREATE FUNCTION update_ts_en_trials() RETURNS trigger AS $$
begin
  new.ts_en :=
     setweight(to_tsvector('pg_catalog.english', coalesce(new.title,'')), 'C');
  return new;
end
$$ LANGUAGE plpgsql;

CREATE FUNCTION update_ts_en_documents() RETURNS trigger AS $$
begin
  new.ts_en :=
     setweight(to_tsvector('pg_catalog.english', coalesce(new.file_name,'')), 'C');
  return new;
end
$$ LANGUAGE plpgsql;


CREATE TRIGGER trigger_ts_en_experiments BEFORE INSERT OR UPDATE ON experiments 
  FOR EACH ROW EXECUTE PROCEDURE update_ts_en_experiments();

CREATE TRIGGER trigger_ts_en_variables BEFORE INSERT OR UPDATE ON variables 
  FOR EACH ROW EXECUTE PROCEDURE update_ts_en_var_con_met();

CREATE TRIGGER trigger_ts_en_constants BEFORE INSERT OR UPDATE ON constants 
  FOR EACH ROW EXECUTE PROCEDURE update_ts_en_var_con_met();

CREATE TRIGGER trigger_ts_en_metrics BEFORE INSERT OR UPDATE ON metrics 
  FOR EACH ROW EXECUTE PROCEDURE update_ts_en_var_con_met();

CREATE TRIGGER trigger_ts_en_trials BEFORE INSERT OR UPDATE ON trials 
  FOR EACH ROW EXECUTE PROCEDURE update_ts_en_trials();

CREATE TRIGGER trigger_ts_en_documents BEFORE INSERT OR UPDATE ON documents 
  FOR EACH ROW EXECUTE PROCEDURE update_ts_en_documents();
