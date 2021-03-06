USE [ITD_LIVE]
GO
/****** Object:  StoredProcedure [dbo].[list_client_by_code]    Script Date: 10/31/2019 19:07:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- author:        <author,,name>
-- create date: <create date,,>
-- description:    <description,,>
-- =============================================
ALTER  procedure [dbo].[list_client_by_code]
    @client_code varchar(50)
as
begin
    -- set nocount on added to prevent extra result sets from
    -- interfering with select statements.
    select * 
	from itd_client
	where client_code like '%'+@client_code+'%' and client_enable=1 and client_progress_status=3
	order by client_code, client_name,bank_name,acc_name,acc_no
	
end
