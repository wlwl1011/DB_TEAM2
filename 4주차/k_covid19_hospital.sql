
USE K_COVID19;


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


-- patientinfo에 hospital_id attribute 추가 --

alter table patientinfo add hospital_id int;
