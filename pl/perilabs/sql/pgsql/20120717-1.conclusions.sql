CREATE TABLE conclusions (
  conclusion_id serial PRIMARY KEY,
  experiment__id bigint NOT NULL REFERENCES experiments(experiment_id) ON DELETE CASCADE,
  description text NOT NULL
  );
  

ALTER TABLE conclusions ADD COLUMN ts_en tsvector;

UPDATE conclusions SET ts_en =
  setweight(to_tsvector('english', coalesce(conclusions.description,'')), 'A');

CREATE INDEX index_conclusions_ts_en ON conclusions USING gin(ts_en);

CREATE FUNCTION update_ts_en_conclusions() RETURNS trigger AS $$
begin
  new.ts_en :=
     setweight(to_tsvector('english', coalesce(conclusions.description,'')), 'A');
  return new;
end
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_ts_en_conclusions BEFORE INSERT OR UPDATE ON conclusions
  FOR EACH ROW EXECUTE PROCEDURE update_ts_en_conclusions();

CREATE OR REPLACE FUNCTION update_ts_en_conclusions() RETURNS trigger AS $$
begin
  new.ts_en :=
     setweight(to_tsvector('english', coalesce(new.description,'')), 'A');
  return new;
end
$$ LANGUAGE plpgsql;

ALTER TABLE experiments ADD COLUMN user__id bigint REFERENCES users(id);
