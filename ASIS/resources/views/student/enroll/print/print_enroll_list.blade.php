<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $filename }}</title>
    <!-- Include Tailwind CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Additional CSS styles to float footer to the bottom */
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="information">
        <table class="text-xs"> <!-- Add the 'text-xs' class to adjust the font size -->
            <tr style="text-align: justify">
                <td><img src="uploads/settings/1_theG1686012355.png" width="100px" alt=""></td>
                <td>
                    {{-- <div class="font-bold text-sm">Republic of the Philippines</div> <!-- Add the 'text-sm' class to adjust the font size --> --}}
                    {{-- <div class="font-bold text-sm">DSSC</div> <!-- Add the 'text-sm' class to adjust the font size --> --}}
                    <div class="font-bold text-sm">DAVAO DEL SUR STATE COLLEGE</div> <!-- Add the 'text-sm' class to adjust the font size -->
                    <div class="text-sm">Matti, Digos City, Davao del Sur</div> <!-- Add the 'text-sm' class to adjust the font size -->
                    {{-- <div class="text-sm">Telephone No.</div> <!-- Add the 'text-sm' class to adjust the font size --> --}}
                    {{-- <div class="text-sm">E-mail</div> <!-- Add the 'text-sm' class to adjust the font size --> --}}
                </td>
            </tr>
        </table>
    </div>

    <main class="mt-10">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold">Enrollment Roll</h1>
        </div>
        <h3 class="text-xs font-bold"></h3>
        <ul class="list-disc ml-6 text-xs">
            @if($filterYear)
                <li>Year: {{ $filterYear }}</li>
            @endif

            @if($filterSem)
                <li>Sem: {{ $filterSem }}</li>
            @endif

            @if($filterYearLevel)
                <li>Year Level: {{ $filterYearLevel }}</li>
            @endif

            @if($filterProgram)
                <li>Course/Program: {{ $filterProgram }}</li>
            @endif
        </ul>
        <br>
        <div class="w-full mb-4">
            <table class="w-full table-auto border-collapse text-xs">
            <thead>
                <tr>
                    <th class="border px-1 py-1">#</th>
                    <th class="border px-1 py-1">ID</th>
                    <th class="border px-1 py-1">Full Name</th>
                    <th class="border px-1 py-1">Course/Program</th>
                    <th class="border px-1 py-1">Section</th>
                    <th class="border px-1 py-1">Current Year Level</th>
                    <th class="border px-1 py-1">Contact Number</th>
                    <th class="border px-1 py-1">Date Submitted</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($enrollListData as $i => $enrollee)
                    <tr>
                        <td class="border px-1 py-1">{{ $i + 1 }}</td>
                        <td class="border px-1 py-1">{{ $enrollee->studid }}</td>
                        <td class="border px-1 py-1">{{ $enrollee->fullname }}</td>
                        <td class="border px-1 py-1">{{ $enrollee->studmajor }}</td>
                        <td class="border px-1 py-1">{{ $enrollee->section }}</td>
                        <td class="border px-1 py-1">{{ $enrollee->year_level }}</td>
                        <td class="border px-1 py-1">{{ $enrollee->number }}</td>
                        <td class="border px-1 py-1">{{ $enrollee->created_at->format('F j, Y h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-2">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </main>

    <footer class="text-center mt-10 text-sm">
        (DSSC-Portal) generated report: <strong>{{ $current_date }}</strong>
    </footer>
</body>
</html>
