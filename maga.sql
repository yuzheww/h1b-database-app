DROP DATABASE IF EXISTS H_info;
CREATE DATABASE H_info;
USE H_info;
DROP TABLE IF EXISTS big_table;
CREATE TABLE big_table(
	case_number CHAR(18),
    case_status VARCHAR(20),
    case_submitted DATE,
    decision_date DATE,
    visa_class VARCHAR(20),
    employment_start_date DATE,
    employment_end_date DATE,
    employer_name VARCHAR(30),
    employer_city VARCHAR(30),
    emp_state_abb VARCHAR(20),
    employer_postal_code INT,
    employer_country VARCHAR(30),
    employer_phone BIGINT,
    agent_attorney_name VARCHAR(20),
    agent_attorney_city VARCHAR(20),
    agent_attorney_state VARCHAR(10),
    job_title VARCHAR(30),
    soc_code VARCHAR(20),
    soc_name VARCHAR(20),
    full_time_position VARCHAR(5),
	prevailing_wage INT,
    pw_unit_of_pay VARCHAR(10),
	wage_unit_of_pay VARCHAR(10),
    worksite_city VARCHAR(20),
    worksite_county VARCHAR(20),
    worksite_state_abb VARCHAR(20),
    worksite_postal_code INT,
    h_year YEAR,
    naic_code INT,
	wage_rate_of_pay DECIMAL(32,2),
    total_wage DECIMAL(32,2),
    sector_data INT,
    emp_state_full VARCHAR(20),
    emp_state_and_city VARCHAR(30),
    worksite_state_full VARCHAR(30),
    worksite_state_and_city VARCHAR(30)
);
 SET @@SESSION.sql_mode='ALLOW_INVALID_DATES';
 LOAD DATA INFILE "H1b_EDA_data.csv"
		INTO TABLE big_table 
        FIELDS TERMINATED BY ','
		OPTIONALLY ENCLOSED BY '"'
		LINES TERMINATED BY '\n'
        (case_number, case_status,@var1, @var2
        ,visa_class,@var3,@var4,employer_name,
        employer_city,emp_state_abb,employer_postal_code,employer_country,employer_phone,
        agent_attorney_name,agent_attorney_city,agent_attorney_state,job_title,
        soc_code,soc_name, full_time_position,prevailing_wage,pw_unit_of_pay,
        wage_unit_of_pay,worksite_city,worksite_county,worksite_state_abb,
        worksite_postal_code,h_year,naic_code,wage_rate_of_pay,total_wage,sector_data,
        emp_state_full,emp_state_and_city,worksite_state_full,worksite_state_and_city)
        
        SET case_submitted = STR_TO_DATE(@var1,'%m/%d/%Y'),
		decision_date = STR_TO_DATE(@var2,'%m/%d/%Y'),
		employment_start_date = STR_TO_DATE(@var3,'%m/%d/%Y'),
		employment_end_date = STR_TO_DATE(@var4,'%m/%d/%Y');
        



DROP TABLE IF EXISTS EmploymentTime;
DROP TABLE IF EXISTS AgentInfo;
DROP TABLE IF EXISTS JobInfo;
DROP TABLE IF EXISTS WageInfo;
DROP TABLE IF EXISTS WorksiteInfo;
DROP TABLE IF EXISTS ApplicationInfo;
DROP TABLE IF EXISTS EmployerInfo;

CREATE TABLE IF NOT EXISTS EmployerInfo(
    employer_name VARCHAR(30),
    employer_city VARCHAR(30),
    emp_state_abb VARCHAR(5),
    emp_state_full VARCHAR(20),
    emp_state_and_city VARCHAR(30),
    employer_postal_code INT,
    employer_country VARCHAR(30),
    employer_phone BIGINT,
    naic_code INT,
    PRIMARY KEY(employer_name)
);

CREATE TABLE IF NOT EXISTS ApplicationInfo(
	case_number CHAR(18),
    case_status VARCHAR(20),
    case_submitted DATE,
    decision_date DATE,
    visa_class VARCHAR(20),
    employer_name VARCHAR(30),
    PRIMARY KEY(case_number),
    CONSTRAINT fk_em1 FOREIGN KEY (employer_name) REFERENCES EmployerInfo(employer_name) 
												  ON UPDATE CASCADE 
												  ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS EmploymentTime(
    case_number CHAR(18),
    employment_start_date DATE,
    employment_end_date DATE,
    h_year YEAR,
	PRIMARY KEY(case_number),
    CONSTRAINT fk_cn1 FOREIGN KEY (case_number) REFERENCES ApplicationInfo(case_number) 
												ON UPDATE CASCADE 
												ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS AgentInfo(
    case_number CHAR(18),
    agent_attorney_name VARCHAR(20),
    agent_attorney_city VARCHAR(20),
	agent_attorney_state VARCHAR(10),
    PRIMARY KEY(case_number),
    CONSTRAINT fk_cn2 FOREIGN KEY (case_number) REFERENCES ApplicationInfo(case_number) 
												ON UPDATE CASCADE 
												ON DELETE CASCADE
);


	-- CN
CREATE TABLE IF NOT EXISTS JobInfo(
    case_number CHAR(18),
	job_title VARCHAR(30),
	soc_code VARCHAR(20),
	soc_name VARCHAR(20),
	full_time_position VARCHAR(5),
    PRIMARY KEY(case_number),
    CONSTRAINT fk_cn3 FOREIGN KEY (case_number) REFERENCES ApplicationInfo(case_number) 
												ON UPDATE CASCADE 
												ON DELETE CASCADE
);


 CREATE TABLE IF NOT EXISTS WageInfo(
    case_number CHAR(18),
	prevailing_wage INT,
    pw_unit_of_pay VARCHAR(10),
	wage_unit_of_pay VARCHAR(10),
    wage_rate_of_pay DECIMAL(32,2),
    total_wage DECIMAL(32,2),
    sector_data INT,
    PRIMARY KEY(case_number),
    CONSTRAINT fk_cn4 FOREIGN KEY (case_number) REFERENCES ApplicationInfo(case_number) 
												ON UPDATE CASCADE 
												ON DELETE CASCADE
);

 CREATE TABLE IF NOT EXISTS WorksiteInfo(
    case_number CHAR(18),
    worksite_city VARCHAR(20),
    worksite_county VARCHAR(20),
    worksite_state_abb VARCHAR(5),
    worksite_postal_code INT,
    worksite_state_full VARCHAR(30),
    worksite_state_and_city VARCHAR(30),
    PRIMARY KEY(case_number),
    CONSTRAINT fk_cn5 FOREIGN KEY (case_number) REFERENCES ApplicationInfo(case_number) 
												ON UPDATE CASCADE 
												ON DELETE CASCADE
    
);

INSERT IGNORE INTO EmployerInfo
	   (SELECT DISTINCT employer_name,
               employer_city,
			   emp_state_abb,
			   emp_state_full,
			   emp_state_and_city,
			   employer_postal_code,
			   employer_country,
			   employer_phone,
			   naic_code
        FROM big_table);
        
INSERT IGNORE INTO ApplicationInfo
	   (SELECT case_number,
               case_status,
               case_submitted,
               decision_date,
               visa_class,
               employer_name
        FROM big_table);

INSERT IGNORE INTO EmploymentTime
	   (SELECT case_number,
			   employment_start_date,
			   employment_end_date,
			   h_year
        FROM big_table);
        
INSERT IGNORE INTO AgentInfo
	   (SELECT case_number,
			   agent_attorney_name,
			   agent_attorney_city,
			   agent_attorney_state
        FROM big_table);
        
INSERT  IGNORE INTO JobInfo
	   (SELECT case_number,
			   job_title,
			   soc_code,
			   soc_name,
			   full_time_position
        FROM big_table);
        
INSERT IGNORE INTO WageInfo
	   (SELECT case_number,
			   prevailing_wage,
    		   pw_unit_of_pay,
			   wage_unit_of_pay,
    		   wage_rate_of_pay,
    		   total_wage,
    		   sector_data
        FROM big_table);
        
INSERT IGNORE INTO WorksiteInfo
	   (SELECT case_number,
			   worksite_city,
    		   worksite_county,
    		   worksite_state_abb,
    		   worksite_postal_code,
    		   worksite_state_full,
    		   worksite_state_and_city
        FROM big_table);