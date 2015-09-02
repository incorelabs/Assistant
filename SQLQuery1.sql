CREATE TABLE IF NOT EXISTS `Table109` (
  `RegCode` int(9) NOT NULL,
  `RegName` varchar(40) NOT NULL,
  `RegEmail` varchar(60) NOT NULL,
  `RegPassword` varchar(80) NOT NULL,
  `RegMobile` varchar(15) NOT NULL,
  `FamilyCode` int(4) NOT NULL,
  `ParentFlag` tinyint(1) DEFAULT NULL,
  `ActiveFlag` tinyint(1) DEFAULT NULL,
  PRIMARY KEY ( `RegCode`, `FamilyCode` )
);

CREATE TABLE IF NOT EXISTS `Table120` (
  `RegCode` int(9) NOT NULL PRIMARY KEY,
  `ContactSerial` int(6) DEFAULT NULL,
  `InvestSerial` int(6) DEFAULT NULL,
  `AssetsSerial` int(6) DEFAULT NULL,
  `DocumentSerial` int(6) DEFAULT NULL,
  `ExpenseSerial` int(6) DEFAULT NULL,
  `IncomeSerial` int(6) DEFAULT NULL,
  `PasswordSerial` int(6) DEFAULT NULL,
  `Extra1Serial` int(6) DEFAULT NULL,
  `Extra2Serial` int(6) DEFAULT NULL,
  `Extra3Serial` int(6) DEFAULT NULL,
  `Extra4Serial` int(6) DEFAULT NULL,
  `Extra5Serial` int(6) DEFAULT NULL,
  `Extra6Serial` int(6) DEFAULT NULL,
  `Extra7Serial` int(6) DEFAULT NULL,
  `Extra8Serial` int(6) DEFAULT NULL,
  `Extra9Serial` int(6) DEFAULT NULL,
  PRIMARY KEY ( `RegCode` )
); 

CREATE TABLE IF NOT EXISTS `Table122` (
  `RegCode` int(9) NOT NULL PRIMARY KEY,
  `RegJoinDate` date NOT NULL,
  `RegCountryCode` int(4) NOT NULL,
  `RegRenewalNo` int(4) NOT NULL,
  `RegRenStDate` date NOT NULL,
  `RegRenEnDate` date NOT NULL,
  `RegFamilySize` int(2) DEFAULT NULL,
  `RegFeesCollect` decimal(14,2) DEFAULT NULL,
  `RegDataSizeUsed` decimal(14,2) DEFAULT NULL,
  `RegPhotoUploaded` int(4) DEFAULT NULL,
  `RegHitsNo` int(8) DEFAULT NULL,
  `LastLoginDateTime` datetime NOT NULL,
  PRIMARY KEY ( `RegCode` )
);

--- Gender
--- 0 => Open
--- 1 => Male
--- 2 => Female
--- 3 => Others

CREATE TABLE IF NOT EXISTS `Table107` (
  `RegCode` int(9) NOT NULL,
  `FamilyCode` int(4) NOT NULL,
  `FamilyName` varchar(40) NOT NULL,
  `RelationCode` int(4) NOT NULL,
  `BirthDate` date NOT NULL,
  `Email` varchar(60) NOT NULL,
  `Mobile` varchar(15) NOT NULL,
  `Gender` tinyint(1) NOT NULL,
  `LoginFlag` tinyint(1) DEFAULT NULL,
  `ActiveFlag` tinyint(1) DEFAULT NULL,
  PRIMARY KEY(RegCode,FamilyCode)
);

CREATE TABLE IF NOT EXISTS `Table105` (
  `RegCode` int(9) NOT NULL,
  `RenewalNo` int(4) NOT NULL,
  `RenStDate` date NOT NULL,
  `RenEnDate` date NOT NULL,
  PRIMARY KEY(RegCode,RenewalNo)
);

CREATE TABLE IF NOT EXISTS `Table103` (
  `RegCode` int(9) NOT NULL,
  `SerialNo` int(4) NOT NULL,
  `FeeCode` int(4) NOT NULL,
  `FeeDate` date NOT NULL,
  `FeeVoucherNo` varchar(15) NOT NULL,
  `FeeAmount` decimal(14,2) DEFAULT NULL,
  `ReceiptMode` tinyint(2) DEFAULT NULL,
  `ReceiptDetails` varchar(60) DEFAULT NULL,
  PRIMARY KEY(RegCode,SerialNo)
);

CREATE TABLE IF NOT EXISTS `Table101` (
  `FeeCode` int(4) NOT NULL,
  `FeeDescription` varchar(40) NOT NULL,
  `FeeAmount` decimal(14,2) NOT NULL,
  `FeeValidityDays` int(6) NOT NULL,
  `FeeHits` int(8) DEFAULT NULL,
  `FeeTotalAmount` decimal(14,2) DEFAULT NULL,
  PRIMARY KEY(FeeCode)
);

CREATE TABLE IF NOT EXISTS `Table102` (
  `RegCode` int(9) NOT NULL,
  `TranDate` date NOT NULL,
  `TranTime` time NOT NULL,
  `TranType` tinyint(2) NOT NULL,
  `TranFlag` tinyint(1) NOT NULL,
  `TranMessage` text DEFAULT NULL,
  `Confirmed` tinyint(1) NOT NULL,
  PRIMARY KEY(RegCode,TranDate,TranTime)
);

CREATE TABLE IF NOT EXISTS `Table104` (
  `TranType` tinyint(2) NOT NULL,
  `TranDescription` varchar(40) NOT NULL,
  `TranMessage` text DEFAULT NULL,
  `Confirmed` tinyint(1) NOT NULL,
  PRIMARY KEY(TranType)
);

CREATE TABLE IF NOT EXISTS `Table106` (
  `CountryCode` int(4) NOT NULL,
  `CountryName` varchar(40) NOT NULL,
  `CurrencyName` varchar(40) NOT NULL,
  `CurrencyCode` varchar(10) NOT NULL,
  PRIMARY KEY(CountryCode)
);

CREATE TABLE IF NOT EXISTS `Table108` (
  `StateCode` int(4) NOT NULL,
  `StateName` varchar(40) NOT NULL,
  `CountryCode` int(4) NOT NULL,
  `RegCode` int(9) NOT NULL,
  PRIMARY KEY(StateCode)
);

CREATE TABLE IF NOT EXISTS `Table110` (
  `CityCode` int(4) NOT NULL,
  `CityName` varchar(40) NOT NULL,
  `StateCode` int(4) NOT NULL,
  `CountryCode` int(4) NOT NULL,
  `RegCode` int(9) NOT NULL,
  PRIMARY KEY(CityCode)
);

--- Gender
--- 0 => Open
--- 1 => Male
--- 2 => Female
--- 3 => Others

CREATE TABLE IF NOT EXISTS `Table112` (
  `RelationCode` int(4) NOT NULL,
  `RelationName` varchar(40) NOT NULL,
  `Gender` tinyint(1) NOT NULL,
  `RegCode` int(9) NOT NULL,
  PRIMARY KEY(RelationCode)
);

CREATE TABLE IF NOT EXISTS `Table114` (
  `TitleCode` int(4) NOT NULL,
  `TitleName` varchar(40) NOT NULL,
  `Gender` tinyint(1) NOT NULL,
  `RegCode` int(9) NOT NULL,
  PRIMARY KEY(TitleCode)
);
