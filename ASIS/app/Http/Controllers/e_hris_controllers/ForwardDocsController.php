<?php

namespace App\Http\Controllers;

use App\Models\document\doc_file_track;
use App\Models\document\doc_track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForwardDocsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function forwardDocuments(Request $request)
    {
//        dd($request);
        if ($request->has('empID'))
        {
            foreach ($request->empID as $key => $emp_ID) {

                $forward_to_employees = [
                    'track_number' => $request->docID,
                    'type' => 'user',
                    'type_id' => Auth::user()->employee,
                    'target_user_id' => $emp_ID,
                    'note' => $request->note,
                    'for_status' => 3,
                    'action' => false,
                    'seen' => false,
                    'active' => true,
                    'created_by' => Auth::user()->employee,
                    'target_type' => 'user',
                    'target_id' => $emp_ID,
                    'last_activity' => false,

                ];
                doc_track::create($forward_to_employees);

                createNotification('document', $request->docID, 'user', Auth::user()->employee, $emp_ID, 'user', 'You have a document to receive with tracking number : ' . $request->docID . '.');
            }
            __notification_set(1,'Success','Document with Tracking #: '.$request->docID.' Send Successfully!');
            return response()->json([
                'status' => 200,
            ]);
        }
    }
}
