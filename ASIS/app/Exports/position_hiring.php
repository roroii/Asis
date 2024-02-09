<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Hiring\tbljob_info;
use App\Models\Hiring\tbljob_doc_rec;
use App\Models\Hiring\tbleduc_req;
use App\Models\tblemployee;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;

use App\Services\ExcelServices;

class position_hiring implements FromView,ShouldAutoSize
{
    use Exportable;

    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        try {
                $extract_data = new ExcelServices;

                $decrypted_id = Crypt::decryptString($this->id);
                $date = $extract_data->get_date();
                $get_org_head = $extract_data->get_head_org();
                $get_org_head_pos = $extract_data->get_head_org_pos();

                $get_job_info_custom = $extract_data ->get_job_info_custom($decrypted_id);
                $get_educ_rec_custom = $extract_data ->get_educ_rec_custom($decrypted_id);
                $get_doc_req_custom = $extract_data ->get_doc_req_custom($decrypted_id);

                return view('hiring_blade.export_pdf.export_excel',compact('get_job_info_custom','get_educ_rec_custom','get_doc_req_custom','get_org_head','get_org_head_pos','date'));

        } catch (DecryptException $e) {
            dd($e);
        }
    }

}
