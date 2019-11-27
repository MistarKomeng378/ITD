SELECT
	src_dt,
	client_code,
	subsrd_date,
	subsrd_nominal,
	subsrd_kategori,
	deskripsi,
	acc_no 
FROM
	(
	SELECT
		'subsrd' AS src_dt,
		client_code,
		subsrd_date,
		subsrd_nominal,
		subsrd_kategori,
		deskripsi,
		acc_no 
	FROM
		(
		SELECT TOP
			( 100 ) PERCENT 
			a.client_code,
			a.subsrd_date,
			SUM ( a.subsrd_nominal ) AS subsrd_nominal,
			( SELECT TOP ( 1 ) subsrd_kategori FROM subsrd WHERE client_code = a.client_code ) AS subsrd_kategori,
			( SELECT TOP ( 1 ) bank_src FROM subsrd WHERE client_code = a.client_code AND acc_no_src = a.acc_no_src ) AS deskripsi,
			a.acc_no_src AS acc_no 
		FROM
			subsrd a 
		WHERE
			client_code IN ( SELECT client_code FROM mutasi_client WHERE client_enable = 1 ) 
		GROUP BY
			a.client_code,
			a.subsrd_date,
			a.acc_no_src 
		ORDER BY
			a.subsrd_date DESC
		) AS subsrd UNION ALL
	SELECT
		'subsrd_jasgir' AS src_dt,
		client_code,
		subsrd_date,
		subsrd_nominal,
		subsrd_kategori,
		deskripsi,
		acc_no 
	FROM
		(
		SELECT TOP
			( 100 ) PERCENT dbo.mutasi_giro.client_code,
			dbo.mutasi_giro.giro_asof_date AS subsrd_date,
			dbo.mutasi_giro.giro_nominal AS subsrd_nominal,
			'C001' AS subsrd_kategori,
			'Jasa Giro' AS deskripsi,
			dbo.mutasi_giro.acc_no 
		FROM
			dbo.mutasi_client AS mutasi_client_1
			INNER JOIN dbo.mutasi_giro ON dbo.mutasi_giro.client_code = mutasi_client_1.client_code 
			AND mutasi_client_1.acc_no = dbo.mutasi_giro.acc_no 
		WHERE
			( mutasi_client_1.kena_jasgir = '1' ) 
		GROUP BY
			dbo.mutasi_giro.giro_nominal,
			dbo.mutasi_giro.client_code,
			dbo.mutasi_giro.giro_asof_date,
			dbo.mutasi_giro.acc_no 
		ORDER BY
			subsrd_date 
		) AS subsrd_jasgir UNION ALL
	SELECT
		'itd_Penempatan' AS src_dt,
		client_code,
		subsrd_date,
		subsrd_nominal,
		subsrd_kategori,
		deskripsi,
		acc_no 
	FROM
		(
		SELECT TOP
			( 100 ) PERCENT trx_client_code AS client_code,
			CONVERT ( DATE, trx_date ) AS subsrd_date,
			trx_nominal AS subsrd_nominal,
			'D002' AS subsrd_kategori,
			trx_to AS deskripsi,
			trx_acc_no AS acc_no 
		FROM
			ITD_LIVE.dbo.itd_trx_approved 
		WHERE
			( trx_type = '1' ) 
		GROUP BY
			trx_to,
			itd_kategori,
			trx_nominal,
			trx_client_code,
			trx_acc_no,
			CONVERT ( DATE, trx_date ) 
		ORDER BY
			subsrd_date DESC 
		) AS itd_Penempatan UNION ALL
	SELECT
		'itd_Pencairan ' AS src_dt,
		client_code,
		subsrd_date,
		subsrd_nominal,
		subsrd_kategori,
		deskripsi,
		acc_no 
	FROM
		(
		SELECT TOP
			( 100 ) PERCENT trx_client_code AS client_code,
			CONVERT ( DATE, trx_date ) AS subsrd_date,
			trx_nominal AS subsrd_nominal,
			'C003' AS subsrd_kategori,
			trx_to AS deskripsi,
			trx_acc_no AS acc_no 
		FROM
			ITD_LIVE.dbo.itd_trx_approved AS itd_trx_approved_1 
		WHERE
			( trx_type = '3' ) 
		GROUP BY
			trx_type,
			trx_to,
			itd_kategori,
			trx_nominal,
			trx_client_code,
			trx_acc_no,
			CONVERT ( DATE, trx_date ) 
		ORDER BY
			subsrd_date DESC 
		) AS itd_Pencairan UNION ALL
	SELECT
		'urssim' AS src_dt,
		client_code,
		subsrd_date,
		subsrd_nominal,
		subsrd_kategori,
		deskripsi,
		acc_no
	FROM
		(
		SELECT TOP
			( 100 ) PERCENT 
			URSSIM.dbo.TXN_POSTING.TXN_TYPE,
			URSSIM.dbo.FUND_ID.CODE_BPM AS client_code,
			URSSIM.dbo.FUND_ID.ACC_BANK_OPR AS acc_no,
			CONVERT ( DATE, URSSIM.dbo.TXN_POSTING.GOOD_FUND_DATE ) AS subsrd_date,
			sum(URSSIM.dbo.TXN_POSTING.NET_PROCEED) AS subsrd_nominal,
			'D001' AS subsrd_kategori,
			'Redemption' AS deskripsi 
		FROM
			URSSIM.dbo.TXN_POSTING
			INNER JOIN URSSIM.dbo.FUND_ID ON URSSIM.dbo.TXN_POSTING.FUND_LEVEL_CODE = URSSIM.dbo.FUND_ID.FUND_LEVEL_CODE 
			AND URSSIM.dbo.TXN_POSTING.FUND_UMBRELLA_CODE = URSSIM.dbo.FUND_ID.FUND_UMBRELLA_CODE 
			AND URSSIM.dbo.TXN_POSTING.FUND_GROUP = URSSIM.dbo.FUND_ID.FUND_GROUP 
			AND URSSIM.dbo.TXN_POSTING.FUND_ID = URSSIM.dbo.FUND_ID.FUND_ID 
		WHERE
			( URSSIM.dbo.TXN_POSTING.TXN_TYPE = 'R' )
		GROUP BY
			URSSIM.dbo.TXN_POSTING.TXN_TYPE,
			URSSIM.dbo.FUND_ID.CODE_BPM,
			URSSIM.dbo.FUND_ID.ACC_BANK_OPR,
			CONVERT ( DATE, URSSIM.dbo.TXN_POSTING.GOOD_FUND_DATE ) 
		ORDER BY
			subsrd_date DESC
		) AS urssim UNION ALL
	SELECT
		'nfs_jual' AS src_dt,
		client_code,
		subsrd_date,
		subsrd_nominal,
		subsrd_kategori,
		deskripsi,
		acc_no AS acc_no
	FROM
		(
		SELECT TOP
			( 100 ) PERCENT HIPORT_CODE AS client_code,
			CONVERT ( DATE, TRADE_DATE ) AS subsrd_date,
			sum( CONVERT ( DEC, NET_SETTLEMENT_AMOUNT ) ) AS subsrd_nominal,
			'C006' AS subsrd_kategori,
			'Jual Saham / Obligasi' AS deskripsi,
			(SELECT TOP (1) FUND_OPR_ACCT_NO FROM NFS_DB.dbo.FUND_DETAILS WHERE HIPORT_CODE = NFS_DB.dbo.NFS_INQ_EQUITY_TEMP.HIPORT_CODE AND ACTIVE_STATUS = 1) AS acc_no
		FROM
			NFS_DB.dbo.NFS_INQ_EQUITY_TEMP
		WHERE
			( BUY_SELL = '2' )
		GROUP BY
			BUY_SELL,
			HIPORT_CODE,
			CONVERT ( DATE, TRADE_DATE ) 
		ORDER BY
			subsrd_date DESC
		) AS nfs_jual UNION ALL
	SELECT
		'nfs_beli' AS src_dt,
		client_code,
		subsrd_date,
		subsrd_nominal,
		subsrd_kategori,
		deskripsi,
		acc_no 
	FROM
		(
		SELECT TOP
			( 100 ) PERCENT HIPORT_CODE AS client_code,
			CONVERT ( DATE, TRADE_DATE ) AS subsrd_date,
			SUM ( CONVERT ( DEC, NET_SETTLEMENT_AMOUNT ) ) AS subsrd_nominal,
			'C007' AS subsrd_kategori,
			'Beli Saham / Obligasi' AS deskripsi,
			(SELECT TOP (1) FUND_OPR_ACCT_NO FROM NFS_DB.dbo.FUND_DETAILS WHERE HIPORT_CODE=NFS_DB.dbo.NFS_INQ_EQUITY_TEMP.HIPORT_CODE AND ACTIVE_STATUS=1) AS acc_no
		FROM
			NFS_DB.dbo.NFS_INQ_EQUITY_TEMP 
		WHERE
			( BUY_SELL = '1' ) 
		GROUP BY
			BUY_SELL,
			HIPORT_CODE,
			CONVERT ( DATE, TRADE_DATE ) 
		ORDER BY
			subsrd_date DESC
		) AS nfs_beli UNION ALL
	SELECT
		'nfs_Wht_Commision' AS src_dt,
		client_code,
		subsrd_date,
		subsrd_nominal,
		subsrd_kategori,
		deskripsi,
		acc_no 
	FROM
		(
		SELECT TOP
			( 100 ) PERCENT HIPORT_CODE AS client_code,
			CONVERT ( DATE, TRADE_DATE ) AS subsrd_date,
			sum( CONVERT ( DEC, WHT_COMMISION ) ) AS subsrd_nominal,
			'D016' AS subsrd_kategori,
			'Wht Commision' AS deskripsi,
			(
				SELECT TOP (1) FUND_OPR_ACCT_NO
				FROM NFS_DB.dbo.FUND_DETAILS
				WHERE NFS_DB.dbo.FUND_DETAILS.HIPORT_CODE = NFS_DB.dbo.NFS_INQ_EQUITY_TEMP.HIPORT_CODE
				AND ACTIVE_STATUS=1
			) AS acc_no
		FROM
			NFS_DB.dbo.NFS_INQ_EQUITY_TEMP
		where CONVERT ( DEC, WHT_COMMISION ) > 0
		GROUP BY
			HIPORT_CODE,
			CONVERT ( DATE, TRADE_DATE ) 
		ORDER BY
			subsrd_date desc
		) AS nfs_Wht_Commision UNION ALL
	SELECT
		'nfs_CAPITAL_INTERS_OR_GIANT_TAX' AS src_dt,
		client_code,
		subsrd_date,
		subsrd_nominal,
		subsrd_kategori,
		deskripsi,
		acc_no
	FROM
		(
		SELECT TOP
		( 100 ) PERCENT HIPORT_CODE AS client_code,
		CONVERT ( DATE, TRADE_DATE ) AS subsrd_date,
		SUM ( CONVERT ( DEC, INTEREST_INCOME_TAX ) + CONVERT ( DEC, CAPITAL_GAIN_TAX ) ) AS subsrd_nominal,
		'D017' AS subsrd_kategori,
		'Interst/Gain Income Tax' AS deskripsi,
		(
		SELECT TOP
			( 1 ) FUND_OPR_ACCT_NO 
		FROM
			NFS_DB.dbo.FUND_DETAILS 
		WHERE
			NFS_DB.dbo.FUND_DETAILS.HIPORT_CODE = NFS_DB.dbo.NFS_FI_INS_INQ_TEMP.HIPORT_CODE 
			AND ACTIVE_STATUS = 1 
		) AS acc_no 
	FROM
		NFS_DB.dbo.NFS_FI_INS_INQ_TEMP 
	WHERE
		( CONVERT ( DEC, INTEREST_INCOME_TAX ) > 0 or CONVERT ( DEC, CAPITAL_GAIN_TAX ) > 0 )
	GROUP BY
		HIPORT_CODE,
		CONVERT ( DATE, TRADE_DATE ) 
	ORDER BY
		subsrd_date DESC
		) AS nfs_CAPITAL_INTERS_OR_GIANT_TAX  
	) AS all_data