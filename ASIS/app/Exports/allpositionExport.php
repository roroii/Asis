<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use App\Services\ExcelServices;




class allpositionExport implements FromView,ShouldAutosize
{

    use Exportable;

    public function view(): View
    {
        $extract_data = new ExcelServices;
        $date = $extract_data->get_date();
        $get_org_head = $extract_data->get_head_org();
        $get_org_head_pos = $extract_data->get_head_org_pos();
        $get_hrm = $extract_data->get_the_HRM();
        $get_job_info_data = $extract_data->get_all_job_info();
        $get_doc_req_data = $extract_data->count_doc_re();
        $get_remarks_id = $extract_data->count_lenght_remarks();
        $get_remarks = $extract_data->get_doc_req_custom($get_remarks_id);
        $get_email = $extract_data->get_email();
        $get_address = $extract_data->get_address();

        return view('hiring_blade.export_pdf.export_all_position',compact('date','get_org_head','get_org_head_pos','get_hrm','get_job_info_data','get_doc_req_data','get_remarks','get_email','get_address'));
    }
}
