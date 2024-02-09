<!doctype html>
<html lang = "en">

    <title>Request Slip</title>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<style>
    @page {
            margin: 5px 25px 5px 25px !important;
            padding: 0px 0px 0px 0px !important;
        }

    table, tr, td{
        border: 0.5px solid black;
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


<body>
    <br><br>
<div class="overflow-x-auto">
    <div style="text-align: center; font-size: 14px; font-weight: bold;">
        <h2>Request Slip</h2>

    </div>


<br>

   

@forelse($printR as $i =>$row)
    <div class="myfont">
        <p>This is to certify that I, <strong>{{$row->get_student_fullname->fullname}}</strong>, <strong>{{$row->get_student_fullname->studmajor}}</strong> with ID Number <strong>{{$row->get_student_fullname->studid}}</strong>, from<strong>  {{$row->get_student_fullname->address}}</strong>, am hereby requesting the following:</p>
    </div>
  
      @empty
            
    <p>No records found</p>
@endforelse

<br>
       <table class="table table-bordered" id="leave_summary_table" style="width: 100%;">        
    <thead>
    

                <tr>
                    <th class="whitespace-nowrap">#</th>
                    <th class="whitespace-nowrap">Type</th>
                    <th class="whitespace-nowrap">Purpose</th>
                    <th class="whitespace-nowrap">No. of Copies</th>
                    <th class="whitespace-nowrap">Requested Date/Time</th>
                    <th class="whitespace-nowrap">Approved Date</th>
                     <th class="whitespace-nowrap">Status</th>
                </tr>
            </thead>
 
            <tbody>
        @forelse($printR as $i =>$row)
                <tr>
                    <td class="text-left">{{ $i+1 }}</td>
                    <td>{{$row->request_type}}</td>
                    <td>{{$row->purpose}}</td>
                    <td>{{$row->no_of_copies}}</td>
                    <td>{{ $row->created_at }}</td>
                    <td>{{$row->approvedate}}</td>
                    <td>{{$row->status}}</td>
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