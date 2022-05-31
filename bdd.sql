CREATE DATABASE IF NOT EXISTS tp;

#drop database tp;
use tp;




CREATE TABLE IF NOT EXISTS Categories (

IdCategory INT NOT NULL AUTO_INCREMENT,

NameCategory VARCHAR(30) NOT NULL,

CONSTRAINT `PK-IdCategory` PRIMARY KEY (IdCategory));




INSERT INTO `Categories` ( `NameCategory`) VALUES

('Rock'),

('Pop'),

('Metal'),

('Trap'),

('Rap'),

('Country');


#carga de datos de Tabla Categorias



select *
from Categories
;

#consulta de datos de Categorias




CREATE TABLE IF NOT EXISTS Events (

IdEvent INT NOT NULL auto_increment,

IdCategory INT NOT NULL,

NameEvent VARCHAR(30) NOT NULL,

CONSTRAINT `PK-Event` PRIMARY KEY (IdEvent),

CONSTRAINT `FK-IdCategory-E` FOREIGN KEY (IdCategory) references Categories(IdCategory));


UPDATE Events SET IdCategory = 6, NameEvent = 'league of legends' WHERE IdEvent = 3;



CREATE TABLE IF NOT EXISTS EventsLocations (

IdEventLocation INT NOT NULL AUTO_INCREMENT,

EventLocationDescription VARCHAR(30) NOT NULL,

EventLocationName VARCHAR(30) NOT NULL,

CONSTRAINT `PK-Idplace` PRIMARY KEY (IdEventLocation));




CREATE TABLE IF NOT EXISTS SeatTypes (

IdSeatType INT NOT NULL AUTO_INCREMENT,

SeatTypeName VARCHAR(30) NOT NULL,

CONSTRAINT `PK-IdSeatType` PRIMARY KEY (IdSeatType));

INSERT INTO `SeatTypes` ( `SeatTypeName`) VALUES

('Vip Field'),

('Field'),

('Stalls'),

('Laterals');






CREATE TABLE IF NOT EXISTS Artists (

IdArtist INT NOT NULL AUTO_INCREMENT,

NameArtist VARCHAR(30) NOT NULL,

DescriptionArtist VARCHAR(200) NOT NULL,

PhotoArtist VARCHAR(200) NOT NULL,

CONSTRAINT `PK-IdArtist` PRIMARY KEY (IdArtist));




CREATE TABLE IF NOT EXISTS Users (

IdUser INT NOT NULL AUTO_INCREMENT,

NameUser VARCHAR(30) NOT NULL,

EmailUser VARCHAR(30) NOT NULL,

RoleUser VARCHAR(30) NOT NULL,

PasswordUser VARCHAR(30) NOT NULL,

CONSTRAINT `PK-IdUser` PRIMARY KEY (IdUser));

insert into Users (NameUser, EmailUser, RoleUser, PasswordUser) values ('admin', 'admin@admin', 'admin', '123');




CREATE TABLE IF NOT EXISTS Purchases (

IdPurchase INT NOT NULL AUTO_INCREMENT,

IdUser INT NOT NULL,
DatePurchase datetime,

CONSTRAINT `PK-IdPurchases` PRIMARY KEY (IdPurchase),

CONSTRAINT `FK-IdUser-P` FOREIGN KEY (IdUser) references Users(IdUser));


select * from calendars where DateCalendar like '%17%' or IdEvent = 0;

CREATE TABLE IF NOT EXISTS Calendars (


IdCalendar INT NOT NULL auto_increment,

IdEvent INT NOT NULL,

IdEventLocation INT NOT NULL,

DateCalendar date,

CONSTRAINT `PK-IdCalendar` PRIMARY KEY (IdCalendar),

CONSTRAINT `FK-IdPlace-C` FOREIGN KEY (IdEventLocation) references EventsLocations(IdEventLocation),

CONSTRAINT `FK-IdEvent-C` FOREIGN KEY (IdEvent) references Events(IdEvent));

select * from calendars;

CREATE TABLE IF NOT EXISTS SeatEvents (

IdSeatEvent INT NOT NULL AUTO_INCREMENT,

IdCalendar INT NOT NULL,

TotalAvailables INT NOT NULL,

Price DOUBLE NOT NULL,

IdSeatType INT NOT NULL,

CONSTRAINT `PK-IdSeatEvent` PRIMARY KEY (IdSeatEvent),

CONSTRAINT `FK-IdSeatType-SE` FOREIGN KEY (IdSeatType) references SeatTypes(IdSeatType),
CONSTRAINT `FK-IdCalendar-SE` FOREIGN KEY (IdCalendar) references Calendars(IdCalendar));

select * from seatevents where idcalendar=3;


CREATE TABLE IF NOT EXISTS PurchaseLines (

IdPurchaseLine INT NOT NULL AUTO_INCREMENT,

IdPurchase INT NOT NULL,

IdSeatEvent INT NOT NULL,

QuantityPurchaseLine int NOT NULL,

PricePurchaseLine float NOT NULL,

CONSTRAINT `PK-IdPurchaseLine` PRIMARY KEY (IdPurchaseLine),

CONSTRAINT `FK-IdPurchase-PL` FOREIGN KEY (IdPurchase) references Purchases(IdPurchase),

CONSTRAINT `FK-IdSeatEvent-PL` FOREIGN KEY (IdSeatEvent) references SeatEvents(IdSeatEvent));


CREATE TABLE IF NOT EXISTS Tickets (

IdTicket INT NOT NULL AUTO_INCREMENT,

IdPurchaseLine INT NOT NULL,

NumberTicket int NOT NULL,

QrTicket char NOT NULL,

CONSTRAINT `PK-IdTicket` PRIMARY KEY (IdTicket),

CONSTRAINT `FK-IdPurchaseLine-T` FOREIGN KEY (IdPurchaseLine) references PurchaseLines(IdPurchaseLine));




CREATE TABLE IF NOT EXISTS CalendarXArtist(

IdCalendarXArtist INT NOT NULL auto_increment,

IdCalendar INT NOT NULL,

IdArtist INT NOT NULL,

CONSTRAINT `PK-IdCalendarXArtist` PRIMARY KEY (IdCalendarXArtist),

CONSTRAINT `FK-IdCalendar-CA` FOREIGN KEY (IdCalendar) references Calendars(IdCalendar),

CONSTRAINT `FK-IdArtist-CA` FOREIGN KEY (IdArtist) references Artists(IdArtist));

select * from calendarxartist;

SELECT IdArtist FROM CalendarXArtist WHERE IdCalendar = 3;