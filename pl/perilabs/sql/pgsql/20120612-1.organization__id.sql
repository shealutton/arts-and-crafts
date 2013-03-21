ALTER TABLE invitations ADD COLUMN organization__id bigint;
ALTER TABLE invitations DROP COLUMN experiment__id;
ALTER TABLE invitations ADD COLUMN experiment__id bigint;
