<!doctype html>
<html lang = "en">

    <title>List of Requested Transactions</title>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<style>
    @page {
            margin: 5px 25px 5px 25px !important;
            padding: 0px 0px 0px 0px !important;
        }

    table, tr, td{
        border: 1px solid black;
        word-break: break-all
    }
    .header{
        font-size:10px;
        font-weight:bold;
    }

    body {
      font-family: Tahoma, sans-serif;
    }
    .no_border{
        border:none !important;
    }
    
    
    #leave_summary_table{
        font-size:12px !important;
        padding: 2px !important;
        
    }
 
    
    .mt-2{
        margin-top:15px;
    }
    
    .myfont{
        font-family: Arial, Helvetica, sans-serif;
        font-size:12px;
        display: block;
    }
</style>

</head>
<body>

    
<header>

    @if ($system_image_header)

        <img   class = "scale-down" src = "uploads/settings/{{ $system_image_header->image }}" style = "width:100%">
    @else
        <img   class = "scale-down" src = "" style = "width:100%">
    @endif

</header>
        <br><br>
    <div class="card-title" style="text-align:center;font-size: 14px; font-weight: bold;">Requested List </div>

     <div class="myfont" style="text-align:center;">Program: {{$get_CourseMajor}}</div>

    <div class="overflow-x-auto">
   <br>
<div class="myfont">
From: {{Carbon\Carbon::parse($date_from  )->format('m/d/Y')}} 

- {{Carbon\Carbon::parse($date_to  )->format('m/d/Y')}}

</div>
    <table class="table table-bordered" id="leave_summary_table" style="width: 100%;">        
    <thead>
    

                <tr>
                    <th class="whitespace-nowrap">No.</th>
                    <th class="whitespace-nowrap">Name</th>
                     <th class="whitespace-nowrap">Type</th>
                    <th class="whitespace-nowrap">Purpose</th>
                    <th class="whitespace-nowrap">No. of Copies</th>
                    <th class="whitespace-nowrap">Requested Date/Time</th>
                </tr>
            </thead>
 
            <tbody>
        @forelse($print_request_summary as $i =>$row)
                <tr>
                    <td class="text-left">{{ $i+1 }}</td>
                    <td>{{$row->get_student_fullname->fullname}}</td>
                     <td>{{$row->request_type}}</td>
                    <td>{{$row->purpose}}</td>
                    <td>{{$row->no_of_copies}}</td>
                    <td>{{$row->created_at}}</td>
                </tr>

            </tbody>
     
       @empty
            
             <p>No records found</p>

     </table>



       @endforelse

    </div>
    
    <footer style="bottom:0;position:fixed">
        <i style="margin-center: 61%; font-size:10px;">System Generated|Printed Date/Time:
            <?php 
                
                $date = date('M d, Y H:i:s A');
    
                echo $date ;
                
    
            ?></i>

        @if ($system_image_footer)
    
            <img   class = "scale-down" src = "uploads/settings/{{ $system_image_footer->image }}" style = "width:100%">
        @else
            <img   class = "scale-down" src = "" style = "width:100%">
        @endif
    </footer>
    
</body>
</html>
