<?php

namespace App\Http\Controllers;

use App\Models\document\doc_file;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PrintQRController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Print_QR($docID)
    {
//        $qrcode = base64_encode(QrCode::format('svg')->size(60)->errorCorrection('M')->generate('http://192.168.11.64:8000/track/doctrack/'.$docID));

        $date_time = Carbon::now();

        $date_generated = format_date_time(0, $date_time);

        $qrcode = base64_encode(QrCode::format('svg')->size(60)->errorCorrection('M')->generate($docID));

        $pdf = PDF::loadView('Documents.PDF.myPDF', compact('qrcode', 'date_generated'))->setPaper('a4', 'portrait');
        return $pdf->stream($docID.'.pdf');

    }
}
