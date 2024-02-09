<?php

namespace App\Http\Controllers\analytic;

use App\Charts\gender_chart;
use App\Events\victor;
use App\Http\Controllers\Controller;
use App\Models\tblemployee;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard_analytics()
    {

        return view('admin.dashboard.analytics.analytics');
    }

    public function dashboard_analytics_gender(Request $request){
        $currentYear = date('Y');
        // $currentYear = 2026;
        $previousYear = $currentYear - 1;

        $data = $request->all();
        $get_sex = tblemployee::where('active',1)->get();

        $get_total =  $get_sex->count();
        $get_male =  $get_sex->where('sex','Male')->count();
        $get_female =  $get_sex->where('sex','Female')->count();
        $get_n_a =  $get_sex->whereNull('sex')->count();

        $percentage_male = ($get_male*100)/$get_total;
        $percentage_female =  ($get_female*100)/$get_total;
        $percentage_n_a = ($get_n_a*100)/$get_total;



        $male_data = tblemployee::select(
            DB::raw('year(entrydate) as year'),
            DB::raw('month(entrydate) as month'),
            DB::raw('count(sex) as sex'))
            ->groupBy('year')
            ->groupBy('month')
            ->whereNotNull('sex')
            ->where('sex','Male')
            ->where('active',1)
            ->pluck('sex');

        $female_data = tblemployee::select(
            DB::raw('year(entrydate) as year'),
            DB::raw('month(entrydate) as month'),
            DB::raw('count(sex) as sex'))
            ->groupBy('year')
            ->groupBy('month')
            ->whereNotNull('sex')
            ->where('sex','Female')
            ->where('active',1)
            ->pluck('sex');

        $na_data = tblemployee::select(
            DB::raw('year(entrydate) as year'),
            DB::raw('month(entrydate) as month'),
            DB::raw('count(sex) as sex'))
            ->groupBy('year')
            ->groupBy('month')
            ->whereNull('sex')
            ->where('active',1)
            ->pluck('sex');
            // ->get();


            $get_total_currentYear_male =  tblemployee::where('active',1)->where('sex','Male')
            ->whereNotNull('entrydate')
            ->whereYear('entrydate', $currentYear)
            ->count();

            $get_total_previousYear_male =  tblemployee::where('active',1)->where('sex','Male')
            ->whereNotNull('entrydate')
            ->whereYear('entrydate', $previousYear)
            ->count();

            if($get_total_previousYear_male < $get_total_currentYear_male){
                if($get_total_previousYear_male > 0){
                    $percent_from = $get_total_currentYear_male - $get_total_previousYear_male;
                    $percent_male_class ='success';
                    $percent_male ='+';
                    $percent = $percent_from / $get_total_previousYear_male * 100; //increase percent
                }else{
                    $percent = 100; //increase percent
                    $percent_male_class ='primary';
                }
            }else{
                $percent_from = $get_total_previousYear_male - $get_total_currentYear_male;
                $percent = $get_total_previousYear_male == 0 ? 0 : $percent_from / $get_total_previousYear_male * 100; //decrease percent
                $percent_male_class ='danger';
                $percent_male ='-';
            }
            $chart_male_stats = $currentYear.': <span class="ml-2 font-medium text-'.$percent_male_class.'">'.$percent_male.''.$percent.'%</span>';


            $get_total_currentYear_female =  tblemployee::where('active',1)->where('sex','Female')
            ->whereNotNull('entrydate')
            ->whereYear('entrydate', $currentYear)
            ->count();

            $get_total_previousYear_female =  tblemployee::where('active',1)->where('sex','Female')
            ->whereNotNull('entrydate')
            ->whereYear('entrydate', $previousYear)
            ->count();

            if($get_total_previousYear_female < $get_total_currentYear_female){
                if($get_total_previousYear_female > 0){
                    $percent_from_female = $get_total_currentYear_female - $get_total_previousYear_female;
                    $percent_female_class ='success';
                    $percent_female ='+';
                    $percent_female_exct = $percent_from_female / $get_total_previousYear_female * 100; //increase percent
                }else{
                    $percent_female_exct = 100; //increase percent
                    $percent_female_class ='primary';
                }
            }else{
                $percent_from_female = $get_total_previousYear_female - $get_total_currentYear_female;
                $percent = $percent_from_female / $get_total_previousYear_female * 100; //decrease percent
                $percent_female_class ='danger';
                $percent_female ='-';
                $percent_female_exct = 0;
            }
            $chart_female_stats = $currentYear.': <span class="ml-2 font-medium text-'.$percent_female_class.'">'.$percent_female.''.$percent_female_exct.'%</span>';


            $get_total_currentYear_na =  tblemployee::where('active',1)->whereNull('sex')
            ->whereNotNull('entrydate')
            ->whereYear('entrydate', $currentYear)
            ->count();

            $get_total_previousYear_na =  tblemployee::where('active',1)->whereNull('sex')
            ->whereNotNull('entrydate')
            ->whereYear('entrydate', $previousYear)
            ->count();

            if($get_total_previousYear_na < $get_total_currentYear_na){
                if($get_total_previousYear_na > 0){
                    $percent_from_na = $get_total_currentYear_na - $get_total_previousYear_na;
                    $percent_na_class ='success';
                    $percent_na ='+';
                    $percent_na_exct = $percent_from_na / $get_total_previousYear_na * 100; //increase percent
                }else{
                    $percent_na_exct = 0; //increase percent
                    $percent_na = '';
                    $percent_na_class = 'primary';
                }
            }else{
                $percent_from_na = $get_total_previousYear_na - $get_total_currentYear_na;
                $percent = $percent_from_na / $get_total_previousYear_na * 100; //decrease percent
                $percent_na_class ='danger';
                $percent_na ='-';
                $percent_na_exct = 0;
            }
            $chart_na_stats = $currentYear.': <span class="ml-2 font-medium text-'.$percent_na_class.'">'.$percent_na.''.$percent_na_exct.'%</span>';


        return json_encode(array(
            "data"=>$data,
            "get_total"=>$get_total,
            "get_male"=>$get_male,
            "get_female"=>$get_female,
            "get_n_a"=>$get_n_a,
            "percentage_male"=>$percentage_male,
            "percentage_female"=>$percentage_female,
            "percentage_n_a"=>$percentage_n_a,
            "male_data"=>$male_data,
            "female_data"=>$female_data,
            "na_data"=>$na_data,
            "chart_male_stats"=>$chart_male_stats,
            "chart_female_stats"=>$chart_female_stats,
            "chart_na_stats"=>$chart_na_stats,
        ));
    }

    public function dashboard_analytics_tribe(Request $request){
        $data = $request->all();


        return json_encode(array(
            "data"=>$data,
        ));

    }

    public function dashboard_analytics_address(Request $request){
        $data = $request->all();



        return json_encode(array(
            "data"=>$data,
        ));

    }

    public function dashboard_analytics_leave(Request $request){
        $data = $request->all();



        return json_encode(array(
            "data"=>$data,
        ));

    }

    public function dashboard_analytics_SALN(Request $request){
        $data = $request->all();



        return json_encode(array(
            "data"=>$data,
        ));

    }

    public function dashboard_analytics_DTR(Request $request){
        $data = $request->all();



        return json_encode(array(
            "data"=>$data,
        ));

    }

    public function dashboard_analytics_employee(Request $request){
        $data = $request->all();



        return json_encode(array(
            "data"=>$data,
        ));

    }

    public function dashboard_analytics_travelorder(Request $request){
        $data = $request->all();



        return json_encode(array(
            "data"=>$data,
        ));

    }
}
