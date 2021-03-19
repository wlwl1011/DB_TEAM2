
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

CREATE TABLE TIMEINFO (
	date date,
    test int,
    negative int,
    confirmed int,
    released int,
    deceased int,
    PRIMARY KEY (date)
);

CREATE TABLE TIMEPROVINCE (
	date date,
    province varchar(50),
    confirmed int,
    released int,
    deceased int,
    PRIMARY KEY (date, province)
);

CREATE TABLE TIMEAGE (
date date,
age varchar(5),
confirmed int,
deceased int,
PRIMARY KEY (date, age)
);

CREATE TABLE TIMEGENDER (
date date not null,
sex varchar(10) not null,
confirmed int(11),
deceased int(11),
PRIMARY KEY(date, sex)
);

CREATE TABLE Hospital (
Hospital_id int,
Province varchar(50),
city varchar(50),
latitude float,
longitude float,
capacity int,
now int,
PRIMARY KEY(hospital_id)
);


-- 자식 부모 (부모는 null값 있으면 안 됨) --

ALTER TABLE REGION ADD FOREIGN KEY (region_code) REFERENCES WEATHER (region_code) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE PATIENTINFO ADD FOREIGN KEY (province) REFERENCES REGION (province) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE WEATHER ADD FOREIGN KEY (wdate) REFERENCES PATIENTINFO (confirmed_date) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE PATIENTINFO ADD FOREIGN KEY (infection_case) REFERENCES CASEINFO (infection_case) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE PATIENTINFO ADD FOREIGN KEY (province) REFERENCES WEATHER (province) ON DELETE SET NULL ON UPDATE CASCADE;


-- patientinfo에 hospital_id attribute 추가 --

alter table patientinfo add hospital_id int;
