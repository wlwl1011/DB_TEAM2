
USE K_COVID19;

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
