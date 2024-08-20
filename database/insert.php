<?php
require_once "../config/connection.php";
$q="INSERT INTO category(id,`name`) VALUES
(1,'torba'),
(2,'novcanik'),
(3,'naocare'),
(4,'sat'),
(5,'bizuterija'),
(6,'ostalo');
";
if($con->query($q)){
    echo "Insert uspesno izvrsen!";
}else{
    die("Neuspesno izvrsen upit".$con->error);
}
$q="INSERT INTO products (sif,`name`,price ,count ,`description`,category_id) values
('msat01','Q&Q M146J001Y',31 ,10 ,'Digitalni muški crni ručni sat',4),
('zsat01','Q&Q Q969J202Y ženski sat',21 ,10 ,'Analogni zenski sat sive boje',4),
('msat02','Q&Q QB64J202Y',34 ,10 ,'Muski analogni sat Q&Q veliki sa metalnom rukavicom',4),
('zsat02','Q&Q ženski sat QZ65J401Y',16 ,10 ,'Analogni zenski sat sa srebrno-zlatnim dizajnom',4),
('msat03','Q&Q superior s08a-004py,007py',55 ,10 ,'Crni muski analogni sat',4),
('zsat03','Q&Q Modni zenski CDVDFG123D',45 ,10 ,'Zenski roze gold analogni sat',4),
('msat04','Daniel Klein DK13432-3',32 ,10 ,'Teget sivi muski analogni sat',4),
('zsat04','Daniel Klein DK13370-6',15 ,10 ,'sivi zenski analogni sat sa nebo plavom unutrasnjosti',4),
('msat05','Daniel Klein DK13348-1',55 ,10 ,'Crno-sivi muski analogni sat',4),
('zsat05','DANIEL KLEIN DK13058-6 ',30 ,10 ,'Zenski analogni sat sa zlatno roze kaisem',4),
('torbica01','Pink Cosmo M146J001Y',40 ,10 ,null,1),
('torbica02','Pink Cosmo Q969J202Y',35 ,10 ,NULL,1),
('torbica03','Pink Cosmo QB64J202Y',60 ,10 ,NULL,1),
('torbica04','Pink cosmo QZ65J401Y',20 ,10 ,NULL,1),
('torbica05','Mohito DK13432',70 ,10 ,NULL,1),
('torbica06','Mohito DK13370',30 ,10 ,NULL,1),
('torbica07','Mohito DK13058',25 ,10 ,NULL,1),
('novcanik01','Fox QB64J202Y',20 ,10 ,NULL,2),
('novcanik02','Fox QZ65J401Y',20 ,10 ,NULL,2),
('novcanik03','Fox DK13432',40 ,10 ,NULL,2),
('novcanik04','Fox DK13370',10 ,10 ,NULL,2),
('novcanik05','Fox DK13058',15 ,10 ,NULL,2),
('naocare01','Optika kuburic QB64J202Y',20 ,10 ,NULL,3),
('naocare02','Optika kuburic QZ65J401Y',20 ,10 ,NULL,3),
('naocare03','Optika kuburic DK13432',40 ,10 ,NULL,3),
('naocare04','Optika kuburic DK13370',10 ,10 ,NULL,3),
('naocare05','Optika kuburic DK13058',15 ,10 ,NULL,3),
('bizuterija01','Lewiko QB64J202Y',20 ,10 ,'Narkukvica od nerdjajuceg celika',5),
('bizuterija02','Lewiko QZ65J401Y',20 ,10 ,'Narkukvica od nerdjajuceg celika',5),
('bizuterija03','Lewiko DK13432',40 ,10 ,'Narkukvica od nerdjajuceg celika',5),
('bizuterija04','Lewiko DK13370',10 ,10 ,'Ogrlica od nerdjajuceg celika',5),
('bizuterija05','Lewiko DK13058',15 ,10 ,'Ogrlica od nerdjajuceg celika',5),
('bizuterija06','Lewiko DK13058-6',10 ,10 ,'Ogrlica od nerdjajuceg celika',5),
('bizuterija07','Lewiko PK13058-1',15 ,10 ,'Ogrlica od nerdjajuceg celika',5),
('bizuterija08','Lewiko LW01BJ2',10 ,10 ,'Prsten od nerdjajuceg celika',5),
('bizuterija09','Lewiko PK75J-2',15 ,10 ,'Prsten od nerdjajuceg celika',5),
('bizuterija10','Lewiko GMO123B-2',15 ,10 ,'Prsten od nerdjajuceg celika',5),
('ostalo01','Codello esarpa QB64J202Y',20 ,10 ,'Codello esarpa crvena',6),
('ostalo02','Codello esarpa QZ65J401Y',20 ,10 ,'Codello esarpa zuta',6),
('ostalo03','Bros Cherry DK13432',40 ,10 ,NULL,6),
('ostalo04','Bros Cherry DK13370',10 ,10 ,NULL,6),
('ostalo05','Rukavice Mohito DK13058',15 ,10 ,'Braon mohito kozne rukavice',6);
";
if($con->query($q)){
    echo "Insert uspesno izvrsen!";
}else{
    die("Neuspesno izvrsen upit".$con->error);
}
?>