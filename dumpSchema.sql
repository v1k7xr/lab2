--
-- PostgreSQL database dump
--

-- Dumped from database version 10.12 (Ubuntu 10.12-0ubuntu0.18.04.1)
-- Dumped by pg_dump version 10.12 (Ubuntu 10.12-0ubuntu0.18.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: User; Type: TABLE; Schema: public; Owner: vbub
--

CREATE TABLE public."User" (
    userid integer NOT NULL,
    username character varying(125) NOT NULL,
    useremail character varying(75) NOT NULL,
    userpsswrd character varying(255) NOT NULL
);


ALTER TABLE public."User" OWNER TO vbub;

--
-- Name: User_userid_seq; Type: SEQUENCE; Schema: public; Owner: vbub
--

CREATE SEQUENCE public."User_userid_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."User_userid_seq" OWNER TO vbub;

--
-- Name: User_userid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: vbub
--

ALTER SEQUENCE public."User_userid_seq" OWNED BY public."User".userid;


--
-- Name: file; Type: TABLE; Schema: public; Owner: vbub
--

CREATE TABLE public.file (
    fileid integer NOT NULL,
    postid integer NOT NULL,
    filenameuser character varying(75) NOT NULL,
    filenamehashsum character varying(32) NOT NULL
);


ALTER TABLE public.file OWNER TO vbub;

--
-- Name: file_fileid_seq; Type: SEQUENCE; Schema: public; Owner: vbub
--

CREATE SEQUENCE public.file_fileid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.file_fileid_seq OWNER TO vbub;

--
-- Name: file_fileid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: vbub
--

ALTER SEQUENCE public.file_fileid_seq OWNED BY public.file.fileid;


--
-- Name: post; Type: TABLE; Schema: public; Owner: vbub
--

CREATE TABLE public.post (
    postid integer NOT NULL,
    userid integer NOT NULL,
    postadddate date NOT NULL,
    postdescription text,
    postname character varying(35)
);


ALTER TABLE public.post OWNER TO vbub;

--
-- Name: post_postid_seq; Type: SEQUENCE; Schema: public; Owner: vbub
--

CREATE SEQUENCE public.post_postid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.post_postid_seq OWNER TO vbub;

--
-- Name: post_postid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: vbub
--

ALTER SEQUENCE public.post_postid_seq OWNED BY public.post.postid;


--
-- Name: User userid; Type: DEFAULT; Schema: public; Owner: vbub
--

ALTER TABLE ONLY public."User" ALTER COLUMN userid SET DEFAULT nextval('public."User_userid_seq"'::regclass);


--
-- Name: file fileid; Type: DEFAULT; Schema: public; Owner: vbub
--

ALTER TABLE ONLY public.file ALTER COLUMN fileid SET DEFAULT nextval('public.file_fileid_seq'::regclass);


--
-- Name: post postid; Type: DEFAULT; Schema: public; Owner: vbub
--

ALTER TABLE ONLY public.post ALTER COLUMN postid SET DEFAULT nextval('public.post_postid_seq'::regclass);


--
-- Name: file pk_file; Type: CONSTRAINT; Schema: public; Owner: vbub
--

ALTER TABLE ONLY public.file
    ADD CONSTRAINT pk_file PRIMARY KEY (fileid);


--
-- Name: post pk_post; Type: CONSTRAINT; Schema: public; Owner: vbub
--

ALTER TABLE ONLY public.post
    ADD CONSTRAINT pk_post PRIMARY KEY (postid);


--
-- Name: User pk_user; Type: CONSTRAINT; Schema: public; Owner: vbub
--

ALTER TABLE ONLY public."User"
    ADD CONSTRAINT pk_user PRIMARY KEY (userid);


--
-- Name: contains_fk; Type: INDEX; Schema: public; Owner: vbub
--

CREATE INDEX contains_fk ON public.file USING btree (postid);


--
-- Name: create_fk; Type: INDEX; Schema: public; Owner: vbub
--

CREATE INDEX create_fk ON public.post USING btree (userid);


--
-- Name: file_pk; Type: INDEX; Schema: public; Owner: vbub
--

CREATE UNIQUE INDEX file_pk ON public.file USING btree (fileid);


--
-- Name: post_pk; Type: INDEX; Schema: public; Owner: vbub
--

CREATE UNIQUE INDEX post_pk ON public.post USING btree (postid);


--
-- Name: user_pk; Type: INDEX; Schema: public; Owner: vbub
--

CREATE UNIQUE INDEX user_pk ON public."User" USING btree (userid);


--
-- Name: file fk_file_contains_post; Type: FK CONSTRAINT; Schema: public; Owner: vbub
--

ALTER TABLE ONLY public.file
    ADD CONSTRAINT fk_file_contains_post FOREIGN KEY (postid) REFERENCES public.post(postid) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: post fk_post_create_user; Type: FK CONSTRAINT; Schema: public; Owner: vbub
--

ALTER TABLE ONLY public.post
    ADD CONSTRAINT fk_post_create_user FOREIGN KEY (userid) REFERENCES public."User"(userid) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

GRANT ALL ON SCHEMA public TO vbub;
GRANT ALL ON SCHEMA public TO webstorageuser;


--
-- Name: TABLE "User"; Type: ACL; Schema: public; Owner: vbub
--

GRANT SELECT,INSERT ON TABLE public."User" TO webstorageuser;


--
-- Name: SEQUENCE "User_userid_seq"; Type: ACL; Schema: public; Owner: vbub
--

GRANT SELECT,USAGE ON SEQUENCE public."User_userid_seq" TO webstorageuser;


--
-- Name: TABLE file; Type: ACL; Schema: public; Owner: vbub
--

GRANT ALL ON TABLE public.file TO webstorageuser;


--
-- Name: SEQUENCE file_fileid_seq; Type: ACL; Schema: public; Owner: vbub
--

GRANT SELECT,USAGE ON SEQUENCE public.file_fileid_seq TO webstorageuser;


--
-- Name: TABLE post; Type: ACL; Schema: public; Owner: vbub
--

GRANT ALL ON TABLE public.post TO webstorageuser;


--
-- Name: SEQUENCE post_postid_seq; Type: ACL; Schema: public; Owner: vbub
--

GRANT SELECT,USAGE ON SEQUENCE public.post_postid_seq TO webstorageuser;


--
-- PostgreSQL database dump complete
--

