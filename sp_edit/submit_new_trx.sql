USE [ITD_LIVE]
GO
/****** Object:  StoredProcedure [dbo].[submit_new_trx]    Script Date: 10/31/2019 19:00:03 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER  procedure [dbo].[submit_new_trx] 
	@trx_to	varchar(50)
	,@trx_remark1	varchar(100)
	,@trx_up	varchar(50)
	,@trx_telp	varchar(30)
	,@trx_fax	varchar(30)
	,@trx_date	datetime
	,@trx_client_id	int
	,@trx_client_code	varchar(20)
	,@trx_client_name	varchar(150)
	,@trx_acc_no	varchar(50)
	,@trx_acc_name	varchar(150)
	,@trx_bank_name	varchar(150)
	,@trx_type	tinyint
	,@trx_deposit_type	tinyint
	-- ,@trx_deposit_tenor	int
	,@trx_valuta_date	datetime
	,@trx_due_date	datetime
	,@trx_tax_status	tinyint
	,@trx_rate_payment	tinyint
	,@trx_nominal	money
	,@trx_rate	float
	,@trx_due_date_type	tinyint
	-- ,@trx_validation_key	varchar(8)
	-- ,@trx_create_dt	datetime
	,@trx_create_by	varchar(20)
	-- ,@trx_modified_dt	datetime
	-- ,@trx_progress_status	tinyint
	-- ,@trx_progress_by	varchar(20)
	,@trx_other	varchar(255)
	-- ,@trx_revise_note	varchar(255)
	,@trx_break_dt	datetime
	,@trx_curr	varchar(3)
	,@trx_id_master bigint
	,@trx_id_upper bigint
	,@follow_bil int = 0
	,@bank_acc_no varchar(20)=''
	,@bank_acc_name varchar(150)=''
	,@pic_id int=0
	,@trx_rate_break float=0
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
	if @trx_to<>'' and @trx_up<>'' and @trx_client_name<>'' and @trx_acc_name<>'' 
		and @trx_type<>'' and @trx_nominal<>0 and @trx_create_by<>''
	begin
		declare @trx_from	varchar(50)
		declare @trx_from_fax	varchar(50)
			
		select top 1 @trx_from=trx_from,@trx_from_fax=trx_fax from itd_param order by trx_param_created_dt desc
		
		-- declare @trx_ref_count	int
		-- declare @trx_ref_year int
		-- declare @trx_ref_month int
		-- declare @trx_ref_cur int
		
		-- declare @count_trx_ref int
		-- select @count_trx_ref=count(*) from itd_ref_count
		-- if @count_trx_ref>0
		-- begin
		-- 	select @trx_ref_count=ref_count,@trx_ref_year=ref_year,@trx_ref_month=ref_month from itd_ref_count 
		-- 	if @trx_ref_year=year(getdate()) and @trx_ref_month=month(getdate())
		-- 		set @trx_ref_cur= @trx_ref_count+1
		-- 	else
		-- 		set @trx_ref_cur= 1
		-- 	set @trx_ref_year=year(getdate()) 
		-- 	set @trx_ref_month=month(getdate())
		-- 	-- update itd_ref_count set ref_year=@trx_ref_year, ref_month= @trx_ref_month, ref_count=@trx_ref_cur
		-- end
		-- else
		-- begin	
		-- 	set @trx_ref_year=year(getdate()) 
		-- 	set @trx_ref_month=month(getdate())
		-- 	-- insert into itd_ref_count (ref_year,ref_month,ref_count) values
		-- 	-- 	(@trx_ref_year,@trx_ref_month,1)
		-- 	set @trx_ref_cur= 1
		-- end
		declare @month_rmw varchar(4)
		select @month_rmw=month_rmw from itd_month_rmw where month_no=month(getdate())
		declare @ref varchar(40)
		set @ref = 'XXX/CUSTODY/CIMBNIAGA/' + @month_rmw + '/' + cast(year(getdate()) as varchar(4))
		
		declare @trx_validation_key	varchar(2)		
		set @trx_validation_key	= dbo.get_key(@trx_deposit_type,@trx_valuta_date,@trx_due_date,@trx_nominal,@trx_type,@trx_acc_no)

		declare @trx_deposit_tenor	int
		declare @trx_deposit_tenor_hr	int
		declare @trx_deposit_tenor_bln	int
		set @trx_deposit_tenor_hr	 = datediff(day,@trx_valuta_date,@trx_due_date)
		set @trx_deposit_tenor_bln	 = datediff(month,@trx_valuta_date,@trx_due_date)
		if @trx_deposit_type=1
			set @trx_deposit_tenor	 = @trx_deposit_tenor_hr
		else
			set @trx_deposit_tenor	 = @trx_deposit_tenor_bln
		declare @bilyet_flag varchar(6)
		
		set @follow_bil =0
		if @follow_bil=1
			set @bilyet_flag='FOLLOW'
		else
			set @bilyet_flag='NONE'		
		
		
		select @trx_id_master= trx_id_master from itd_trx_approved where trx_id=@trx_id_upper
		if @trx_id_master is null or @trx_id_master=0
			set @trx_id_master=@trx_id_upper
		
		if @trx_type=4
		begin
			insert into itd_trx_unapproved (trx_to,trx_remark1,trx_up,trx_from,trx_from_fax,trx_telp,trx_fax,trx_ref,trx_date
				,trx_client_id,trx_client_code,trx_client_name,trx_acc_no,trx_acc_name,trx_bank_name,trx_type
				,trx_deposit_type,trx_deposit_tenor,trx_deposit_tenor_hr,trx_deposit_tenor_bln,trx_valuta_date
				,trx_due_date,trx_tax_status,trx_rate_payment,trx_nominal,trx_rate,trx_due_date_type
				,trx_validation_key,trx_create_dt,trx_create_by,trx_modified_dt,trx_progress_status,trx_progress_by
				,trx_other,trx_break_dt,trx_curr,trx_id_master,trx_id_upper,trx_bilyet_flag_no,bank_acc_no,bank_acc_name,pic_id,trx_rate_break)
			values(@trx_to,@trx_remark1,@trx_up,@trx_from,@trx_from_fax,@trx_telp,@trx_fax,@ref,@trx_date,@trx_client_id
					,@trx_client_code,@trx_client_name,@trx_acc_no,@trx_acc_name,@trx_bank_name,@trx_type
					,@trx_deposit_type,@trx_deposit_tenor,@trx_deposit_tenor_hr,@trx_deposit_tenor_bln
					,@trx_valuta_date,@trx_due_date,@trx_tax_status,@trx_rate_payment,@trx_nominal,@trx_rate
					,@trx_due_date_type,@trx_validation_key,getdate(),@trx_create_by,getdate()
					,1,@trx_create_by,@trx_other,@trx_break_dt,@trx_curr,@trx_id_master,@trx_id_upper,@bilyet_flag,@bank_acc_no,@bank_acc_name,@pic_id,@trx_rate_break)
		end
		
		-- edit MK		
		else if @trx_type=1
		begin
			insert into itd_trx_unapproved (trx_to,trx_remark1,trx_up,trx_from,trx_from_fax,trx_telp,trx_fax,trx_ref,trx_date
				,trx_client_id,trx_client_code,trx_client_name,trx_acc_no,trx_acc_name,trx_bank_name,trx_type
				,trx_deposit_type,trx_deposit_tenor,trx_deposit_tenor_hr,trx_deposit_tenor_bln,trx_valuta_date
				,trx_due_date,trx_tax_status,trx_rate_payment,trx_nominal,trx_rate,trx_due_date_type
				,trx_validation_key,trx_create_dt,trx_create_by,trx_modified_dt,trx_progress_status,trx_progress_by
				,trx_other,trx_break_dt,trx_curr,trx_id_master,trx_id_upper,trx_bilyet_flag_no,bank_acc_no,bank_acc_name
				,pic_id,trx_rate_break,itd_kategori)
			values(@trx_to,@trx_remark1,@trx_up,@trx_from,@trx_from_fax,@trx_telp,@trx_fax,@ref,@trx_date,@trx_client_id
					,@trx_client_code,@trx_client_name,@trx_acc_no,@trx_acc_name,@trx_bank_name,@trx_type
					,@trx_deposit_type,@trx_deposit_tenor,@trx_deposit_tenor_hr,@trx_deposit_tenor_bln
					,@trx_valuta_date,@trx_due_date,@trx_tax_status,@trx_rate_payment,@trx_nominal,@trx_rate
					,@trx_due_date_type,@trx_validation_key,getdate(),@trx_create_by,getdate()
					,1,@trx_create_by,@trx_other,@trx_break_dt,@trx_curr,@trx_id_master,@trx_id_upper,@bilyet_flag,@bank_acc_no,@bank_acc_name
					,@pic_id,@trx_rate_break,'D002')
		end
		
		else if @trx_type=3
		begin
			insert into itd_trx_unapproved (trx_to,trx_remark1,trx_up,trx_from,trx_from_fax,trx_telp,trx_fax,trx_ref,trx_date
				,trx_client_id,trx_client_code,trx_client_name,trx_acc_no,trx_acc_name,trx_bank_name,trx_type
				,trx_deposit_type,trx_deposit_tenor,trx_deposit_tenor_hr,trx_deposit_tenor_bln,trx_valuta_date
				,trx_due_date,trx_tax_status,trx_rate_payment,trx_nominal,trx_rate,trx_due_date_type
				,trx_validation_key,trx_create_dt,trx_create_by,trx_modified_dt,trx_progress_status,trx_progress_by
				,trx_other,trx_break_dt,trx_curr,trx_id_master,trx_id_upper,trx_bilyet_flag_no,bank_acc_no,bank_acc_name
				,pic_id,trx_rate_break,itd_kategori)
			values(@trx_to,@trx_remark1,@trx_up,@trx_from,@trx_from_fax,@trx_telp,@trx_fax,@ref,@trx_date,@trx_client_id
					,@trx_client_code,@trx_client_name,@trx_acc_no,@trx_acc_name,@trx_bank_name,@trx_type
					,@trx_deposit_type,@trx_deposit_tenor,@trx_deposit_tenor_hr,@trx_deposit_tenor_bln
					,@trx_valuta_date,@trx_due_date,@trx_tax_status,@trx_rate_payment,@trx_nominal,@trx_rate
					,@trx_due_date_type,@trx_validation_key,getdate(),@trx_create_by,getdate()
					,1,@trx_create_by,@trx_other,@trx_break_dt,@trx_curr,@trx_id_master,@trx_id_upper,@bilyet_flag,@bank_acc_no,@bank_acc_name
					,@pic_id,@trx_rate_break,'C003')
		end
				
		-- ================================ --
		else
		begin
			insert into itd_trx_unapproved (trx_to,trx_remark1,trx_up,trx_from,trx_from_fax,trx_telp,trx_fax,trx_ref,trx_date
				,trx_client_id,trx_client_code,trx_client_name,trx_acc_no,trx_acc_name,trx_bank_name,trx_type
				,trx_deposit_type,trx_deposit_tenor,trx_deposit_tenor_hr,trx_deposit_tenor_bln,trx_valuta_date
				,trx_due_date,trx_tax_status,trx_rate_payment,trx_nominal,trx_rate,trx_due_date_type
				,trx_validation_key,trx_create_dt,trx_create_by,trx_modified_dt,trx_progress_status,trx_progress_by
				,trx_other,trx_break_dt,trx_curr,trx_id_master,trx_id_upper,trx_bilyet_flag_no,bank_acc_no,bank_acc_name,pic_id,trx_rate_break)
			values(@trx_to,@trx_remark1,@trx_up,@trx_from,@trx_from_fax,@trx_telp,@trx_fax,@ref,@trx_date,@trx_client_id
					,@trx_client_code,@trx_client_name,@trx_acc_no,@trx_acc_name,@trx_bank_name,@trx_type
					,@trx_deposit_type,@trx_deposit_tenor,@trx_deposit_tenor_hr,@trx_deposit_tenor_bln
					,@trx_valuta_date,@trx_due_date,@trx_tax_status,@trx_rate_payment,@trx_nominal,@trx_rate
					,@trx_due_date_type,@trx_validation_key,getdate(),@trx_create_by,getdate()
					,1,@trx_create_by,@trx_other,@trx_break_dt,@trx_curr,@trx_id_master,@trx_id_upper,@bilyet_flag,@bank_acc_no,@bank_acc_name,@pic_id,@trx_rate_break)
		end
		select max(trx_id) as trx_id from itd_trx_unapproved where trx_create_by=@trx_create_by;
	end

    -- Insert statements for procedure here
	-- SELECT 1 as trx_unix_no, * from itd_trx_unapproved
	
END