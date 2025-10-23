
USE um_db_bmi
GO

-- Hapus tabel jika ada
IF EXISTS (SELECT * FROM sysobjects WHERE name = 'MasterMenuKatalog' AND xtype = 'U')
    DROP TABLE MasterMenuKatalog
GO

CREATE TABLE MasterMenuKatalog (
    MenuID INT IDENTITY(1,1) PRIMARY KEY,
    Romawi INT NULL,
    SubRomawi INT NULL,
    NamaMenu NVARCHAR(100) NOT NULL,
    HeaderKategori NVARCHAR(100) NULL,
    SubKategori NVARCHAR(100) NULL
)
GO

-- ===========================
-- INSERT DATA MENU KATALOG
-- ===========================
 UPDATE MasterMenuKatalog SET NamaMenu ='PVC LAF' WHERE Romawi =1 AND SubRomawi =1
-- I
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu, HeaderKategori)
VALUES (1, 'PVC Lever Arch Files', 'PVC')
GO

INSERT INTO MasterMenuKatalog (Romawi,SubRomawi, NamaMenu, HeaderKategori,SubKategori)
VALUES (1,1,'PVC LAF', 'PVC','PVC LAF')
GO

-- II
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu, HeaderKategori)
VALUES (2, 'Paper Lever Arch Files', 'PAPER')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (2, 1, 'BINDEX ECOLOGIY', 'PAPER')
GO

INSERT INTO MasterMenuKatalog (Romawi,SubRomawi, NamaMenu, HeaderKategori)
VALUES (2,2, 'BENEX LABELA', 'PAPER')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (2,3, 'BENEX LAMI', 'PAPER')
GO


-- IV
-- INSERT INTO MasterMenuKatalog (Romawi, NamaMenu, HeaderKategori)
-- VALUES (4, 'Bestin PVC Lever Arch File 616, 626, 636', 'BOX FILES')
-- GO
-- INSERT INTO MasterMenuKatalog (Romawi,SubRomawi, NamaMenu, HeaderKategori)
-- VALUES (4,1,'Box File DIGITAL 6034,6033', 'BOX FILES')
-- GO

-- V
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu, HeaderKategori)
VALUES (5, 'Insert Ring Binders', 'RING BINDERS')
GO

-- VI
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu, HeaderKategori)
VALUES (6, 'D-Type Ring Binders', 'EXPANDING FILES')
GO

-- VII
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu, HeaderKategori)
VALUES (7, 'Pipe Binders', 'DOCUMENT WALLETS')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (7, 1, 'Insert Pipe Binders', 'DOCUMENT WALLETS')
GO

-- VIII
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu, HeaderKategori)
VALUES (8, 'Magazine Files (Box Files) Bambi', 'BOX FILES')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (8, 1, 'Magazine File Bindex, Benex', 'BOX FILES')
GO

-- IX
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu, HeaderKategori)
VALUES (9, 'Name Card Holders', 'BOX FILES')
GO

-- X
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu, HeaderKategori)
VALUES (10, 'Clipfiles & Clipboards', 'PRESENTATION FOLDERS')
GO


-- XI
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu, HeaderKategori)
VALUES (11, 'Zipper Pockets', 'ZIPPER')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (11, 1, 'BAMBI', 'ZIPPER')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (11, 2, 'BENDEX, BENEX', 'ZIPPER')
GO

-- XII
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu)
VALUES (12, 'PP Document Keepers')
GO

-- XIII
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu)
VALUES (13, 'PP Insert Document Holders')
GO

-- XIV
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu)
VALUES (14, 'Ring Binder Document Holders')
GO

-- XV
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu)
VALUES (15, 'PP Business Files & PP Clear Holders')
GO

-- XVI
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu)
VALUES (16, 'PP Pockets / Sheet Protectors')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu)
VALUES (16, 1, 'BAMBI')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu)
VALUES (16, 2, 'BENDEX, BENEX')
GO

-- XVII
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu)
VALUES (17, 'PP Zipper Bags')
GO

-- XVIII
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu)
VALUES (18, 'PP Dividers & Indexes')
GO
INSERT INTO MasterMenuKatalog (Romawi,SubRomawi,NamaMenu)
VALUES (18,1, 'BAMBI')
GO
INSERT INTO MasterMenuKatalog (Romawi,SubRomawi,NamaMenu)
VALUES (18,2, 'BAMBI,BENEX')
GO

-- XIX
-- INSERT INTO MasterMenuKatalog (Romawi, NamaMenu)
-- VALUES (19, 'Display Book PP Pockets & Menu Holders')
-- GO

-- XX
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu)
VALUES (20, 'Binder Notes')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu)
VALUES (20, 1, 'STANDARD & PVC PRINTING')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu)
VALUES (20, 2, 'Reflex Printing')
GO

-- baru sampai sini

-- XXI
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu)
VALUES (21, 'Refill Binder Notes')
GO

-- XXII
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu)
VALUES (22, 'Zipper Wallets')
GO

-- XXIII
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu)
VALUES (23, 'Computer Files')
GO

-- XXIV
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu)
VALUES (24, 'Certificate Holders')
GO

-- XXV
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu, HeaderKategori)
VALUES (25, 'Series Gift & Promotions', 'GIFT')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (25, 1, 'PENCIL CASE & PENCIL BOXES', 'GIFT')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (25, 2, 'INNER CASES', 'GIFT')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (25, 3, 'ZIPPER / POUCH', 'GIFT')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (25, 4, 'CARD HOLDERS', 'GIFT')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (25, 5, 'FOLDERS, RESTO & CAFÉ', 'GIFT')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (25, 6, 'EXCLUSIVE BAGS', 'GIFT')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (25, 7, 'NOTE BOOKS', 'GIFT')
GO

-- XXVI
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu, HeaderKategori)
VALUES (26, 'New Product Office', 'OFFICE')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (26, 1, 'BINDER SERIES K-POP', 'OFFICE')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (26, 2, 'ENVELOPE SERIES K-POP', 'OFFICE')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (26, 3, 'L-FOLDER SERIES K-POP', 'OFFICE')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (26, 4, 'BINDER SERIES HOT R', 'OFFICE')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (26, 5, 'BINDER SERIES LIFE R1', 'OFFICE')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, SubKategori, HeaderKategori)
VALUES (26, 6, 'BINDER 15102P & DUs', '2121, 2132, 2011, R1', 'OFFICE')
GO

-- XXVII
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu, HeaderKategori)
VALUES (27, 'New Product Stationery', 'STATIONERY')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (27, 1, 'PENCIL CASE & PENCIL BOXES', 'STATIONERY')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (27, 2, 'DESK SET', 'STATIONERY')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (27, 3, 'STOP MAP BUFFALO BINDEX', 'STATIONERY')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (27, 4, 'COVER BINDING BUFFALO BINDEX', 'STATIONERY')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (27, 5, 'SECTION BOOK', 'STATIONERY')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (27, 6, 'PM RAPORT & BUKU PENGHUBUNG SISWA', 'STATIONERY')
GO

-- XXVIII
INSERT INTO MasterMenuKatalog (Romawi, NamaMenu, HeaderKategori)
VALUES (28, 'New Product Life & Style', 'LIFESTYLE')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (28, 1, 'BOOK', 'LIFESTYLE')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (28, 2, 'SERIE BAMBINA', 'LIFESTYLE')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (28, 3, 'PHOTO ALBUM & K-POP', 'LIFESTYLE')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (28, 4, 'BAG TRANSPARENT', 'LIFESTYLE')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (28, 5, 'GIFT BAG & GOODIE BAG', 'LIFESTYLE')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (28, 6, 'BAG ORGANIZER & WALLET ZIP', 'LIFESTYLE')
GO
INSERT INTO MasterMenuKatalog (Romawi, SubRomawi, NamaMenu, HeaderKategori)
VALUES (28, 7, 'TAS PINGGANG HP', 'LIFESTYLE')
GO

