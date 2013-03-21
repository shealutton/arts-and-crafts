-- columns for uploading data, recording parse issues. From Will

ALTER TABLE documents ADD parseable boolean;
ALTER TABLE documents ADD parse_error_reason text;
ALTER TABLE results ADD document__id integer;
