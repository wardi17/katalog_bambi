
use [um_db_bmi]
GO

CREATE TRIGGER trg_AfterInsert_ProdukKatalog
ON dbo.ProdukKatalog     -- ⬅️ Di sini tabelnya
AFTER INSERT
AS
BEGIN
    SET NOCOUNT ON;

    INSERT INTO dbo.MasterMenuKatalog (NamaMenu, HeaderKategori, SubKategori)
    SELECT DISTINCT 
        ISNULL(i.Jenis, 'Tanpa Nama') AS NamaMenu,
        i.HeaderKategori,
        i.SubKategori
    FROM inserted i
    WHERE NOT EXISTS (
        SELECT 1 
        FROM dbo.MasterMenuKatalog m
        WHERE 
            m.HeaderKategori = i.HeaderKategori
            AND ISNULL(m.SubKategori, '') = ISNULL(i.SubKategori, '')
    );
END;
GO
