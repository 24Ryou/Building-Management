CREATE TABLE IF NOT EXISTS `account` (
  `ac_username` bigint(11) NOT NULL,
  `ac_password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `ac_firstname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `ac_lastname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci DEFAULT NULL,
  `ac_codemelli` bigint(11) DEFAULT NULL,
  `ac_age` tinyint(4) DEFAULT NULL,
  `ac_gender` tinyint(4) DEFAULT NULL,
  `ac_access` tinyint(4) DEFAULT NULL,
  `ac_apartment` int(11) DEFAULT NULL,
  `ac_charge` bigint(20) DEFAULT NULL,
  `ac_rent` bigint(20) DEFAULT NULL,
  `ac_credit` bigint(20) DEFAULT NULL,
  `ac_debit` bigint(20) DEFAULT NULL,
  `ac_status` tinyint(4) DEFAULT NULL,
  `ac_createdate` date DEFAULT NULL,
  PRIMARY KEY (`ac_username`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `account` (`ac_status`,`ac_username`, `ac_password`, `ac_firstname`, `ac_lastname`, `ac_codemelli`, `ac_age`, `ac_gender`, `ac_access`, `ac_apartment`, `ac_charge`, `ac_rent`, `ac_credit`, `ac_debit`, `ac_createdate`) VALUES
	(1,9000000000,'$2y$10$PLv.Wj/bC/J9oydJVojXG.RDabI4jy1jvWZ0w5G21QXLLaKjh2uNO','سهیل','محمدی',9000000000,32,1,1,'0','0','0','0','0','1387-07-05'),
	(1,9076785405,'$2y$10$UP5z1NmnymrHtngPn26YKu83YCZS2Rv.ch42LCzIB8ffH5TdgW6SO','لیلا','عقیلی',1270227780,34,2,'0',19,700000,4000000,'0','0','1386-01-21'),
	(1,9158998017,'$2y$10$BwL7PqKNsnVqo1S3d9kbXeegbOVGhozpJsykO4SIwIrhDkCTpgWP2','فائزه','میرسپاسی',3611641376,61,2,'0',18,400000,6000000,'0','0','1379-11-30'),
	(1,9217788168,'$2y$10$IKDzemYrtwS5fwCCDpaRZOyz0.TnT5RJLzD9ohDyNTAQRtEnna13G','نازنین','ابوذر',1071085466,29,2,'0',4,500000,6000000,'0','0','1384-05-08'),
	(1,9233719241,'$2y$10$qZPJ5wNbuvCzKX98lqHFIuYtp4WWoAwT9xZd0qmx.yi9sFQ2QGzDG','ندا','فرمائیان',1553532186,50,2,'0',6,200000,6000000,'0','0','1394-04-27'),
	(1,9337752008,'$2y$10$2xvIsEPtaYahPtHEWivRueSYdWsfV16tk2Cr4uvd6IG34tVV5M9tq','طاها','دهقان',6239280105,34,1,'0',1,700000,4000000,'0','0','1393-10-09'),
	(1,9389034193,'$2y$10$Tx1EHRUgJHVGKhQv2u7ejO0IpkEwxV.GRmfvLJdNZCQETs6S2llGm','محیا','نهاوندی ',1020205087,25,2,'0',3,800000,6000000,'0','0','1381-08-07'),
	(1,9496228610,'$2y$10$0t96EdlEyiPxi7z6UVjjb.6Zvb.V5x5Npu4.TOjgCtCM8Ys9FSAF2','امیر','حیاتی',2320495757,40,1,'0',20,800000,6000000,'0','0','1386-07-16'),
	(1,9548288299,'$2y$10$JdQzax5vixYWaBWy6mg6JOcYH3EMXibcH2JrJTeXN7KzEMl5DytaG','پرهام','توسلی',8184069100,38,1,'0',10,800000,2000000,'0','0','1384-10-11'),
	(1,9640569114,'$2y$10$qa3mznSrApcZgrYXix9K5O1OnWWKTHb6545pPfe1h.tzpOGDV5HyO','فاطمه زهرا','اشتری',4483720890,23,2,'0',15,100000,6000000,'0','0','1385-11-19'),
	(1,9663938765,'$2y$10$kXF0QqRvIMEOhWiul/hmzeym8dJu1YxMufQZb1mTtlD4JVmgDgbIG','مهسا','قمیشی ',3707242323,52,2,'0',13,400000,4000000,'0','0','1399-12-12'),
	(1,9712049433,'$2y$10$DaxHstAgCfgskWUMbDHhEeqQYrL1pwhYrw4v5RRVz5fyvJ6DXvVJi','مهدی','نواب',1805778851,30,1,'0',14,500000,2000000,'0','0','1382-08-22'),
	(1,9787351988,'$2y$10$cJ8pLoxZ6cAtdCUOp0i2wunG852iIUF.BrbUyNslIW3phw5.QYBfa','حسین','تابش',8847185412,45,1,'0',16,300000,4000000,'0','0','1383-05-12'),
	(1,9805222828,'$2y$10$sSR9ClJXCZIFMvy.vCS6oORL0tj5SXWRY5dpzsYHpPPv7Z7jsaZ.C','نازنین زهرا','انوشه',5089524478,32,2,'0',7,500000,6000000,'0','0','1379-09-21'),
	(1,9827495636,'$2y$10$VLFAOzvHf5W8ff8XRhkOpetLgHlI67ElQ3WJpQ2siybjztk3DdQV.','مهشید','هامون',5867984069,66,2,'0',9,900000,6000000,'0','0','1384-04-10'),
	(1,9875646285,'$2y$10$zUdDWSgcmT4IZ57i53vELe/TA7XhviriPqGWXsTznY0RCuG/dkTse','مهلا','امیری',9233366900,25,2,'0',2,300000,2000000,'0','0','1399-10-14'),
	(1,9877810333,'$2y$10$QpPre4prHD3TXsduzCLk3ulEAV4K7EIBvXZb6IKs3LdghzGtUp5CS','بیتا','یثربی',4852602862,20,2,'0',11,800000,6000000,'0','0','1384-04-04'),
	(1,9886607218,'$2y$10$VpqvJ.ykAOw.YxP3.WgDUenVlpCHV8djyA4qxCtzWdfAdK/BWew7i','جواد','فهمیده',8390985367,57,1,'0',8,300000,4000000,'0','0','1387-01-30'),
	(1,9911873641,'$2y$10$36hmFkAtVLWarHNPI5mvW.ZMGytxgnPG3XNDnoPvxhS83k3XaTViK','غزل','فتاحی',2629345726,34,2,'0',12,400000,4000000,'0','0','1396-06-17'),
	(1,9912967033,'$2y$10$fyZ12blg87nqp3efwt0JBe2W/BNbqCU/YbrRGEEixrCB5kbQf.UJW','الهام','جمادی',7469318311,65,2,'0',5,500000,2000000,'0','0','1399-09-18'),
	(1,9920392530,'$2y$10$xGYXjYbTDdKu5wTa1.AGCe0XUDUV/GFtobL5IuGGghcKZW3ZIqx2i','رضا','ثابتی',4556431433,69,1,'0',17,600000,2000000,'0','0','1400-08-01');

-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `apartment` (
  `ap_number` int(11) NOT NULL,
  `ap_waterid` varchar(20) DEFAULT NULL,
  `ap_powerid` varchar(20) DEFAULT NULL,
  `ap_gasid` varchar(20) DEFAULT NULL,
  `ap_parkingid` varchar(10) DEFAULT NULL,
  `ap_people` tinyint(4) DEFAULT NULL,
  `ap_info` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci DEFAULT NULL,
  PRIMARY KEY (`ap_number`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `apartment` (`ap_number`, `ap_waterid`, `ap_powerid`, `ap_gasid`, `ap_parkingid`, `ap_people`, `ap_info`) VALUES
	(0,'0','0','0','0','0','0'),
	(1,'2115419206149856','9826688741675022','3334506721318116','18',1,'Fugiat aute enim laboris cillu'),
	(2,'3617124243940646','5223200317007497','2831346137529818','6',4,'Fugiat aute enim laboris cillu'),
	(3,'9315692125577466','6820375883684000','9934095455546233','9',5,'Fugiat aute enim laboris cillu'),
	(4,'6617480095037022','1928213270496964','9633820205373605','14',1,'Aute aliquip tempor enim anim '),
	(5,'1412505994031570','8623167433861569','0732518789594526','8',4,'Aute aliquip tempor enim anim '),
	(6,'5115159017883027','5120014605052912','1835504811059400','20',5,'Dolor velit adipisicing ut ven'),
	(7,'6215941112734140','4721430062144764','8538255851377787','3',3,'Aute aliquip tempor enim anim '),
	(8,'7413657200700513','5622250776073865','3234230650002524','5',4,'Fugiat aute enim laboris cillu'),
	(9,'6316599121466627','0923821286736593','8339502387136256','10',4,'Sint quis reprehenderit proide'),
	(10,'5816032664254847','3725033407243535','5531864067030351','7',3,'Sint quis reprehenderit proide'),
	(11,'3016567029120493','6729198471908365','1237501632768963','13',5,'Minim mollit consectetur ex pa'),
	(13,'6116249343600386','4020884261814543','3439657340689883','16',4,'Minim sit ex aute mollit enim.'),
	(14,'6717253302992908','7425018563718095','0134346035719633','2',3,'Velit irure nisi deserunt ex c'),
	(15,'8317598312918964','5520613794696871','9531973264060994','17',3,'Fugiat aute enim laboris cillu'),
	(16,'3513826659614387','5228896137988398','8332220507167344','4',4,'Fugiat aute enim laboris cillu'),
	(17,'2415886994632212','2824762921229024','0539303783190039','19',2,'Fugiat aute enim laboris cillu'),
	(18,'5017149236812274','5221391361071818','0233981073532153','12',5,'Aute aliquip tempor enim anim '),
	(19,'1714937703801971','1024782034184577','8436056319309904','15',4,'Minim mollit consectetur ex pa'),
	(20,'4111773160581879','3429622522660382','5338319546823302','11',2,'Dolor velit adipisicing ut ven');
