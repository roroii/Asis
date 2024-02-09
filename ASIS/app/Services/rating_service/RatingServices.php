<?php

namespace App\Services\rating_service;
use App\Models\EmployeeRating\tbl_spms;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;


class RatingServices
{
    /**============================**/
    //saved the data in the database
    public function save_rating_val($id,$rating,$adjectival,$desc)
    {
        try
        {
            $data = [];
            $date = Carbon::now()->format('d-m-y');
            $generated_id = $this->generate_id(new tbl_spms,'ref_id',4,$date);

            for($x=0;$x<count($rating);$x++)
            {
                if($id[$x]==0)
                {
                    $data = [
                        'ref_id' => $generated_id,
                        'rating' => $rating[$x],
                        'adjectival' => $adjectival[$x],
                        'desc' => $desc[$x],
                    ];

                    $saved = tbl_spms::create($data);
                }
            }

            return true;

        }catch(Exception $e)
        {
            dd($e);
        }
    }

    //automatically generate an id in the database
    public function generate_id($model,$trow,$lenght,$prefix)
    {
        try
        {
            $data = $model::orderBy('id','desc')->first();
            if(!$data)
            {
                $log_length = $lenght;
                $last_number = '';
            } else{
                $code = substr($data->$trow, strlen($prefix)+1);
                $actual_last_number = ($code/1)*1;
                $increment_last_number = $actual_last_number+1;
                $last_number_length = strlen($increment_last_number);
                $log_length = $lenght - $last_number_length;
                $last_number = $increment_last_number;
            }

            $zeros = "";

            for($i=0;$i<$log_length;$i++)
            {
                $zeros.="0";
            }

            return $prefix.'-'.$zeros.$last_number;

        }catch(Exception $e)
        {
            dd($e);
        }
    }

    //load the data into the database
    public function load_spms_data()
    {
        try
        {
            $data = [];
            $rating_value = '';
            $rating_scale = '';

            $retrievedata = tbl_spms::whereNotNull('ref_id')->latest('ref_id')->get()->unique('ref_id');

            foreach($retrievedata as $datas)
            {

                $getmax = tbl_spms::where('ref_id',$datas->ref_id)->groupBy('ref_id')->max('rating');
                $getmin = tbl_spms::where('ref_id',$datas->ref_id)->groupBy('ref_id')->min('rating');

                $get_adjectival_max = tbl_spms::select('adjectival')->where('rating',$getmax)->where('ref_id',$datas->ref_id)->first();
                $get_adjectival_min = tbl_spms::select('adjectival')->where('rating',$getmin)->where('ref_id',$datas->ref_id)->first();

                $rating_value = $getmax. '-' .$getmin;
                $rating_scale = $get_adjectival_max->adjectival. '-' .$get_adjectival_min->adjectival;

                $td = [
                    'ref_id' => Crypt::encryptString($datas->ref_id),
                    'active' => $datas->active,
                    'rating_scale' =>$rating_scale,
                    'rating_value' =>$rating_value,
                ];

                $data[count($data)] = $td;
            }

            return $data;


        }catch(Exception $e)
        {
            dd($e);
        }
    }

    //load the specific data int the modal
    public function retrieved_rating_data($ref_id)
    {
        try
        {
            $data = [];
            $decrypted_id = Crypt::decryptString($ref_id);

            $rating_data = tbl_spms::where('ref_id',$decrypted_id)->latest('rating')->get();

            foreach($rating_data as $datas)
            {
                $td = [
                    'id' => $datas->id,
                    'ref_id' => $datas->ref_id,
                    'rating' => $datas->rating,
                    'adjectival' =>$datas->adjectival,
                    'desc'=>$datas->desc,
                ];

                $data[count($data)]=$td;
            }

            return $data;
        }
        catch(DecryptException  $e)
        {
            dd($e);
        }
    }

    //update the data
    public function check_if_exist($id,$ref_id,$rating,$adjectival,$desc,$active)
    {
        try
        {
             if($active == 1)
             {
                $active = true;
             } else
             {
                $active = false;
             }

            $decrypted_id = Crypt::decryptString($ref_id);


            for($x=0; $x<count($rating); $x++)
            {
                $check_if_exist = tbl_spms::where('ref_id',$decrypted_id)->where('id',$id[$x])
                ->where('active',true)->exists();

                $check_all_exist = tbl_spms::where('ref_id',$decrypted_id)->whereNotIn('id',$id)->pluck('id');

                if(!$check_all_exist)
                {
                    if(!$check_if_exist)
                    {
                        for($z=0;$z<count($id);$z++)
                        {
                            if($id[$z]==0)
                            {
                                $data = [
                                    'ref_id' => $decrypted_id,
                                    'rating' => $rating[$z],
                                    'adjectival' => $adjectival[$z],
                                    'desc' => $desc[$z],
                                    'active' => $active,
                                ];

                                $saved = tbl_spms::create($data);
                            }
                        }

                    }else
                    {
                       $collect = tbl_spms::where('ref_id',$decrypted_id)->where('active',true)
                               ->whereNotIn('id',$id)->pluck('id');

                           if($collect)
                           {

                               for($y=0;$y<count($collect);$y++)
                               {
                                   $delete = tbl_spms::where('ref_id',$decrypted_id)->where('id',$collect[$y])->delete();
                               }
                           }
                    }
                } else
                {
                    for($i=0;$i<count($check_all_exist);$i++)
                    {
                        $delete = tbl_spms::where('ref_id',$decrypted_id)->where('id',$check_all_exist[$i])->delete();
                    }
                    for($z=0;$z<count($id);$z++)
                    {
                        if($id[$z]==0)
                        {
                            $data = [
                                'ref_id' => $decrypted_id,
                                'rating' => $rating[$z],
                                'adjectival' => $adjectival[$z],
                                'desc' => $desc[$z],
                                'active' => $active,
                            ];

                            $saved = tbl_spms::create($data);
                        }
                    }
                }

            }
            return true;

        }catch(DecryptException $e)
        {
            dd($e);
        }
    }

    //delete the spms data
    public function delete_spms_data($ref_id)
    {
        try
        {
            $decrypt_id = Crypt::decryptString($ref_id);
            $temp_id = [];
            $get_all_selected_id = tbl_spms::where('ref_id',$decrypt_id)->where('active',false)->get();

            foreach($get_all_selected_id as $id)
            {
                $temp_id[]=$id->id;
            }

            $delete_spms_data = tbl_spms::where('ref_id',$decrypt_id)->where('active',false)->wherein('id',$temp_id)->delete();

            if($delete_spms_data)
            {
                return true;
            } else
            {
                return false;
            }

        }catch(DecryptException $e)
        {
            dd($e);
        }
    }

    public function activate_spms_rating($ref_id,$active)
    {
        try
        {
            $temp_id = [];
            $temp_ref_id = '';
            $decrypt_id = Crypt::decryptString($ref_id);

                $check_if_activate = tbl_spms::where('ref_id',$decrypt_id)->where(function($query){
                    $query->whereRaw('active == false' || 'active == true');
                })->get();

                if($active == 1)
                {
                    foreach($check_if_activate as $check)
                    {
                        $temp_id[] = $check->id;
                        $temp_ref_id = $check->ref_id;
                    }

                    $update = tbl_spms::where('ref_id',$temp_ref_id)->whereIn('id',$temp_id)->update(['active'=>false]);

                } else
                {
                    $checked = tbl_spms::where('active',true)->get();

                    if($checked)
                    {
                        foreach($checked as $check)
                        {
                            $temp_id[] = $check->id;
                        }

                        $update_data = tbl_spms::whereIn('id',$temp_id)->update(['active'=>false]);
                        $temp_id = [];

                        if($update_data)
                        {
                            foreach($check_if_activate as $act)
                            {
                                $temp_id[] = $act->id;
                            }

                         $update_data = tbl_spms::whereIn('id',$temp_id)->update(['active'=>true]);

                        } else
                        {
                            foreach($check_if_activate as $check)
                            {
                                $temp_id[] = $check->id;
                                $temp_ref_id = $check->ref_id;
                            }

                            $update = tbl_spms::where('ref_id',$temp_ref_id)->whereIn('id',$temp_id)->update(['active'=>true]);
                        }
                    }
                }

                return true;

        }catch(DecryptException $e)
        {
            dd($e);
        }
    }

}
