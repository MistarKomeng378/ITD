USE [cs_jasa_giro]
GO
/****** Object:  StoredProcedure [dbo].[mutasi_list_client_by_code_MK]    Script Date: 10/31/2019 16:12:16 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
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
	SELECT * FROM v_merger_mutasi 
	WHERE client_code like '%'+@client_code+'%' AND client_enable=1
    
END

