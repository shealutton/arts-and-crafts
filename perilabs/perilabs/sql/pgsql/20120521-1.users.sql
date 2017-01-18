CREATE SEQUENCE organization_id_seq;
CREATE SEQUENCE status_id_seq;
CREATE SEQUENCE user_id_seq;

CREATE TABLE organizations (
    organization_id bigint DEFAULT nextval('organization_id_seq'::regclass) NOT NULL,
    name integer NOT NULL
);

ALTER TABLE public.organizations OWNER TO peri;

CREATE TABLE statuses (
    status_id integer DEFAULT nextval('status_id_seq'::regclass) NOT NULL,
    title character varying(50) NOT NULL
);

ALTER TABLE public.statuses OWNER TO peri;

CREATE TABLE user_organization (
    user__id integer NOT NULL,
    organization__id integer NOT NULL
);

ALTER TABLE public.user_organization OWNER TO peri;

CREATE TABLE users (
    id bigint DEFAULT nextval('user_id_seq'::regclass) NOT NULL,
    username character varying(20) NOT NULL,
    email character varying(100) NOT NULL,
    password character varying(128) NOT NULL,
    "activationKey" character varying(128),
    createtime integer DEFAULT 0,
    lastvisit integer DEFAULT 0,
    lastaction integer DEFAULT 0,
    lastpasswordchange integer DEFAULT 0,
    status integer DEFAULT 0 NOT NULL,
    salt character varying(32) NOT NULL,
    firstname character varying(32),
    lastname character varying(32),
    role character varying(20)
);

ALTER TABLE public.users OWNER TO peri;

COPY organizations (organization_id, name) FROM stdin;
\.

COPY statuses (status_id, title) FROM stdin;
\.

COPY user_organization (user__id, organization__id) FROM stdin;
\.

COPY users (id, username, email, password, "activationKey", createtime, lastvisit, lastaction, lastpasswordchange, status, salt, firstname, lastname, role) FROM stdin;
4	admin	e-test@bk.ru	8fc1ea45d2671850bfca921d95147783		0	0	0	0	1	4e65e38d2c00b9.09115802	\N	\N	\N
\.

ALTER TABLE ONLY organizations
    ADD CONSTRAINT organizations_pkey PRIMARY KEY (organization_id);

ALTER TABLE ONLY statuses
    ADD CONSTRAINT statuses_pkey PRIMARY KEY (status_id);

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);

