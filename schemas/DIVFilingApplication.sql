/*USE `Extranet`
;*/
/****** Object:  Table `DIVFilingApplicaton`    Script Date: 9/10/2015 8:44:37 AM ******/



CREATE TABLE `DIVFilingApplicaton`(
	`AIN` varchar(10) NOT NULL,
	`ApplicationXML` varchar(20000) NULL, 
	`DateTimeAdded` datetime NOT NULL,
	`DateTimeUpdated` datetime NULL,
	`ProcessDate` datetime NULL,
	`EmailNotify` tinyint DEFAULT 0 NOT NULL,
 CONSTRAINT `PK_DIVFilingApplicaton` PRIMARY KEY 
(
	`AIN` ASC
)
);
