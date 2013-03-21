ALTER TABLE users DROP COLUMN organization__id;
ALTER TABLE users DROP COLUMN plan;

ALTER TABLE organizations ADD COLUMN plan varchar(32);
UPDATE organizations SET plan = 'free';
ALTER TABLE organizations ALTER COLUMN plan SET NOT NULL;
ALTER TABLE organizations ALTER COLUMN plan SET DEFAULT 'free';
ALTER TABLE organizations ALTER COLUMN name TYPE varchar(256);

ALTER TABLE experiments ADD COLUMN organization__id bigint REFERENCES organizations (organization_id);

CREATE TABLE memberships (
 	membership_id serial PRIMARY KEY,
	user__id bigint REFERENCES users (id),
	organization__id bigint REFERENCES organizations (organization_id),
	level varchar(32) NOT NULL
);

