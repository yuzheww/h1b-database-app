USE H_info;

DELIMITER ;

-- Update case status: WITHDRAWN, CERTIFIED, DENIED, CERTIFIED-WITHDRAWN, INPROGRESS
DROP PROCEDURE IF EXISTS updateStatus;
DELIMITER //
CREATE PROCEDURE updateStatus(IN case_num CHAR(18), IN case_stat VARCHAR(20))
BEGIN
	
  UPDATE ApplicationInfo
  SET case_status = case_stat
  WHERE case_number = case_num;

END//

DELIMITER ;

-- test
-- CALL updateStatus('I-200-09121-701936', 'CERTIFIED');

DROP PROCEDURE IF EXISTS updateAgent;
DELIMITER //

CREATE PROCEDURE updateAgent(IN case_num CHAR(18), IN a_name VARCHAR(20), IN city VARCHAR(20), IN state VARCHAR(10))
BEGIN

  UPDATE AgentInfo
  SET agent_attorney_name = a_name, agent_attorney_city = city, agent_attorney_state = state 
  WHERE case_number = case_num;

END//

DELIMITER ;


  

DROP PROCEDURE IF EXISTS deleteCase;
DELIMITER //
CREATE PROCEDURE deleteCase(IN case_num CHAR(18))
BEGIN
        
	DELETE FROM WageInfo
	WHERE case_number = case_num;
    
    DELETE FROM WorksiteInfo
	WHERE case_number = case_num;
    
    DELETE FROM JobInfo
	WHERE case_number = case_num;
    
    DELETE FROM EmploymentTime
	WHERE case_number = case_num;
    
    DELETE FROM AgentInfo
	WHERE case_number = case_num;
    
    DELETE FROM ApplicationInfo
	WHERE case_number = case_num;
 
END//

DELIMITER ;



DROP PROCEDURE IF EXISTS insertCase;
DELIMITER //
CREATE PROCEDURE insertCase(IN case_num CHAR(18), IN case_stat VARCHAR(20), IN case_sub DATE, IN case_deci DATE)
BEGIN
        
	INSERT INTO ApplicationInfo(case_number, case_status, case_submitted, decision_date, visa_class)
    VALUES (case_num, case_stat, case_sub, case_deci, 'H-1B');
 
END//

DELIMITER ;

