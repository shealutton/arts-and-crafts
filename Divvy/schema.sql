drop table trips;
drop table stations;
CREATE TABLE stations(
  seq SERIAL PRIMARY KEY,
  name text UNIQUE NOT NULL,
  lat NUMERIC(8,6) NOT NULL,
  long NUMERIC(8,6) NOT NULL,
  capacity int NOT NULL
);

CREATE table trips(
  trip_id int PRIMARY KEY,
  starttime timestamp without time zone NOT NULL,
  stoptime timestamp without time zone NOT NULL,
  bike_id int NOT NULL,
  duration int NOT NULL,
  from_station_id int ,
  from_station_name text NOT NULL references stations(name),
  to_station_id int,
  to_station_name text NOT NULL references stations(name),
  usertype text NOT NULL,
  gender text,
  birthyear text
);

CREATE INDEX bike_id_indx ON trips (bike_id);
CREATE INDEX station_from_indx ON trips (from_station_id);
CREATE INDEX station_to_indx ON trips (to_station_id);

