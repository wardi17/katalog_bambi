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
('01', 'BIRU', '#004C9E'),
('15', 'BIRU MEDIUM', '#0072CE'),
('02', 'BIRU MUDA', '#68B5F1'),
('10', 'HITAM', '#000000'),
('07', 'PUTIH', '#FFFFFF'),
('05', 'ABU', '#B3B3B3'),
('69', 'MERAH TUA', '#A41E34'),
('09', 'MERAH', '#E30613'),
('12', 'ORANYE', '#F28E00'),
('06', 'KUNING', '#FFD200'),
('04', 'HIJAU', '#009739'),
('14', 'HIJAU MEDIUM', '#5BBE47'),
('91', 'FLUORO MERAH MUDA', '#F6A6C1'),
('92', 'FLUORO ORANYE', '#FF8C00'),
('94', 'FLUORE HIJAU', '#A3D55D'),
('90', 'FLUORO UNGU', '#B17BA8'),
('20', 'UNGU PASTEL', '#C8B0E0'),
('18', 'BIRU PASTEL', '#A4C8E1'),
('19', 'PASTEL HIJAU', '#C6E5A1'),
('21', 'PASTEL MERAH MUDA', '#F6B7C1');
