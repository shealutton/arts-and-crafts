UPDATE users SET role = 'user' WHERE role IS NULL; 
ALTER TABLE users ALTER COLUMN role SET NOT NULL;

