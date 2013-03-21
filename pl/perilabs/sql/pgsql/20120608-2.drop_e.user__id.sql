UPDATE access_grants SET level = 'owner' WHERE level = 'administrator';
ALTER TABLE experiments DROP COLUMN user__id CASCADE;

