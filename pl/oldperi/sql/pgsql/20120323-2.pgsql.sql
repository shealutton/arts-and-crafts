-- Create a table to capture all rows in each metrics table for users. 
-- rows will be updated by triggers on m_* tables
-- Index on users for speed may not be needed

DROP TABLE rowcount;
CREATE TABLE rowcount (
 user__id integer NOT NULL,
 table_name  text NOT NULL,
 total_rows  bigint,
 PRIMARY KEY (user__id,table_name)
);

CREATE INDEX rowcount_user_index ON rowcount(user__id);

