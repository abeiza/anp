-- Table: test1

-- DROP TABLE test1;

CREATE TABLE test1
(
  id_s integer NOT NULL DEFAULT nextval('test1_id_seq'::regclass),
  b2 character(1),
  a1 character(1),
  CONSTRAINT test1_pkey PRIMARY KEY (id_s)
)
WITH (OIDS=FALSE);
ALTER TABLE test1 OWNER TO postgres;



--
-- PostgreSQL database dump
--

-- Started on 2012-03-22 11:54:47

SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

--
-- TOC entry 1738 (class 0 OID 0)
-- Dependencies: 127
-- Name: test1_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('test1_id_seq', 8, true);


--
-- TOC entry 1735 (class 0 OID 16399)
-- Dependencies: 128
-- Data for Name: test1; Type: TABLE DATA; Schema: public; Owner: postgres
--

ALTER TABLE test1 DISABLE TRIGGER ALL;

INSERT INTO test1 (id_s, b2, a1) VALUES (4, 's', 'd');
INSERT INTO test1 (id_s, b2, a1) VALUES (6, 'f', 'f');
INSERT INTO test1 (id_s, b2, a1) VALUES (7, 'c', 'a');
INSERT INTO test1 (id_s, b2, a1) VALUES (5, 'f', 'f');
INSERT INTO test1 (id_s, b2, a1) VALUES (2, 's', 'd');
INSERT INTO test1 (id_s, b2, a1) VALUES (8, 'b', 'a');


ALTER TABLE test1 ENABLE TRIGGER ALL;

-- Completed on 2012-03-22 11:54:48

--
-- PostgreSQL database dump complete
--

