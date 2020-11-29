USE H_info;


-- 1
DROP VIEW IF EXISTS update_info;
CREATE VIEW update_info AS
SELECT	case_number,
		case_status, 
        agent_attorney_name, 
        agent_attorney_city,
        agent_attorney_state
FROM AgentInfo JOIN ApplicationInfo USING (case_number);



-- 2
-- Update case status: WITHDRAWN, CERTIFIED, DENIED, CERTIFIED-WITHDRAWN, INPROGRESS
DROP PROCEDURE IF EXISTS updateStatus;
DELIMITER //
CREATE PROCEDURE updateStatus(IN case_num CHAR(18), IN case_stat VARCHAR(20))
BEGIN
    
  UPDATE ApplicationInfo
  SET case_status = case_stat
  WHERE case_number = case_num;

  
  SELECT case_number,
		 case_status, 
         agent_attorney_name, 
         agent_attorney_city,
         agent_attorney_state
  FROM   update_info
  WHERE case_number = case_num;
END//

DELIMITER ;



-- 3
DROP PROCEDURE IF EXISTS updateAgent;
DELIMITER //

CREATE PROCEDURE updateAgent(IN case_num CHAR(18), IN a_name VARCHAR(20), IN city VARCHAR(20), IN state VARCHAR(10))
BEGIN
  
  
  UPDATE AgentInfo
  SET agent_attorney_name = a_name, agent_attorney_city = city, agent_attorney_state = state 
  WHERE case_number = case_num;

  SELECT case_number,
		 case_status, 
         agent_attorney_name, 
         agent_attorney_city,
         agent_attorney_state
  FROM   update_info
  WHERE case_number = case_num;

END//

DELIMITER ;




-- 4
DROP TRIGGER IF EXISTS safe_delete;
DELIMITER //
CREATE TRIGGER safe_delete BEFORE DELETE ON ApplicationInfo
						   FOR EACH ROW
BEGIN
        
	DELETE FROM WageInfo
	WHERE case_number = OLD.case_number;
    
    DELETE FROM WorksiteInfo
	WHERE case_number = OLD.case_number;
    
    DELETE FROM JobInfo
	WHERE case_number = OLD.case_number;
    
    DELETE FROM EmploymentTime
	WHERE case_number = OLD.case_number;
    
    DELETE FROM AgentInfo
	WHERE case_number = OLD.case_number;
 
END//

DELIMITER ;



-- 5
DROP PROCEDURE IF EXISTS deleteCase;
DELIMITER //
CREATE PROCEDURE deleteCase(IN case_num CHAR(18))
BEGIN
    
    DELETE FROM ApplicationInfo
	WHERE case_number = case_num;
    
    SELECT "Application was successfully deleted." as msg;
 
END//

DELIMITER ;




-- 6
DROP PROCEDURE IF EXISTS insertCase;
DELIMITER //
CREATE PROCEDURE insertCase(IN case_num CHAR(18), IN case_stat VARCHAR(20), IN case_sub DATE, IN case_deci DATE)
BEGIN
	DECLARE EXIT HANDLER FOR 1062 SELECT "Application was not added because of duplicate case number." as msg;
    
	INSERT INTO ApplicationInfo(case_number, case_status, case_submitted, decision_date, visa_class)
    VALUES (case_num, case_stat, case_sub, case_deci, 'H-1B');
    
    INSERT INTO AgentInfo(case_number)
    VALUES (case_num);
 
	SELECT "Application was successfully added." as msg;
END//

DELIMITER ;




