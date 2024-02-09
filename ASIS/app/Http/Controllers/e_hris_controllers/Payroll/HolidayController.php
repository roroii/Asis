<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\event\event;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function index(Request $request){

        if($request->ajax()) {
            $data = event::whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'title', 'start', 'end']);

            return response()->json($data);
        }

        return view('payroll.holiday');
    }

    public function calendarEvents(Request $request)
    {

        switch ($request->type) {
           case 'create':
              $event = event::create([
                  'title' => $request->event_name,
                  'date' => $request->date,
                  'start' => $request->event_start,
                  'end' => $request->event_end,
              ]);

              return response()->json($event);
             break;

           case 'edit':
              $event = event::find($request->id)->update([
                  'title' => $request->event_name,
                  'date' => $request->date,
                  'start' => $request->event_start,
                  'end' => $request->event_end,
              ]);

              return response()->json($event);
             break;

           case 'delete':
              $event = event::find($request->id)->delete();

              return response()->json($event);
             break;

           default:
             # ...
             break;
        }
    }
}
