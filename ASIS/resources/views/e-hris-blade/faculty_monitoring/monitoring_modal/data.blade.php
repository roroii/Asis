    <!-- Display your data -->
    @foreach ($data as $item)
        <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-3">
            <div class="box">
                <div class="p-5">
                    <div class="h-40 2xl:h-56 image-fit rounded-md overflow-hidden before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10">
                        <img alt="profile-picture" class="rounded-md" src="{{ get_profile_image($item->created_by) }}">
                        <span class="absolute top-0 bg-pending/80 text-white text-xs m-5 px-2 py-1 rounded z-10">Featured</span>
                        <div class="absolute bottom-0 text-white px-5 pb-6 z-10"> <a href="" class="block font-medium text-base">{{ $item->link_meeting }}</a> <span class="text-white/90 text-xs mt-3">{{ Str::title(fullname($item->created_by))  }}</span> </div>
                    </div>
                    <div class="text-slate-600 dark:text-slate-500 mt-5">
                        <div class="flex items-center"> <i data-lucide="link" class="w-4 h-4 mr-2"></i> Subject code: IT 221 </div>
                        <div class="flex items-center mt-2"> <i data-lucide="layers" class="w-4 h-4 mr-2"></i> Student: 12 </div>
                        <div class="flex items-center mt-2"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Status: Ongoing </div>
                    </div>
                </div>
                <div class="flex justify-center lg:justify-end items-center p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                    <a class="flex items-center text-primary mr-auto" href="javascript:;"> <i data-lucide="eye" class="w-4 h-4 mr-1"></i> Preview </a>
                    <a class="flex items-center mr-3" href="javascript:;"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                    <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Remove </a>
                </div>
            </div>
        </div>
    @endforeach
