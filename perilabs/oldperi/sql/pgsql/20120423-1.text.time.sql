
CREATE TABLE variables_time (
  var_time_id bigint PRIMARY KEY,
  variable__id integer NOT NULL REFERENCES variables(variable_id) ON DELETE CASCADE,
  value timestamp with time zone NOT NULL
  );

CREATE TABLE variables_text (
  var_text_id bigint PRIMARY KEY,
  variable__id integer NOT NULL REFERENCES variables(variable_id) ON DELETE CASCADE,
  value text NOT NULL
  );

CREATE SEQUENCE variables_time_var_time_id_seq;
CREATE SEQUENCE variables_text_var_text_id_seq;

ALTER TABLE variables_time ALTER COLUMN var_time_id SET DEFAULT nextval('variables_time_var_time_id_seq'::regclass);
ALTER TABLE variables_text ALTER COLUMN var_text_id SET DEFAULT nextval('variables_text_var_text_id_seq'::regclass);

