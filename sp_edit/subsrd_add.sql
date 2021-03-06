USE [cs_jasa_giro]
GO
/****** Object:  StoredProcedure [dbo].[subsrd_add]    Script Date: 10/31/2019 09:54:27 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


ALTER procedure  [dbo].[subsrd_add]
	@client_code varchar(50)='',
	@subsrd_date datetime='1900-01-01',
	@sa_id int=0,
	@acc_src int=0,
	@acc_dst int=0,
	@subsrd_desc varchar(255)='',
	@subsrd_nominal decimal(20,2)=0,
	@user_id varchar(20)
as
begin
	set nocount on
	
	if exists(select subsrd_date from subsrd_balance where client_code=@client_code
			and subsrd_status=0 and subsrd_date=@subsrd_date)
	begin
		declare @acc_no_src varchar(50)
		declare @bank_src varchar(10)
		select top 1 @acc_no_src=acc_no, @bank_src=bank_code from subsrd_acc where acc_id=@acc_src
		declare @acc_no_dst varchar(50)
		declare @bank_dst varchar(10)
		select top 1 @acc_no_dst=acc_no, @bank_dst=bank_code from subsrd_acc where acc_id=@acc_dst

		insert into subsrd(subsrd_date, client_code, sa_id, acc_src, acc_no_src, bank_src, acc_dst, 
			acc_no_dst, bank_dst, subsrd_nominal, subsrd_desc, subsrd_kategori, modified_by, modified_dt)
		values (@subsrd_date, @client_code, @sa_id, @acc_src, @acc_no_src, @bank_src, @acc_dst, 
			@acc_no_dst, @bank_dst, @subsrd_nominal, @subsrd_desc, 'C002', @user_id,getdate())
		select 0 as err
	end
	else
	begin
		select 1 as err
	end
end	