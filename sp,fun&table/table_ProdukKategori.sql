use [um_db_bmi]
GO
IF OBJECT_ID('dbo.ProdukKatalog', 'U') IS NOT NULL
    DROP TABLE dbo.ProdukKatalog;
GO

CREATE TABLE ProdukKatalog (
    ItemNO INT  IDENTITY(1,1) NOT NULL,
    NoExel INT NOT NULL,
    Partid char(10) PRIMARY KEY,
    HeaderKategori NVARCHAR(100)  NULL,
    SubKategori NVARCHAR(100) NULL,
    Jenis NVARCHAR(100) NOT NULL,
    Gambar NVARCHAR(255) NULL,  -- bisa simpan nama file atau URL gambar

    -- Bagian PRODUK SPESIFIKASI
    UkuranKarton NVARCHAR(100) NULL,
    RawMaterial NVARCHAR(100) NULL,
    Mekanik NVARCHAR(100) NULL,

    -- Kolom tambahan
    Ukuran NVARCHAR(100) NULL,
    Kapasitas NVARCHAR(100) NULL,
    Punggung NVARCHAR(100) NULL,
    LabelPunggung NVARCHAR(100) NULL,
    Fitur NVARCHAR(255) NULL,
    KodeWarna NVARCHAR(10),
    Video NVARCHAR(255) NULL,  -- bisa untuk URL/link video

    CreateUser VARCHAR(100),
    CreatedAt DATETIME DEFAULT GETDATE(),
    CONSTRAINT FK_MasterWarna FOREIGN KEY (KodeWarna) REFERENCES MasterWarna(KodeWarna)
);
