-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
ALTER PROCEDURE [dbo].[mutasi_list_client_by_code_MK]
	@client_code varchar(20)=''
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	
	--SET NOCOUNT ON;
	--SELECT * FROM v_list_client_code_MK
	--WHERE client_code like '%'+@client_code+'%' AND client_enable=1
	--ORDER BY subsrd_date DESC
	
	SET NOCOUNT ON;
-- 	SELECT * FROM v_merger_mutasi 
-- 	WHERE client_code like '%'+@client_code+'%' AND client_enable=1

		SELECT 
			dbo.v_all_data_mutasi.src_dt,
			dbo.v_all_data_mutasi.client_code,
			dbo.v_all_data_mutasi.subsrd_date,
			dbo.v_all_data_mutasi.subsrd_nominal,
			dbo.v_all_data_mutasi.deskripsi,
			dbo.v_all_data_mutasi.subsrd_kategori,
			dbo.v_all_data_mutasi.acc_no as acc_no,
			(SELECT acc_no FROM mutasi_client WHERE acc_no = dbo.v_all_data_mutasi.acc_no and client_code = dbo.v_all_data_mutasi.client_code ) as acc_no1,
			(SELECT client_name FROM mutasi_client WHERE acc_no = dbo.v_all_data_mutasi.acc_no and client_code = dbo.v_all_data_mutasi.client_code ) as client_name,
			(SELECT kena_jasgir FROM mutasi_client WHERE acc_no = dbo.v_all_data_mutasi.acc_no and client_code = dbo.v_all_data_mutasi.client_code ) as kena_jasgir,
			(SELECT client_enable FROM mutasi_client WHERE acc_no = dbo.v_all_data_mutasi.acc_no and client_code = dbo.v_all_data_mutasi.client_code ) as client_enable,
			(SELECT bank_name FROM mutasi_client WHERE acc_no = dbo.v_all_data_mutasi.acc_no and client_code = dbo.v_all_data_mutasi.client_code ) as bank_name,
			dbo.coa.coa_desc
		FROM
			dbo.v_all_data_mutasi
		INNER JOIN dbo.coa ON dbo.v_all_data_mutasi.subsrd_kategori = dbo.coa.coa_no 
		WHERE 
			client_code like '%'+@client_code+'%' AND 
			(SELECT client_enable FROM mutasi_client WHERE acc_no = dbo.v_all_data_mutasi.acc_no and client_code = dbo.v_all_data_mutasi.client_code ) = 1
		ORDER BY
			dbo.v_all_data_mutasi.subsrd_date DESC
    
END