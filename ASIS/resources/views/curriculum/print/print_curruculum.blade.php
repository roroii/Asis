<!DOCTYPE html>
<html>

<head>
  <title>CURRICULUM</title>

  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
    }

    h1 {
      font-size: 24px;
    }

    h2 {
      font-size: 18px;
    }

    h3 {
      font-size: 14px;
    }

    .intro-y {
      padding: 0.5rem;
    }

    .box {
      background-color: #fff;
      border-radius: 4px;
      box-shadow: 0 0.5px 1.5px rgba(0,0,0,0.12), 0 0.5px 1px rgba(0,0,0,0.24);
    }

    .border {
      border: 1px solid #e2e8f0;
    }

    .rounded-md {
      border-radius: 0.375rem;
    }

    .p-5 {
      padding: 0.5rem;
    }

    .mt-5 {
      margin-top: 0.5rem;
    }

    .text-base {
      font-size: 1rem;
    }

    .font-medium {
      font-weight: 500;
    }

    .flex {
      display: flex;
    }

    .items-center {
      align-items: center;
    }

    .border-b {
      border-bottom: 1px solid #e2e8f0;
    }

    .pb-5 {
      padding-bottom: 0.5rem;
    }

    .pt-5 {
      padding-top: 0.5rem;
    }

    .bg-slate-50 {
      /* background-color: #f8fafc; */
    }

   table {
        width: 100%;
        border-collapse: collapse;
        padding-top: 5px;
        padding-left: 5px;
    }
    th, td {
      padding: 4px;
      text-align: left;
      border: 1px solid #e2e8f0;
    }

  </style>

</head>

<body>

  <h2 style="text-align:center;">CURRICULUM</h2>

  <h3 style="text-align:center;">Bachelor of Science in Information Technology</h3>

  <h4 style="text-align:center;">2023-2024</h4>
  <!-- BEGIN: Transcript of Records -->

  <div class="intro-y box p-5 mt-5 year-container">
        @if ($curriculum)
            @forelse ($curriculum->schoolYears as $year => $yearData)
                <!-- BEGIN: Transcript of Records -->
                <div class="border border-slate-200/60 rounded-md p-5 mt-5 year-container">
                    <div class="font-medium text-base flex items-center border-b border-slate-200/60 pb-5">
                        <i class="w-4 h-4 mr-2 fa fa-arrow-alt-circle-down"></i>
                        <div id="curriculum_year_name_div">
                            {{ $yearData->name }}
                        </div>
                    </div>

                    <div class="mt-5">
                        @foreach ($yearData->semesters as $semester)
                            <div class="pt-5 sem-container">
                                <div class="form-label xl:w-64 xl:!mr-10">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium pl-2">
                                                {{ $semester->name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full mt-3 xl:mt-0 flex-1 bg-slate-50 rounded-md">
                                    <div class="overflow-x-auto">
                                        <table class="table border" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="bg-slate-50">Grade</th>
                                                    <th class="bg-slate-50">Course No.</th>
                                                    <th class="bg-slate-50">Descriptive Title</th>
                                                    <th class="bg-slate-50">Credits</th>
                                                    <th class="bg-slate-50">Lec</th>
                                                    <th class="bg-slate-50">Lab</th>
                                                    <th class="bg-slate-50">Pre-Requisite</th>
                                                    <th class="bg-slate-50">Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($semester->subjects as $record)
                                                    <tr>
                                                        <td class="!pr-2 {{ $record->grade !== null ? 'text-primary' : 'text-secondary' }}"><strong>{{ $record->grade ?? 'N/A' }}</strong></td>
                                                        <td class="whitespace-nowrap">{{ $record->subject_code }}</td>
                                                        <td class="!px-2">{{ $record->subject_description }}</td>
                                                        <td class="!px-2">{{ $record->subject_credits }}</td>
                                                        <td class="!px-2">{{ $record->subject_lec }}</td>
                                                        <td class="!px-2">{{ $record->subject_lab }}</td>
                                                        <td class="!px-2 pre-requisite_td">{{ $record->subject_prereq }}</td>
                                                        <td class="!px-2">{{ $record->remarks }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- END: Transcript of Records -->
            @empty
                <!-- Handle case where $curriculum->schoolYears is empty -->
            @endforelse
        @else
            <!-- Handle case where $curriculum is not set -->
        @endif
    </div>

  <!-- END: Transcript of Records -->

</body>
</html>
