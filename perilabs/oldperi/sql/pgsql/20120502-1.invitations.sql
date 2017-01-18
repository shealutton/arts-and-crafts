CREATE TABLE invitations (
        invitation_id serial,
        user__id integer NOT NULL,
        email_address varchar NOT NULL,
        experiment__id integer NOT NULL,
        level varchar NOT NULL,
        token text NOT NULL,
        invited__id integer
);
