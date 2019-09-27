
CREATE TABLE account_user(id int(11) NOT NULL auto_increment, password varchar(128) NOT NULL, last_login DATETIME(6) NULL, UserName varchar(8) NOT NULL unique, CardId varchar(12) NULL, Penalty int(11) NOT NULL, is_active tinyint(1) NOT NULL, is_admin tinyint(1) NOT NULL, primary key (id));

CREATE TABLE main_machine(id int(11) NOT NULL auto_increment, Place varchar(4) NOT NULL, Category int(11) NOT NULL, Number int(11) NOT NULL, primary key (id));

CREATE TABLE machine_book(id int(11) NOT NULL auto_increment, MachineId_id int(11) NOT NULL, FOREIGN KEY(MachineId_id) REFERENCES main_machine(id), UserId_id int(11) NOT NULL, FOREIGN KEY(UserId_id) REFERENCES account_user(id), ValidTime DATETIME(6) NOT NULL, EndTime DATETIME(6) NULL, primary key (id));
