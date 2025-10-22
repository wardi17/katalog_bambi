use [um_db_bmi]
GO
DROP TABLE MasterWarna
CREATE TABLE MasterWarna (
    ID INT IDENTITY(1,1),
    KodeWarna NVARCHAR(10)  PRIMARY KEY NOT NULL ,   -- contoh: '01', '15', '02'
    NamaWarna NVARCHAR(50) NOT NULL,   -- contoh: 'BIRU', 'BIRU MEDIUM'
    HexCode NVARCHAR(10) NULL          -- kalau mau simpan warna dalam format HEX misal '#0000FF'
);

INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('01', 'BIRU', '#004C9E');
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('15', 'BIRU MEDIUM', '#0072CE')
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('02', 'BIRU MUDA', '#68B5F1');
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('10', 'HITAM', '#000000');
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('07', 'PUTIH', '#FFFFFF');
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('05', 'ABU', '#B3B3B3');
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('69', 'MERAH TUA', '#A41E34');
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('09', 'MERAH', '#E30613');
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('12', 'ORANYE', '#F28E00');
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('06', 'KUNING', '#FFD200')
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('04', 'HIJAU', '#009739');
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('14', 'HIJAU MEDIUM', '#5BBE47');
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('91', 'FLUORO MERAH MUDA', '#F6A6C1');
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('92', 'FLUORO ORANYE', '#FF8C00');
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('94', 'FLUORE HIJAU', '#A3D55D');
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('90', 'FLUORO UNGU', '#B17BA8');
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('20', 'UNGU PASTEL', '#C8B0E0');
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('18', 'BIRU PASTEL', '#A4C8E1');
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('19', 'PASTEL HIJAU', '#C6E5A1');
INSERT INTO MasterWarna (KodeWarna, NamaWarna, HexCode)
VALUES
('21', 'PASTEL MERAH MUDA', '#F6B7C1');
