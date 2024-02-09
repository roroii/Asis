<?php

namespace App\Http\Controllers\faculty_monitoring;

use App\Http\Controllers\Controller;
use App\Models\others\link_classes;
use App\Models\others\link_meeting;
use App\Models\posgres_db\srgb\srgb_semsubject;
use App\Models\system\default_settingNew;
use App\Models\tblemployee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MonitoringController extends Controller
{
    /**
         * Create a new controller instance.
         *
         * @return void
     */
    public function __construct(){

        $this->middleware('auth');
        //$this->middleware('auth',['except' => ['login','setup','setupSomethingElse']]);
    }

    /**
         * Show the application dashboard.
         *
         * @return \Illuminate\Contracts\Support\Renderable
     */

     public function monitoring(Request $request)
     {
         $limit = $request->input('limit', 8);
         $searchQuery = $request->input('search', '');
         $filter = $request->input('filter', '');
         $pageTitle = 'All Sessions';

         // Update the ended_at field for the records where started_at is more than 3 hours ago
         $linkClassesToUpdate = link_classes::whereNotNull('started_at')
             ->whereNull('ended_at')
             ->where('started_at', '<=', Carbon::now()->subHours(3)->toDateTimeString())
             ->get();

         $linkClassesToUpdate->each(function ($linkClass) {
             $startedAt = Carbon::parse($linkClass->started_at);
             $endedAt = $startedAt->copy()->addHours(3);

             $linkClass->ended_at = $endedAt;
             $linkClass->save();

             $update_link_meeting = [
                 'link_class_id'=> '',
                 'status'=> 14,
             ];

             link_meeting::updateOrCreate(['id'=> $linkClass->link_meeting_id],$update_link_meeting);
         });

         $query = link_classes::query()->orderByDesc('id'); // Order the data by ID in descending order

         if (!empty($searchQuery)) {
             $query->where(function ($subQuery) use ($searchQuery) {
                 $subQuery->where('started_at', 'like', '%' . $searchQuery . '%')
                     ->orWhereHas('meetingDetails', function ($subSubQuery) use ($searchQuery) {
                         $subSubQuery->where('link_meeting', 'like', '%' . $searchQuery . '%')
                             ->orWhere('sc', 'like', '%' . $searchQuery . '%');
                     })
                     ->orWhere(function ($subSubQuery) use ($searchQuery) {
                         $subSubQuery->whereHas('createdBy', function ($innerSubQuery) use ($searchQuery) {
                             $innerSubQuery->where('firstname', 'like', '%' . $searchQuery . '%')
                                 ->orWhere('lastname', 'like', '%' . $searchQuery . '%');
                         });
                     });
             });
         }

         if ($filter === 'ongoing') {
             $query->whereNull('ended_at');
             $pageTitle = 'Ongoing Sessions';
         } elseif ($filter === 'ended') {
             $query->whereNotNull('ended_at');
             $pageTitle = 'Ended Sessions';
         }

         $data = $query->paginate($limit);

         $data->getCollection()->transform(function ($item) {
             $item->profile_pic = get_profile_image($item->created_by);
             $item->profile_name = Str::title(fullname($item->created_by));
             $item->meeting_details = link_meeting::where('link_class_id', $item->id)->first();
             $item->semsubject_details = srgb_semsubject::where('oid', $item->_oid)->first();
             $item->started_at_diff = Carbon::parse($item->started_at)->diffForHumans();

             // Check if session has ended or is ongoing
             if ($item->ended_at !== null) {
                 $item->ended_at_diff = Carbon::parse($item->ended_at)->diffForHumans();
             } else {
                 $item->ended_at_diff = null;
             }

             return $item;
         });

         return view('faculty_monitoring.monitoring', compact('data', 'limit', 'searchQuery', 'filter', 'pageTitle'));
     }

    public function fetchData(Request $request)
    {
        $perPage = $request->input('limit', 10);
        $search = $request->input('search', '');

        // Query your data using the provided page, limit, and search values
        $data = link_classes::where('started_at', 'LIKE', "%$search%")->paginate($perPage);

        // Render the data using a blade template
        $html = view('faculty_monitoring.monitoring_modal.data', compact('data'))->render();

        // Return the paginated data as a JSON response
        return response()->json([
            'data' => $html,
            'pagination' => $data->links()->toHtml(),
            'entryCount' => "Showing 1 to {$data->count()} of {$data->total()} entries"
        ]);
    }

    public function getProfileImage($id)
    {

        $img = '';
            if($id)
            {
                $get_image = tblemployee::where('agencyid',$id)->orWhere('user_id', $id)->where('active',true)->first();
                $img = '';

                if($get_image)
                {
                    if($get_image->image){
                        $get_image =$get_image->image;
                        $profile = url('') . "/uploads/profiles/" . $get_image;
                        $img = $profile;
                    }else{
                        $query = default_settingNew::where('key', 'agency_logo')->where('active', true)->first();
                        $get_image= $query->image;
                        $profile_pic = url('') . "/uploads/settings/" . $get_image;
                        $img = $profile_pic;
                    }

                }else{
                    $query = default_settingNew::where('key', 'agency_logo')->where('active', true)->first();
                    $get_image= $query->image;
                    $profile_pic = url('') . "/uploads/settings/" . $get_image;
                    $img = $profile_pic;
                }


            }else{
                $query = default_settingNew::where('key', 'agency_logo')->where('active', true)->first();
                $get_image= $query->image;
                $profile_pic = url('') . "/uploads/settings/" . $get_image;
                $img = $profile_pic;
            }

            // return $img;

        return response()->json(['image' => $img]);
    }
}
