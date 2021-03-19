
-- creating the database and related tables
CREATE DATABASE K_COVID19;
USE K_COVID19;

CREATE TABLE REGION(
region_code int,
province VARCHAR(50),
city VARCHAR(50),
latitude float,
longtitude float,
elementary_school_count int,
kindergarten_count int,
university_count int,
academy_ratio float,
elderly_population_ratio float,
elderly_alone_ratio float,
nursing_home_count int,
primary key(region_code)
);

CREATE TABLE CASEINFO(
case_id int,
province varchar(50),
city varchar(50),
infection_group tinyint(1),
infection_case varchar(50),
confirmed int,
latitude float,
longitude float,
PRIMARY KEY (case_id)
);

CREATE TABLE PATIENTINFO(
patient_id bigint,
sex varchar(10),
age varchar(10),
country varchar(50),
province varchar(50),
city varchar(50),
infection_case varchar(50),
infected_by bigint,
contact_number int,
symptom_onset_date date,
confirmed_date date,
released_date date,
deceased_date date,
state varchar(20),
PRIMARY KEY (patient_id)
);

CREATE TABLE WEATHER(
	region_code int,
    province varchar(50),
    wdate date,
    avg_temp float,
    min_temp float,
    max_temp float,
    PRIMARY KEY (region_code, wdate)
);
