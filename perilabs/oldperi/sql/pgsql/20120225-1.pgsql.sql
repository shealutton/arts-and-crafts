CREATE TABLE m_bin (
  metric__id integer NOT NULL REFERENCES metrics(metric_id) ON DELETE CASCADE,
  result__id integer NOT NULL REFERENCES results(result_id) ON DELETE CASCADE,
  value bytea NOT NULL,
  m_value_id bigint PRIMARY KEY
  );

CREATE TABLE m_bool (
  metric__id integer NOT NULL REFERENCES metrics(metric_id) ON DELETE CASCADE,
  result__id integer NOT NULL REFERENCES results(result_id) ON DELETE CASCADE,
  value boolean NOT NULL,
  m_value_id bigint PRIMARY KEY
  );

CREATE TABLE m_int (
  metric__id integer NOT NULL REFERENCES metrics(metric_id) ON DELETE CASCADE,
  result__id integer NOT NULL REFERENCES results(result_id) ON DELETE CASCADE,
  value integer NOT NULL,
  m_value_id bigint PRIMARY KEY
  );

CREATE TABLE m_real (
  metric__id integer NOT NULL REFERENCES metrics(metric_id) ON DELETE CASCADE,
  result__id integer NOT NULL REFERENCES results(result_id) ON DELETE CASCADE,
  value real NOT NULL,
  m_value_id bigint PRIMARY KEY
  );

CREATE TABLE m_text (
  metric__id integer NOT NULL REFERENCES metrics(metric_id) ON DELETE CASCADE,
  result__id integer NOT NULL REFERENCES results(result_id) ON DELETE CASCADE,
  value text NOT NULL,
  m_value_id bigint PRIMARY KEY
  );

CREATE TABLE m_time (
  metric__id integer NOT NULL REFERENCES metrics(metric_id) ON DELETE CASCADE,
  result__id integer NOT NULL REFERENCES results(result_id) ON DELETE CASCADE,
  value timestamp with time zone NOT NULL,
  m_value_id bigint PRIMARY KEY
  );


CREATE SEQUENCE m_bin_m_value_id_seq;
CREATE SEQUENCE m_bool_m_value_id_seq;
CREATE SEQUENCE m_int_m_value_id_seq;
CREATE SEQUENCE m_real_m_value_id_seq;
CREATE SEQUENCE m_time_m_value_id_seq;
CREATE SEQUENCE m_text_m_value_id_seq;

ALTER TABLE m_bin ALTER COLUMN m_value_id SET DEFAULT nextval('m_bin_m_value_id_seq'::regclass);
ALTER TABLE m_bool ALTER COLUMN m_value_id SET DEFAULT nextval('m_bool_m_value_id_seq'::regclass);
ALTER TABLE m_int ALTER COLUMN m_value_id SET DEFAULT nextval('m_int_m_value_id_seq'::regclass);
ALTER TABLE m_real ALTER COLUMN m_value_id SET DEFAULT nextval('m_real_m_value_id_seq'::regclass);
ALTER TABLE m_time ALTER COLUMN m_value_id SET DEFAULT nextval('m_time_m_value_id_seq'::regclass);
ALTER TABLE m_text ALTER COLUMN m_value_id SET DEFAULT nextval('m_text_m_value_id_seq'::regclass);

