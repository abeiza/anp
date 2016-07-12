<?php
require_once('phpgrid/conf.php');

class CI_phpgrid {

    public function master_program()
    {
        $program = new C_DataGrid("SELECT * FROM tbl_ANPKSP_MsProgram",'ID_Program', "tbl_ANPKSP_MsProgram");
        return $program;
    }
	
	public function master_user()
    {
        $user = new C_DataGrid("SELECT * FROM tbl_ANPKSP_MsUser",'ObjectID', "tbl_ANPKSP_MsUser");
        return $user;
    }
	
	public function master_brand()
    {
        $brand = new C_DataGrid("SELECT * FROM tbl_ANPKSP_Brand",'ID_Brand', "tbl_ANPKSP_Brand");
        return $brand;
    }
	
	public function budget()
    {
        $budget = new C_DataGrid("SELECT * FROM tbl_ANPKSP_TransANP",'ObjectID', "tbl_ANPKSP_TransANP");
        return $budget;
    }
	
	public function monitoring()
    {
        $budget = new C_DataGrid("SELECT ObjectID, Req_No, Req_Date, Total_Unit, Total_Amount, Real_Amount, ID_Brand, Req_By, Manage_By, ID_Program, Period_Start, Period_End, Kode_Distributor, Nama_Distributor FROM tbl_ANPKSP_TransANP",'ObjectID', "tbl_ANPKSP_TransANP");
        return $budget;
    }
	
	public function add_item()
    {
        $budget = new C_DataGrid("SELECT * FROM tbl_ANPKSP_TransANP_Detail",'Seq_No', "tbl_ANPKSP_TransANP_Detail");
        return $budget;
    }
	
	public function realisasi()
    {
        $real = new C_DataGrid("SELECT * FROM tbl_ANPKSP_RealisasiANP",'ObjectID', "tbl_ANPKSP_RealisasiANP");
        return $real;
    }
}