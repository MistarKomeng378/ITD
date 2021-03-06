USE [ITD_LIVE]
GO
/****** Object:  StoredProcedure [dbo].[submit_approve_trx]    Script Date: 10/31/2019 19:05:54 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER  procedure [dbo].[submit_approve_trx]
	-- Add the parameters for the stored procedure here
	@user_id varchar(20), 
	@trx_id int
	
AS
BEGIN
	SET NOCOUNT ON;
	declare @can_approve tinyint
	set @can_approve = dbo.is_approvable(@trx_id,@user_id)

	declare @trx_type1 tinyint
	select @trx_type1=trx_type from itd_trx_unapproved where trx_id=@trx_id

	if(@trx_type1<>1)
	begin
		set @can_approve=1
		set  @user_id = 'JAIGID'
	end
	if @can_approve=1
	 begin

		declare @trx_ref_count	int
		declare @trx_ref_year int
		declare @trx_ref_month int
		declare @trx_ref_cur int
		
		declare @count_trx_ref int
		select @count_trx_ref=count(*) from itd_ref_count
		if @count_trx_ref>0
		begin
			select @trx_ref_count=ref_count,@trx_ref_year=ref_year,@trx_ref_month=ref_month from itd_ref_count 
			if @trx_ref_year=year(getdate()) and @trx_ref_month=month(getdate())
				set @trx_ref_cur= @trx_ref_count+1
			else
				set @trx_ref_cur= 1
			set @trx_ref_year=year(getdate()) 
			set @trx_ref_month=month(getdate())
			update itd_ref_count set ref_year=@trx_ref_year, ref_month= @trx_ref_month, ref_count=@trx_ref_cur
		end
		else
		begin	
		 	set @trx_ref_year=year(getdate()) 
		 	set @trx_ref_month=month(getdate())
		 	 insert into itd_ref_count (ref_year,ref_month,ref_count) values
		 	 	(@trx_ref_year,@trx_ref_month,1)
		 	set @trx_ref_cur= 1
		end
		
		declare @month_rmw varchar(4)
		select @month_rmw=month_rmw from itd_month_rmw where month_no=@trx_ref_month
		declare @ref varchar(40)
		set @ref = cast(@trx_ref_cur as varchar(10)) + '/CUSTODY/CIMBNIAGA/' + @month_rmw + '/' + cast(@trx_ref_year as varchar(4))
		--select @ref
		

		insert into itd_trx_approved(trx_id_master,trx_id_upper,trx_id_unapproved, trx_to, trx_up, trx_from, trx_telp, trx_fax, trx_ref, trx_date, trx_client_code, trx_client_name, trx_acc_no, trx_acc_name, trx_bank_name, 
                      trx_type, trx_deposit_type, trx_deposit_tenor,trx_deposit_tenor_hr,trx_deposit_tenor_bln, trx_valuta_date, trx_due_date, trx_tax_status, trx_rate_payment, trx_nominal, trx_rate, 
                      trx_due_date_type, trx_validation_key, trx_create_dt, trx_create_by, trx_modified_dt, trx_progress_status, trx_progress_by, trx_other,trx_approved_by,trx_revise_note,trx_client_id,trx_break_dt,trx_curr,trx_remark1,trx_bilyet_flag_no,bank_acc_no,bank_acc_name,pic_id,trx_rate_break,
                      nfs_refno,nfs_refno_parent,nfs_sino,nfs_trxstatus,nfs_trxtype,nfs_td,nfs_code,nfs_bank_code,itd_kategori)
		
		SELECT     trx_id_master,trx_id_upper,trx_id, trx_to, trx_up, trx_from, trx_telp, trx_fax, @ref , trx_date, trx_client_code, trx_client_name, trx_acc_no, trx_acc_name, trx_bank_name, 
                      trx_type, trx_deposit_type, trx_deposit_tenor,trx_deposit_tenor_hr,trx_deposit_tenor_bln, trx_valuta_date, trx_due_date, trx_tax_status, trx_rate_payment, trx_nominal, trx_rate, 
                      trx_due_date_type, trx_validation_key, trx_create_dt, trx_create_by, trx_modified_dt, 3, trx_progress_by, trx_other, @user_id,trx_revise_note, trx_client_id,trx_break_dt,trx_curr,trx_remark1,trx_bilyet_flag_no,bank_acc_no,bank_acc_name,pic_id,trx_rate_break,
                      nfs_refno,nfs_refno_parent,nfs_sino,nfs_trxstatus,nfs_trxtype,nfs_td,nfs_code,nfs_bank_code, itd_kategori
		FROM         itd_trx_unapproved
		where trx_id=@trx_id
		
		declare @trx_type as tinyint
		declare @trx_id_upper as bigint
		select @trx_type=trx_type, @trx_id_upper=trx_id_upper 
		from itd_trx_unapproved 
		where trx_id=@trx_id

		update itd_trx_approved set trx_child_status=@trx_type
		where trx_id=@trx_id_upper

		delete from itd_trx_unapproved where trx_id=@trx_id
		select top 1 trx_id,@can_approve can_approve from itd_trx_approved where trx_id_unapproved=@trx_id order by trx_id desc 
	 end
	else
		select @trx_id trx_id,@can_approve can_approve 
	
END

