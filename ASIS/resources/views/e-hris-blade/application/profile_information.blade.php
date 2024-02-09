<div id="applicants_form">
    <div class="font-medium text-base">Applicant's Profile Information</div>
    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
        <div class="intro-y col-span-12 sm:col-span-6">
            <label for="input-wizard-1" class="form-label">First Name</label>
            <input id="profile_first_name" type="text" class="form-control" placeholder="Juan" required>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6">
            <label for="input-wizard-2" class="form-label">Last Name</label>
            <input id="profile_last_name" type="text" class="form-control" placeholder="Dela Cruz" required>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6">
            <label for="input-wizard-2" class="form-label">Middle Name</label>
            <input id="profile_mid_name" type="text" class="form-control" placeholder="Dela Cruz" required>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6">
            <label for="input-wizard-2" class="form-label">Citizenship</label>
            <input id="profile_citizenship" type="text" class="form-control" placeholder="Filipino" required>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6">
            <label for="input-wizard-6" class="form-label">Gender</label>
            <select class=" w-full profile_sex" id="profile_sex" name="profile_sex">
                <option></option>
                @forelse (get_gender('') as $gender)
                    <option  value="{{ $gender->id }}">{{ $gender->gender }}</option>
                @empty
                @endforelse
            </select>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6">
            <label for="input-wizard-2" class="form-label">Date of Birth</label>
            <div class="relative w-auto mx-auto">
                <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400"> <i data-lucide="calendar" class="w-4 h-4"></i> </div>
                <input id="profile_date_birth" type="text" class="datepicker form-control pl-12 profile_date_birth" data-single-mode="true" required>
            </div>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6">
            <label for="input-wizard-2" class="form-label">Age</label>
            <input id="profile_age" type="number" class="form-control" required>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6">
            <label for="input-wizard-2" class="form-label">Contact Number</label>
            <input id="profile_contact_number" type="tel" class="form-control" placeholder="09...." required>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6">
            <label for="input-wizard-2" class="form-label">User Name</label>
            <input id="profile_user_name" type="text" class="form-control" placeholder="User Name"required>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6">
            <label for="input-wizard-2" class="form-label">Password</label>
            <input id="profile_pass" type="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6">
            <label for="input-wizard-2" class="form-label">Email</label>
            <input id="profile_email" type="email" class="form-control" placeholder="juan.delacruz@dssc.edu.ph" required>
        </div>
    </div>
</div>
