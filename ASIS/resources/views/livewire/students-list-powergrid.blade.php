<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}

    <div class="overflow-x-auto">
        <table class="table table-report -mt-2">
            <thead>
            <tr>
                <th class="whitespace-nowrap">Signatory ID</th>
                <th class="whitespace-nowrap">Name</th>
                <th class="whitespace-nowrap">Designation</th>
                <th class="text-center whitespace-nowrap">STATUS</th>
                <th class="text-center whitespace-nowrap">ACTIONS</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($students as $student)

                <tr class="intro-x zoom-in px-2">
                    <td class="w-40 !py-4"> <a href="javascript:;" class="underline decoration-dotted whitespace-nowrap">{{ $student['student_id'] }}</a> </td>
                    <td class="w-40">
                        <a href="javascript:;" class="font-medium whitespace-nowrap">{{ $student['full_name'] }}</a>
                    </td>

                    <td class="text-center">
                        <div class="flex whitespace-nowrap"
                             x-data="{ editing: false, newDesignation: '' }"
                             x-init="$watch('editing', value => value && $nextTick(() => $refs.input.focus()))"
                             x-on:click.prevent="editing = !editing; $refs.input.focus()"
                             wire:key="{{ $student['student_id'] }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="edit-3" data-lucide="edit-3" class="lucide lucide-edit-3 w-4 h-4 mr-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>

                            <a href="javascript:;" class="font-medium whitespace-nowrap">
                                <span x-show="!editing" class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ $student['designation'] }}</span>
                                <input x-ref="input"
                                       x-show="editing"
                                       type="text"
                                       placeholder="Add Designation"
                                       x-model="newDesignation"
                                       @keydown.enter="() => { $wire.updateDesignation('{{ $student['student_id'] }}', newDesignation); editing = false; $refs.input.blur(); }"
                                       class="border p-1 form-control box">
                            </a>
                        </div>

                    </td>

                    <td class="text-center">
                        <div class="flex items-center justify-center whitespace-nowrap text-success"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="check-square" data-lucide="check-square" class="lucide lucide-check-square w-4 h-4 mr-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path></svg> {{ $student['status'] }}</div>
                    </td>
                    <td class="table-report__action w-56">
                        <div class="flex justify-center items-center">
                            <a class="flex items-center mr-3" href="javascript:;"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="check-square" data-lucide="check-square" class="lucide lucide-check-square w-4 h-4 mr-1"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path></svg> Edit </a>

                            <a class="flex items-center text-danger" href="javascript:;" wire:click.prevent="deleteSignatory('{{ $student['student_id'] }}')">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash-2" data-lucide="trash-2" class="lucide lucide-trash-2 w-4 h-4 mr-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Delete </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
