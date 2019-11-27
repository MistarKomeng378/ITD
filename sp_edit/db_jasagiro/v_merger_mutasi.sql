SELECT     TOP (100) PERCENT dbo.v_all_data_mutasi.src_dt, dbo.v_all_data_mutasi.client_code, dbo.v_all_data_mutasi.subsrd_date, dbo.v_all_data_mutasi.subsrd_nominal, 
                      dbo.v_all_data_mutasi.deskripsi, dbo.v_all_data_mutasi.subsrd_kategori, dbo.v_all_data_mutasi.acc_no,
                          (SELECT     acc_no
                            FROM          dbo.mutasi_client
                            WHERE      (acc_no = dbo.v_all_data_mutasi.acc_no) AND (client_code = dbo.v_all_data_mutasi.client_code)) AS acc_no1,
                          (SELECT     client_name
                            FROM          dbo.mutasi_client AS mutasi_client_4
                            WHERE      (acc_no = dbo.v_all_data_mutasi.acc_no) AND (client_code = dbo.v_all_data_mutasi.client_code)) AS client_name,
                          (SELECT     kena_jasgir
                            FROM          dbo.mutasi_client AS mutasi_client_3
                            WHERE      (acc_no = dbo.v_all_data_mutasi.acc_no) AND (client_code = dbo.v_all_data_mutasi.client_code)) AS kena_jasgir,
                          (SELECT     client_enable
                            FROM          dbo.mutasi_client AS mutasi_client_2
                            WHERE      (acc_no = dbo.v_all_data_mutasi.acc_no) AND (client_code = dbo.v_all_data_mutasi.client_code)) AS client_enable,
                          (SELECT     bank_name
                            FROM          dbo.mutasi_client AS mutasi_client_1
                            WHERE      (acc_no = dbo.v_all_data_mutasi.acc_no) AND (client_code = dbo.v_all_data_mutasi.client_code)) AS bank_name, dbo.coa.coa_desc
FROM         dbo.v_all_data_mutasi INNER JOIN
                      dbo.coa ON dbo.v_all_data_mutasi.subsrd_kategori = dbo.coa.coa_no
ORDER BY dbo.v_all_data_mutasi.subsrd_date DESC