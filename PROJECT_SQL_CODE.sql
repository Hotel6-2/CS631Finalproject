CREATE TABLE EMPLOYEES (
SSN		CHAR(11) NOT NULL,
E_FName	VARCHAR(50),
E_MName	VARCHAR(50),
E_LName	VARCHAR(50),
Phone		VARCHAR(15),
Start_Date	DATE,
BRANCH_ID	INT,
PRIMARY KEY (SSN));

CREATE TABLE DEPENDENT (
ESSN	CHAR (11)		NOT NULL,
D_FName	VARCHAR(50) 	NOT NULL,
D_MName	VARCHAR(50),
D_LName	VARCHAR(50) 	NOT NULL,
PRIMARY KEY (ESSN, D_FName, D_LName),
FOREIGN KEY (ESSN) REFERENCES EMPLOYEES(SSN) 
ON DELETE CASCADE); 

CREATE TABLE BRANCH (
Branch_Name VARCHAR(50) NOT NULL,
Branch_ID INT PRIMARY KEY,
Assets DECIMAL(19,4),
B_MNG_SSN CHAR(11),
B_ASSIST_SSN CHAR(11),
FOREIGN KEY (B_MNG_SSN) REFERENCES EMPLOYEES(SSN) ON DELETE CASCADE,
FOREIGN KEY (B_ASSIST_SSN) REFERENCES EMPLOYEES(SSN) ON DELETE CASCADE );

CREATE TABLE BRANCH_LOCATION (
Branch_ID INT PRIMARY KEY,
B_Street VARCHAR(50),
B_City VARCHAR(50),
B_State VARCHAR(50),
B_Zip VARCHAR(50),
FOREIGN KEY (Branch_ID) REFERENCES BRANCH (Branch_ID) );

/**Employee Branch_ID Constraint added after branch is made**/
ALTER TABLE EMPLOYEES ADD CONSTRAINT FK_EMPLOYEES_BRANCH 
FOREIGN KEY (Branch_ID) REFERENCES BRANCH(BRANCH_ID)
ON DELETE SET NULL;

CREATE TABLE CUSTOMER (
CSSN			CHAR(11)		NOT NULL,
C_Fname			VARCHAR(50) 	NOT NULL,
C_MName		    VARCHAR(50),
C_LName			VARCHAR(50)	    NOT NULL,
C_Street		VARCHAR(50),
C_Apt			VARCHAR(10),
C_City			VARCHAR(50),
C_State			VARCHAR(50),
C_Zip		    CHAR(30),
C_Branch_ID		INT,
Per_Bkr_SSN	    CHAR(11),
PRIMARY KEY (CSSN),
FOREIGN KEY (C_Branch_ID) REFERENCES BRANCH (Branch_ID)
ON DELETE SET NULL,
FOREIGN KEY (Per_Bkr_SSN) REFERENCES EMPLOYEES (SSN)
ON DELETE SET NULL);

CREATE TABLE ACCOUNT (
Acc_Num		        INT	            NOT NULL,
Acc_Type         VARCHAR(30),
Acc_Bal		        DECIMAL(19,4)   NOT NULL,
Last_Access_Date	TIMESTAMP,         
PRIMARY KEY (Acc_Num));

CREATE TABLE SAVINGS (
Acc_Num		INT	NOT NULL,
Fix_Sav_Rate	DECIMAL(19,4),
PRIMARY KEY (Acc_Num), 
FOREIGN KEY (Acc_Num) REFERENCES ACCOUNT (Acc_Num)
ON DELETE CASCADE);

CREATE TABLE CHECKING (
Acc_Num		INT	NOT NULL,
Overdraft_Fee	DECIMAL(19,4),
PRIMARY KEY (Acc_Num), 
FOREIGN KEY (Acc_Num) REFERENCES ACCOUNT (Acc_Num)
ON DELETE CASCADE);

CREATE TABLE MONEY_MARKET (
Acc_Num		INT	NOT NULL,
Var_MM_Rate	DECIMAL(19,4),
PRIMARY KEY (Acc_Num), 
FOREIGN KEY (Acc_Num) REFERENCES ACCOUNT (Acc_Num)
ON DELETE CASCADE);

CREATE TABLE LOAN (
Acc_Num			    INT	NOT NULL,
Fix_Loan_Rate		DECIMAL(19,4),
Monthly_Loan_Payment	DECIMAL(19,4),
Loaned_Amount		DECIMAL(19,4), 
PRIMARY KEY (Acc_Num), 
FOREIGN KEY (Acc_Num) REFERENCES ACCOUNT (Acc_Num)
ON DELETE CASCADE);

/*updated to 3NF*/
CREATE TABLE TRANSACT (
Transact_Code VARCHAR(30) PRIMARY KEY,
Transact_Amount DECIMAL(19,4),
Transact_Date DATE,
Transact_Hour TIMESTAMP,
Transact_Fee DECIMAL(19,4),
Acc_Num INT,
FOREIGN KEY (Acc_Num) REFERENCES ACCOUNT (Acc_Num) 
ON DELETE CASCADE );

CREATE TABLE TRANSACT_TYPE (
Transact_Code VARCHAR(30) PRIMARY KEY,
Transact_Type VARCHAR(15),
FOREIGN KEY (Transact_Code) REFERENCES TRANSACT (Transact_code) 
ON DELETE CASCADE );

CREATE TABLE HELD_BY (
CSSN		CHAR(11)	NOT NULL,
Acc_Num	    INT,
PRIMARY KEY (CSSN, Acc_Num),
FOREIGN KEY (CSSN) REFERENCES CUSTOMER (CSSN)
ON DELETE CASCADE,
FOREIGN KEY (Acc_Num) REFERENCES ACCOUNT (Acc_Num)
ON DELETE CASCADE);

CREATE TABLE OCCURS (
Acc_Num 		INT NOT NULL,
Transact_Code	VARCHAR(30) NOT NULL,
PRIMARY KEY (Acc_Num, Transact_Code),
FOREIGN KEY (Acc_Num) REFERENCES ACCOUNT (Acc_Num) 
ON DELETE CASCADE,
FOREIGN KEY (Transact_Code) REFERENCES TRANSACT (Transact_Code) 
ON DELETE CASCADE);

CREATE TABLE ORIGINATES (
Branch_ID 	INT	    NOT NULL,
Acc_Num 	INT		NOT NULL,
PRIMARY KEY (Branch_ID, Acc_Num),
FOREIGN KEY (Branch_ID) REFERENCES BRANCH (Branch_ID)
ON DELETE CASCADE,
FOREIGN KEY (Acc_Num) REFERENCES ACCOUNT (Acc_Num)
ON DELETE CASCADE);

/** TABLE INSERTS **/

/* Employees table inserts */
INSERT INTO EMPLOYEES (SSN, E_FName, E_MName, E_LName, Phone, Start_Date, Branch_ID)
VALUES ('123-45-6789', 'John', 'A', 'Doe', '555-1234', str_to_date('02/02/1930','%m/%d/%Y'), NULL);
INSERT INTO EMPLOYEES (SSN, E_FName, E_MName, E_LName, Phone, Start_Date, Branch_ID)
VALUES ('987-65-4321', 'Jane', 'B', 'Smith', '555-5678', str_to_date('02/02/1931','%m/%d/%Y'), NULL);
INSERT INTO EMPLOYEES (SSN, E_FName, E_MName, E_LName, Phone, Start_Date, Branch_ID)
VALUES ('111-22-3333', 'Alice', 'C', 'Johnson', '555-8765', str_to_date('02/02/1932','%m/%d/%Y'), NULL);
INSERT INTO EMPLOYEES (SSN, E_FName, E_MName, E_LName, Phone, Start_Date, Branch_ID)
VALUES ('444-55-6666', 'Bob', 'D', 'Brown', '555-4321', str_to_date('02/02/1933','%m/%d/%Y'), NULL);
INSERT INTO EMPLOYEES (SSN, E_FName, E_MName, E_LName, Phone, Start_Date, Branch_ID)
VALUES ('777-88-9999', 'Charlie', 'E', 'Davis', '555-7890', str_to_date('02/02/1934','%m/%d/%Y'), NULL);

SELECT * FROM EMPLOYEES;

/* Dependents table inserts */
INSERT INTO DEPENDENT (ESSN , D_FNAME, D_MNAME, D_LNAME)
VALUES('123-45-6789', 'Tommy', 'L', 'Brown');
INSERT INTO DEPENDENT (ESSN , D_FNAME, D_MNAME, D_LNAME)
VALUES ('987-65-4321', 'Charles', 'P', 'Chaplin');
INSERT INTO DEPENDENT (ESSN , D_FNAME, D_MNAME, D_LNAME)
VALUES ('111-22-3333', 'Dwayne', 'D', 'Rock');
INSERT INTO DEPENDENT (ESSN , D_FNAME, D_MNAME, D_LNAME)
VALUES ('444-55-6666', 'Tanner', 'B', 'Fox');
INSERT INTO DEPENDENT (ESSN , D_FNAME, D_MNAME, D_LNAME)
VALUES ('777-88-9999', 'Nancy', 'E', 'Davis');

SELECT * FROM DEPENDENT;

/* Branch table inserts */
INSERT INTO BRANCH (Branch_Name, Branch_ID, Assets, B_MNG_SSN, B_ASSIST_SSN)
VALUES ('JC Branch', 1, 50000000.00, '123-45-6789', NULL);
INSERT INTO BRANCH (Branch_Name, Branch_ID, Assets, B_MNG_SSN, B_ASSIST_SSN)
VALUES ('LA Branch', 2, 80000000.00, '987-65-4321', NULL);
INSERT INTO BRANCH (Branch_Name, Branch_ID, Assets, B_MNG_SSN, B_ASSIST_SSN)
VALUES ('Manhattan Branch', 3, 100000000.00, '111-22-3333', NULL);
INSERT INTO BRANCH (Branch_Name, Branch_ID, Assets, B_MNG_SSN, B_ASSIST_SSN)
VALUES ('Newark Branch', 4, 45000000.00, '444-55-6666', NULL);
INSERT INTO BRANCH (Branch_Name, Branch_ID, Assets, B_MNG_SSN, B_ASSIST_SSN)
VALUES ('Union City Branch', 5, 30000000.00, '777-88-9999', NULL); 

SELECT * FROM BRANCH;

/* Branch_location table inserts AFTER 3NF NORMALIZATION */
INSERT INTO BRANCH_LOCATION (Branch_ID, B_Street, B_City, B_State, B_Zip)
VALUES (1, '42 Wallaby Way', 'Jersey City', 'New Jersey', '07305');
INSERT INTO BRANCH_LOCATION (Branch_ID, B_Street, B_City, B_State, B_Zip)
VALUES (2, '100 Steinway Avenue', 'Los Angeles', 'California', '90210');
INSERT INTO BRANCH_LOCATION (Branch_ID, B_Street, B_City, B_State, B_Zip)
VALUES (3, '285 Fulton Street', 'New York City', 'New York', '10001');
INSERT INTO BRANCH_LOCATION (Branch_ID, B_Street, B_City, B_State, B_Zip)
VALUES (4, '34  Liberty Place', 'Newark', 'New Jersey', '07101');
INSERT INTO BRANCH_LOCATION (Branch_ID, B_Street, B_City, B_State, B_Zip)
VALUES (5, '42 Palisade Way', 'Union City', 'New Jersey', '07087'); 

SELECT * FROM BRANCH_LOCATION;

/*UPDATE EMPLOYEE NULL BRANCH_ID*/
UPDATE Employees
SET BRANCH_ID = 1
WHERE SSN = '123-45-6789';

UPDATE Employees
SET BRANCH_ID = 2
WHERE SSN = '987-65-4321';

UPDATE Employees
SET BRANCH_ID = 3
WHERE SSN = '111-22-3333';

UPDATE Employees
SET BRANCH_ID = 4
WHERE SSN = '444-55-6666';

UPDATE Employees
SET BRANCH_ID = 5
WHERE SSN = '777-88-9999';

SELECT * FROM EMPLOYEES;

/* customer table inserts */
/*patrick's branch is 1 and his personal banker is John*/
INSERT INTO CUSTOMER (CSSN, C_Fname, C_Mname, C_Lname, C_Street, C_Apt, C_City, C_State, C_Zip, C_Branch_ID, Per_Bkr_SSN)
VALUES ('555-24-9994', 'Patrick', 'L', 'Finn', '132 Main st', 'Apt4', 'Newark', 'New Jersey', '07033', 1, '123-45-6789');
/*Dwayne's branch is 2 and his personal banker is Jane*/
INSERT INTO CUSTOMER (CSSN, C_Fname, C_Mname, C_Lname, C_Street, C_Apt, C_City, C_State, C_Zip, C_Branch_ID, Per_Bkr_SSN)
VALUES ('534-20-0004', 'Dwayne', 'D', 'Johnson', '12 Hollywood Blvd', NULL, 'Los Angeles', 'California', '90028', 2, '987-65-4321');
/*Mark's branch is 3 and his personal banker is Alice*/
INSERT INTO CUSTOMER (CSSN, C_Fname, C_Mname, C_Lname, C_Street, C_Apt, C_City, C_State, C_Zip, C_Branch_ID, Per_Bkr_SSN)
VALUES ('334-67-1224', 'Mark', 'S', 'Cain', '54 Elm st', 'Apt24', 'Jersey City', 'New Jersey', '07303', 3, '111-22-3333');
/*Heather's branch is 4 and her personal banker is Bob*/
INSERT INTO CUSTOMER (CSSN, C_Fname, C_Mname, C_Lname, C_Street, C_Apt, C_City, C_State, C_Zip, C_Branch_ID, Per_Bkr_SSN)
VALUES ('399-12-1111', 'Heather', 'Margret', 'Pierce', '66 E 12 st', 'Apt2', 'New York', 'New York', '10002', 4, '444-55-6666');
/*Mary's branch is 5 and her personal banker is Charlie*/
INSERT INTO CUSTOMER (CSSN, C_Fname, C_Mname, C_Lname, C_Street, C_Apt, C_City, C_State, C_Zip, C_Branch_ID, Per_Bkr_SSN)
VALUES ('456-09-4354', 'Mary', 'Taylor', 'Lewis', '302 park St', '501', 'New York', 'New York', '10011', 5, '777-88-9999');

SELECT * FROM CUSTOMER;

/* Account table inserts */
/* Need to insert 20 rows because each account must reference their respective disjoint specialization (4 account types X 5 customers) */ 
/*ADDING ACCOUNT TYPE -- for clarity*/
/*savings*/
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(101, 'Savings', 154323.00, CURRENT_TIMESTAMP);
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(102, 'Savings', 100000.00, CURRENT_TIMESTAMP);
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(103, 'Savings', 123.00, CURRENT_TIMESTAMP);
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(104, 'Savings', 1000.00, CURRENT_TIMESTAMP);
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(105, 'Savings', 11001.00, CURRENT_TIMESTAMP);
/*checking*/
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(201, 'Checking', 5000.00, CURRENT_TIMESTAMP);
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(202, 'Checking',  34000.00, CURRENT_TIMESTAMP);
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(203, 'Checking',  50.00, CURRENT_TIMESTAMP);
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(204, 'Checking',  500.00, CURRENT_TIMESTAMP);
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(205, 'Checking',  23001.00, CURRENT_TIMESTAMP);
/*money market*/
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(301, 'Money Market', 5500.00, CURRENT_TIMESTAMP);
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(302, 'Money Market', 443000.00, CURRENT_TIMESTAMP);
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(303, 'Money Market', 50.00, CURRENT_TIMESTAMP);
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(304, 'Money Market', 300.00, CURRENT_TIMESTAMP);
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(305, 'Money Market', 43001.00, CURRENT_TIMESTAMP);
/*loan*/
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(401, 'Loan', 5300.00, CURRENT_TIMESTAMP);
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(402, 'Loan', 44300.23, CURRENT_TIMESTAMP);
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(403, 'Loan', 803.58, CURRENT_TIMESTAMP);
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(404, 'Loan', 30000.01, CURRENT_TIMESTAMP);
INSERT INTO ACCOUNT (Acc_Num , Acc_Type, Acc_Bal, Last_Access_Date)
VALUES(405, 'Loan', 43001.93, CURRENT_TIMESTAMP);

SELECT * FROM ACCOUNT;
 
/* Savings table inserts – prefix 1 */
INSERT INTO SAVINGS (Acc_Num , Fix_Sav_Rate)
VALUES(101, 4.12);
INSERT INTO SAVINGS (Acc_Num, Fix_Sav_Rate)
VALUES(102, 5.60);
INSERT INTO SAVINGS (Acc_Num, Fix_Sav_Rate)
VALUES(103, 4.50);
INSERT INTO SAVINGS (Acc_Num , Fix_Sav_Rate)
VALUES(104, 4.45);
INSERT INTO SAVINGS (Acc_Num , Fix_Sav_Rate)
VALUES(105, 4.12);

SELECT * FROM SAVINGS;
 
/* Checking table inserts – prefix 2 */
INSERT INTO CHECKING (Acc_Num , Overdraft_Fee)
VALUES(201, 50.32);
INSERT INTO CHECKING (Acc_Num , Overdraft_Fee)
VALUES(202, 50.32);
INSERT INTO CHECKING (Acc_Num , Overdraft_Fee)
VALUES(203, NULL);
INSERT INTO CHECKING (Acc_Num , Overdraft_Fee)
VALUES(204, NULL);
INSERT INTO CHECKING (Acc_Num , Overdraft_Fee)
VALUES(205, NULL);

SELECT * FROM CHECKING;
 
/* Money Market table inserts – prefix 3 */
INSERT INTO MONEY_MARKET (Acc_Num , Var_MM_Rate)
VALUES(301, 5.32);
INSERT INTO MONEY_MARKET (Acc_Num , Var_MM_Rate)
VALUES(302, 5.01);
INSERT INTO MONEY_MARKET (Acc_Num , Var_MM_Rate)
VALUES(303, 3.30);
INSERT INTO MONEY_MARKET (Acc_Num , Var_MM_Rate)
VALUES(304, 4.89);
INSERT INTO MONEY_MARKET (Acc_Num , Var_MM_Rate)
VALUES(305, 3.32);

SELECT * FROM MONEY_MARKET;
 
/* Loan table inserts – prefix 4 */
INSERT INTO LOAN (Acc_Num , Fix_Loan_Rate, Monthly_Loan_Payment, Loaned_Amount)
VALUES(401, 15.321, 1290.16, 100100.00);
INSERT INTO LOAN (Acc_Num , Fix_Loan_Rate, Monthly_Loan_Payment, Loaned_Amount)
VALUES(402, 5.321, 551.89, 99000.00);
INSERT INTO LOAN (Acc_Num , Fix_Loan_Rate, Monthly_Loan_Payment, Loaned_Amount)
VALUES(403, 3.321, 267.86, 61000.00);
INSERT INTO LOAN (Acc_Num , Fix_Loan_Rate, Monthly_Loan_Payment, Loaned_Amount)
VALUES(404, 5.500, 375.78, 70000.00);
INSERT INTO LOAN (Acc_Num , Fix_Loan_Rate, Monthly_Loan_Payment, Loaned_Amount)
VALUES(405, 11.321, 185.47, 18990.00);

SELECT * FROM LOAN;

INSERT INTO TRANSACT (Transact_Code, Transact_Amount, Transact_Date, Transact_Hour, Transact_Fee, Acc_Num)
VALUES ('D1001', 500.00, str_to_date('02/02/1934','%m/%d/%Y'), TIMESTAMP('2022-05-08 14:30:45') , 0.00, 101);
INSERT INTO TRANSACT (Transact_Code, Transact_Amount, Transact_Date, Transact_Hour, Transact_Fee, Acc_Num)
VALUES ('W1002', 200.00, str_to_date('02/02/1935','%m/%d/%Y'), TIMESTAMP('2022-05-08 14:30:45'), 2.50, 102);
INSERT INTO TRANSACT (Transact_Code, Transact_Amount, Transact_Date, Transact_Hour, Transact_Fee, Acc_Num)
VALUES ('T1003', 150.00, str_to_date('02/02/1936','%m/%d/%Y'), TIMESTAMP('2022-05-08 14:30:45'), 1.00, 103);
INSERT INTO TRANSACT (Transact_Code, Transact_Amount, Transact_Date, Transact_Hour, Transact_Fee, Acc_Num)
VALUES ('D1004', 1000.00, str_to_date('02/02/1937','%m/%d/%Y'), TIMESTAMP('2022-05-08 14:30:45'), 0.00, 104);
INSERT INTO TRANSACT (Transact_Code, Transact_Amount, Transact_Date, Transact_Hour, Transact_Fee, Acc_Num)
VALUES ('P1005', 185.47, str_to_date('02/02/1938','%m/%d/%Y'), TIMESTAMP('2022-05-08 14:30:45'), 1.00, 405);

SELECT * FROM TRANSACT;

INSERT INTO TRANSACT_TYPE (Transact_Code, Transact_Type)
VALUES ('D1001', 'Deposit');
INSERT INTO TRANSACT_TYPE (Transact_Code, Transact_Type)
VALUES ('W1002', 'Withdrawal');
INSERT INTO TRANSACT_TYPE (Transact_Code, Transact_Type)
VALUES ('T1003', 'Transfer');
INSERT INTO TRANSACT_TYPE (Transact_Code, Transact_Type)
VALUES ('D1004', 'Deposit');
INSERT INTO TRANSACT_TYPE (Transact_Code, Transact_Type)
VALUES ('P1005', 'Payment');

SELECT * FROM TRANSACT_TYPE;

/* Next are the relationship tables */ 

/* Held By table inserts */
/* Prefix = account type, Suffix = Customer count */
/*CUST_1*/
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('555-24-9994', 101);
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('555-24-9994', 201);
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('555-24-9994', 301);
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('555-24-9994', 401);
 
/*CUST_2*/
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('534-20-0004', 102);
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('534-20-0004', 202);
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('534-20-0004', 302);
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('534-20-0004', 402);
 
/*CUST_3*/
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('334-67-1224', 103);
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('334-67-1224', 203);
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('334-67-1224', 303);
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('334-67-1224', 403);
 
/*CUST_4*/
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('399-12-1111', 104);
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('399-12-1111', 204);
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('399-12-1111', 304);
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('399-12-1111', 404);
 
/*CUST_5*/
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('456-09-4354', 105);
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('456-09-4354', 205);
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('456-09-4354', 305);
INSERT INTO HELD_BY (CSSN, Acc_Num)
VALUES('456-09-4354', 405);

SELECT * FROM HELD_BY;

/* Occurs table inserts */
INSERT INTO OCCURS (Transact_Code, Acc_Num)
VALUES('D1001', 101);
INSERT INTO OCCURS (Transact_Code, Acc_Num)
VALUES('W1002', 102);
INSERT INTO OCCURS (Transact_Code, Acc_Num)
VALUES('T1003', 103);
INSERT INTO OCCURS (Transact_Code, Acc_Num)
VALUES('D1004', 104);
INSERT INTO OCCURS (Transact_Code, Acc_Num)
VALUES('P1005', 405);

SELECT * FROM OCCURS;

/* Originates table inserts */
INSERT INTO ORIGINATES (BRANCH_ID, Acc_Num)
VALUES(1, 401);
INSERT INTO ORIGINATES (BRANCH_ID, Acc_Num)
VALUES(2, 402);
INSERT INTO ORIGINATES (BRANCH_ID, Acc_Num)
VALUES(3, 403);
INSERT INTO ORIGINATES (BRANCH_ID, Acc_Num)
VALUES(4, 404);
INSERT INTO ORIGINATES (BRANCH_ID, Acc_Num)
VALUES(5, 405);

SELECT * FROM ORIGINATES;


/* SELECT STATEMENTS TOTAL ALL TABLES */
(SELECT * FROM EMPLOYEES);
(SELECT * FROM DEPENDENT);
(SELECT * FROM BRANCH);
(SELECT * FROM CUSTOMER);
(SELECT * FROM ACCOUNT);
(SELECT * FROM MONEY_MARKET);
(SELECT * FROM SAVINGS);
(SELECT * FROM CHECKING);
(SELECT * FROM LOAN);
(SELECT * FROM TRANSACT);
(SELECT * FROM HELD_BY);
(SELECT * FROM OCCURS);
(SELECT * FROM ORIGINATES);

UPDATE Employees
SET Phone = '555-9999'
WHERE SSN = '123-45-6789';
(SELECT * FROM EMPLOYEES);

DELETE FROM Employees
WHERE SSN = '123-45-6789';
(SELECT * FROM EMPLOYEES);
/** Does not work error#1451 - Cannot delete or update a parent row: a foreign key constraint fails (`bankdb`.`branch_location`, CONSTRAINT `branch_location_ibfk_1` FOREIGN KEY (`Branch_ID`) REFERENCES `BRANCH` (`Branch_ID`))
**/
UPDATE DEPENDENT 
SET D_FNAME = 'Charlie'
WHERE ESSN = '987-65-4321';
(SELECT * FROM DEPENDENT);

DELETE FROM DEPENDENT
WHERE ESSN = '444-55-6666';
(SELECT * FROM DEPENDENT);


UPDATE BRANCH
SET Branch_Name = 'NB Branch', B_Street = '1 Palisade Way', B_City = 'North Bergen', B_State = 'New Jersey', B_Zip = '07108'
WHERE Branch_ID = '5';
(SELECT * FROM BRANCH);
/** does not work due to changes with Branch_Location **/

DELETE FROM BRANCH
WHERE Branch_ID = '5';
(SELECT * FROM BRANCH);
/** Does not work error#1451 - Cannot delete or update a parent row: a foreign key constraint fails (`bankdb`.`branch_location`, CONSTRAINT `branch_location_ibfk_1` FOREIGN KEY (`Branch_ID`) REFERENCES `BRANCH` (`Branch_ID`))
**/

UPDATE CUSTOMER
SET C_FNAME = 'Pat'
WHERE CSSN = '555-24-9994';
(SELECT * FROM CUSTOMER);

DELETE FROM CUSTOMER
WHERE CSSN = '456-09-4354';
(SELECT * FROM CUSTOMER);

UPDATE ACCOUNT
SET ACC_BAL = 15000.00
WHERE ACC_NUM = 101;
(SELECT * FROM ACCOUNT);

DELETE FROM ACCOUNT
WHERE ACC_NUM = 102;
(SELECT * FROM ACCOUNT);

UPDATE SAVINGS
SET FIX_SAV_RATE =  2.15
WHERE ACC_NUM = 101;
(SELECT * FROM SAVINGS);

DELETE FROM SAVINGS
WHERE ACC_NUM = 103;
(SELECT * FROM SAVINGS);

UPDATE CHECKING
SET OVERDRAFT_FEE = 100.64
WHERE ACC_NUM = 201;
(SELECT * FROM CHECKING);

DELETE FROM CHECKING
WHERE ACC_NUM = 203;
(SELECT * FROM CHECKING);

UPDATE MONEY_MARKET
SET VAR_MM_RATE = 10.77
WHERE ACC_NUM = 301;
(SELECT * FROM MONEY_MARKET);

DELETE FROM MONEY_MARKET
WHERE ACC_NUM = 304;
(SELECT * FROM MONEY_MARKET);

UPDATE LOAN
SET FIX_LOAN_RATE = 10.22
WHERE ACC_NUM = 401;
(SELECT * FROM LOAN);

DELETE FROM LOAN
WHERE ACC_NUM = 404;
(SELECT * FROM LOAN);

UPDATE TRANSACT
SET Transact_Amount = 550.00
WHERE Transact_Code = 'D1001';
(SELECT * FROM TRANSACT);

DELETE FROM TRANSACT
WHERE Transact_Code = 'D1001';
(SELECT * FROM TRANSACT);

SELECT Acc_Num, COUNT(Transact_Code) AS Transaction_Count 		
FROM OCCURS 
GROUP BY Acc_Num;

SELECT COUNT(*) AS NUM_ACCTS, H.CSSN, SUM(AC.ACC_BAL)
FROM HELD_BY H JOIN ACCOUNT AC ON (H.ACC_NUM = AC.ACC_NUM)
WHERE AC.ACC_BAL > 500
GROUP BY H.CSSN
HAVING COUNT(*) > 2;

SELECT Acc_Num, Fix_Loan_Rate
FROM LOAN
WHERE Fix_Loan_Rate <= ALL (
SELECT Fix_Loan_Rate 
 		FROM Loan);

SELECT D_FName AS "Dependent First Name", D_LName AS "Dependent Last Name"
FROM DEPENDENT
WHERE ESSN IN (SELECT SSN
            FROM EMPLOYEES
            WHERE D_FName = 'Nancy');
