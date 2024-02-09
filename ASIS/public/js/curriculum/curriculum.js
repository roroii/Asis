let yearCounter = 0;
let semesterTableIdGlobal = "";

let semesterUniqueIdGlobal_PR = "";
let semesterTableIdGlobal_PR = "";

function addYearTable() {
    // Get the value from the input field
    var yearName = document.getElementById("curriculum_year-name").value;

    // Create a unique year container ID
    const yearContainerId = `year-container-${yearCounter}`;

    // Create a container div for the year with the unique ID
    var yearContainerDiv = document.createElement("div");
    yearContainerDiv.id = yearContainerId;
    yearContainerDiv.classList.add("col-span-12", "sm:col-span-12");

    // Create a unique ID for the SyDiv
    const schoolYearDivId = `sy-div-${yearContainerId}-${yearCounter++}`;
    const yearNameInputId = `year-name-input-${yearContainerId}-${yearCounter}`;

    yearContainerDiv.innerHTML = `
        <div class="intro-y box p-5 mt-5 year-container" data-semester-div-id="${schoolYearDivId}" id="${schoolYearDivId}">
            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                    <i data-lucide="chevron-down" class="w-4 h-4 mr-2"></i> <div id="curriculum_year_name_div">
                        <input type="text" id="${yearNameInputId}" name="${yearNameInputId}" class="form-control year-name-input-div" placeholder="E.g. First Year" value="${yearName}">
                    </div>
                    <a href="javascript:void(0);" class="text-danger ml-2"
                        data-year-container-id="${yearContainerId}"
                        data-school-year-div-id="${schoolYearDivId}"
                        onclick="removeSchoolYear(this)"> <i class="fa fa-trash w-4 h-4"></i> </a>
                </div>

                <div class="mt-5">
                    <div class="mt-5" id="semester-container-${yearContainerId}">
                        <!-- Add your semester content here -->
                    </div>
                    <div class="mb-2 mt-2 pt-2 first:mt-0 first:pt-0 w-full">
                        <button class="btn py-3 btn-outline-secondary border-dashed w-full" onclick="addSemester('${yearContainerId}')">
                            <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Semester
                        </button>
                    </div>
                </div>
            </div>
        </div>
        `;

    // Append the year container to the modal or wherever you want it
    var modalContent = document.getElementById("modal-content");
    modalContent.appendChild(yearContainerDiv);

    yearCounter++; // Increment the year counter for the next iteration
}

function addSemester(yearContainerId) {
    // Create a new semester structure div
    var semesterDiv = document.createElement("div");

    // Create a unique semester table ID
    const semesterTableId = `semester-table-${yearContainerId}-${yearCounter++}`;

    // Create unique IDs for the input and delete button
    const semesterNameInputId = `semester-name-input-${yearContainerId}-${yearCounter}`;
    const deleteButtonId = `delete-button-${yearContainerId}-${yearCounter}`;

    // Create a unique ID for the semesterDiv
    const semesterDivId = `semester-div-${yearContainerId}-${yearCounter++}`;

    semesterDiv.innerHTML = `
            <div class="pt-5 sem-container" data-semester-div-id="${semesterDivId}" id="${semesterDivId}">
                <div class="form-label xl:w-64 xl:!mr-10">
                    <div class="text-left">
                        <div class="flex items-center">
                            <div class="font-medium">
                                <input type="text" id="${semesterNameInputId}" name="${semesterNameInputId}" class="form-control semester-name-input-div" placeholder="E.g. Semester">
                            </div>
                            <a href="javascript:void(0);" class="text-danger ml-2"
                                data-year-container-id="${yearContainerId}"
                                data-semester-table-id="${semesterTableId}"
                                data-semester-div-id="${semesterDivId}"
                                onclick="removeSemester(this)"> <i class="fa fa-trash w-4 h-4"></i> </a>
                        </div>
                    </div>
                </div>
                <div class="w-full mt-3 xl:mt-0 flex-1 bg-slate-50 dark:bg-transparent dark:border rounded-md">
                    <div class="overflow-x-auto">
                        <table id="${semesterTableId}" class="table border">
                            <thead>
                                <tr>
                                    <th class=" bg-slate-50 dark:bg-darkmode-800" style="width: 5%;">Grade</th>
                                    <th class="bg-slate-50 dark:bg-darkmode-800" style="width: 5%;">Course No.</th>
                                    <th class="bg-slate-50 dark:bg-darkmode-800 text-slate-500 whitespace-nowrap">Descriptive Title</th>
                                    <th class="bg-slate-50 dark:bg-darkmode-800 text-slate-500 whitespace-nowrap" >Credits</th>
                                    <th class=" bg-slate-50 dark:bg-darkmode-800 text-slate-500 whitespace-nowrap" >Lecture</th>
                                    <th class=" bg-slate-50 dark:bg-darkmode-800 text-slate-500 whitespace-nowrap" >Laboratory</th>
                                    <th class=" bg-slate-50 dark:bg-darkmode-800 text-slate-500 whitespace-nowrap" >Pre-Requisite</th>
                                    <th class=" bg-slate-50 dark:bg-darkmode-800 text-slate-500 whitespace-nowrap" >Remarks</th>
                                    <th class=" bg-slate-50 dark:bg-darkmode-800" style="width: 5%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Add your subject rows here -->
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-outline-primary border-dashed w-full mt-4"
                    data-semester-table-id="${semesterTableId}"
                    onclick="addDetailsToModalSubject(this)"

                    data-tw-toggle="modal" data-tw-target="#next-overlapping-modal-add-subject"
                    >
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Subject
                    </button>
                </div>
            </div>
        `;

    // Append the semester structure to the semester-container within the specified year container
    var semesterContainer = document.getElementById(
        `semester-container-${yearContainerId}`
    );
    semesterContainer.appendChild(semesterDiv);
}

function addDetailsToModalSubject(button) {
    // Create a new subject row
    semesterTableIdGlobal = button.getAttribute("data-semester-table-id");
    semesterUniqueIdGlobal_PR = "";
    semesterTableIdGlobal_PR = "";
    populateTable();
}

function addSubject(button) {
    // Create a new subject row
    var subjectRow = document.createElement("tr");
    const subjectCode = button.getAttribute("data-subject-table-subjcode");
    const subjectDesc = button.getAttribute("data-subject-table-desc");
    const subjectCredit = button.getAttribute("data-subject-table-subjcredit");
    const subjectLec = button.getAttribute("data-subject-table-subjlec");
    const subjectLab = button.getAttribute("data-subject-table-subjlab");

    // Check if semesterUniqueIdGlobal_PR and semesterTableIdGlobal_PR exist
    if (semesterUniqueIdGlobal_PR && semesterTableIdGlobal_PR) {
        // Find the specific table with semesterTableIdGlobal_PR
        var semesterTable = document.getElementById(semesterTableIdGlobal_PR);

        // Find the specific row with semesterUniqueIdGlobal_PR
        var subjectRow = semesterTable.querySelector(
            `tr[data-unique-id="${semesterUniqueIdGlobal_PR}"]`
        );

        var preReqTd = subjectRow.querySelector(".pre-requisite_td");
        if (preReqTd) {
            // Add text to the 'pre-requisite-span' within this specific row
            var preReqSpan = preReqTd.querySelector("#pre-requisite-span");
            if (preReqSpan) {
                preReqSpan.textContent += subjectCode + ", "; // Set the text of the span
            }
        }
        removeSubject(button);
    } else {
        // Add subject row content
        subjectRow.innerHTML = `
            <td class="!pr-2"></td>
            <td class="whitespace-nowrap"><input disabled id="subject-modal-course-no" type="text" class="form-control" placeholder="Course No." style="width:150px" value="${subjectCode}"></td>
            <td class="!px-2"><input id="subject-modal-description" type="text" class="form-control" placeholder="Description" style="width:300px" value="${subjectDesc}"></td>
            <td class="!px-2"><input id="subject-modal-credits" type="text" class="form-control" placeholder="Credits" value="${subjectCredit}"></td>
            <td class="!px-2"><input id="subject-modal-lecture" type="text" class="form-control" placeholder="Lecture" value="${subjectLec}"> </td>
            <td class="!px-2"><input id="subject-modal-laboratory" type="text" class="form-control" placeholder="Laboratory" value="${subjectLab}"> </td>
            <td class="!px-2 pre-requisite_td">
                <button class="btn btn-link subject-code-button text-sm px-2 py-1" data-tw-toggle="modal" data-tw-target="#next-overlapping-modal-add-subject" onclick="addPrerequisite('${subjectCode}', this)">Add</button>
                <button class="btn btn-link clear-button text-sm px-2 py-1" onclick="clearPreRequisites(this)">Clear</button>
                <span id="pre-requisite-span" class="inline-block pre-requisite-span"></span>
            </td>
            <td class="!px-2"><input id="subject-modal-remarks" type="text" class="form-control" placeholder="Remarks"> </td>
            <td class="!px-2"> <a href="javascript:;" onclick="removeSubject(this)"> <i class="fa fa-trash w-4 h-4"></i> </a> </td>
        `;

        // Append the subject row to the specified semester table
        var semesterTable = document.getElementById(semesterTableIdGlobal);
        var subjectTableBody = semesterTable.querySelector("tbody");

        var rowCount = semesterTable.querySelectorAll("tr").length;

        var uniqueId =
            subjectCode +
            "_" +
            semesterTableIdGlobal +
            "_" +
            new Date().getTime() +
            "_" +
            rowCount;
        subjectRow.setAttribute("data-unique-id", uniqueId);
        subjectRow.setAttribute("data-table-id", semesterTableIdGlobal);

        subjectTableBody.appendChild(subjectRow);

        removeSubject(button);
    }
}

function clearPreRequisites(button) {
    // Find the nearest <td> element containing the <span> to clear
    const td = button.closest(".pre-requisite_td");

    if (td) {
        // Find the <span> element within the <td> and clear its text
        const preReqSpan = td.querySelector(".pre-requisite-span");
        if (preReqSpan) {
            preReqSpan.textContent = "";
        }
    }
}
// Define a global array to store prerequisite subject codes
let prerequisiteSubjects = [];

// Function to add a subject code to the prerequisite array
function addPrerequisite(subjectCode, button) {
    // Get the parent element of the button, which is the subjectRow
    var subjectRow = button.parentElement.parentElement;

    // Get the attributes data-unique-id and data-table-id from the subjectRow
    semesterUniqueIdGlobal_PR = subjectRow.getAttribute("data-unique-id");
    semesterTableIdGlobal_PR = subjectRow.getAttribute("data-table-id");


    // Now you can use these values in your function
    console.log("Subject Code:", subjectCode);
    console.log("Unique ID:", semesterUniqueIdGlobal_PR);
    console.log("Table ID:", semesterTableIdGlobal_PR);
}

function removeSubject(row) {
    var subjectTable = row.closest("table");
    var subjectRow = row.closest("tr");
    subjectTable.querySelector("tbody").removeChild(subjectRow);
    var token = $('meta[name="csrf-token"]').attr("content");

    $.ajax({
        url: "curriculum/remove-subject-endpoint", // Update this to match your server-side route
        type: "POST",
        data: {
            subjectTable: subjectTable,
            subjectRow: subjectRow,
            subjectTable: subjectTable,
        },
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": token,
        },
        success: function (response) {
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.log("Error Status Code:", xhr.status);
            console.log("Error Status Text:", xhr.statusText);
            console.log("Error Response Text:", xhr.responseText);
            console.log("Error:", error);
        },
    });
}

function removeSemester(button) {
    const yearContainerId = button.getAttribute("data-year-container-id");
    const semesterTableId = button.getAttribute("data-semester-table-id");
    const semesterDivId = button.getAttribute("data-semester-div-id");
    const semesterDiv = document.getElementById(semesterDivId);
    var token = $('meta[name="csrf-token"]').attr("content");

    if (semesterDiv) {
        semesterDiv.remove();
    }

    $.ajax({
        url: "curriculum/remove-semester-endpoint", // Update this to match your server-side route
        type: "POST",
        data: {
            yearContainerId: yearContainerId,
            semesterTableId: semesterTableId,
            semesterDivId: semesterDivId,
        },
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": token,
        },
        success: function (response) {
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.log("Error Status Code:", xhr.status);
            console.log("Error Status Text:", xhr.statusText);
            console.log("Error Response Text:", xhr.responseText);
            console.log("Error:", error);
        },
    });
}

// Remove a school year
function removeSchoolYear(button) {
    var yearContainerId = button.getAttribute('data-year-container-id');
    var schoolYearDivId = button.getAttribute('data-school-year-div-id');
    var token = $('meta[name="csrf-token"]').attr("content");

    $("#" + schoolYearDivId).remove();

    $.ajax({
        url: "curriculum/remove-sy-endpoint", // Your server-side route to handle this request
        type: "POST",
        data: {
            year_container_id: yearContainerId,
            school_year_div_id: schoolYearDivId,
        },
        headers: {
            "X-CSRF-TOKEN": token,
        },
        success: function (response) {
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.log("Error Status Code:", xhr.status);
            console.log("Error Status Text:", xhr.statusText);
            console.log("Error Response Text:", xhr.responseText);
            console.log("Error:", error);
        },
    });
}

// Add event listeners to the dropdowns
const schoolYearDropdown = document.getElementById("subject-modal-school-year");
const semesterDropdown = document.getElementById("subject-modal-semester");
const collegeDropdown = document.getElementById("subject-modal-college");
const departmentDropdown = document.getElementById("subject-modal-department");
const tableBody = document.querySelector("#subject-modal-table tbody");

schoolYearDropdown.addEventListener("change", populateTable);
semesterDropdown.addEventListener("change", populateTable);
collegeDropdown.addEventListener("change", populateTable);
departmentDropdown.addEventListener("change", populateTable);

// Function to populate the table based on selected values
function populateTable() {
    const selectedSchoolYear = schoolYearDropdown.value;
    const selectedSemester = semesterDropdown.value;
    const selectedCollege = collegeDropdown.value;
    const selectedDepartment = departmentDropdown.value;

    // Define the filters object
    const filters = {
        selectedSchoolYear: selectedSchoolYear,
        selectedSemester: selectedSemester,
        selectedCollege: selectedCollege,
        selectedDepartment: selectedDepartment,
    };

    // Clear the existing table content
    tableBody.innerHTML = "";

    // Construct the URL with query parameters
    const url = `/curriculum/load-subjects?selectedSchoolYear=${selectedSchoolYear}&selectedSemester=${selectedSemester}&selectedCollege=${selectedCollege}&selectedDepartment=${selectedDepartment}`;

    // Make an AJAX request using vanilla JavaScript
    fetch(url)
        .then((response) => response.json())
        .then((data) => {
            // console.log(data);

            // Clear the existing table content
            tableBody.innerHTML = "";

            // Iterate through the received data
            data.forEach((subject) => {
                // console.log(subject.subjcode);

                const rowHtml = `
                        <tr>
                            <td>${subject.subjcode}</td>
                            <td>${subject.subject.subjdesc}</td> <!-- Include the subject description here -->
                            <td>
                                <a href="javascript:void(0);" class="text-primary ml-2" onclick="addSubject(this)"
                                data-subject-table-subjcode="${subject.subjcode}"
                                data-subject-table-desc="${subject.subject.subjdesc}"
                                data-subject-table-subjcredit="${subject.subject.subjcredit}"
                                data-subject-table-subjlec="${subject.subject.subjlec_units}"
                                data-subject-table-subjlab="${subject.subject.subjlab_units}"

                                > <!-- Pass the subject description -->
                                    <i class="fa fa-plus w-4 h-4"></i>
                                </a>
                            </td>
                        </tr>
                    `;

                tableBody.insertAdjacentHTML("beforeend", rowHtml);
            });
        })
        .catch((error) => {
            console.error(error);
        });
}

// Function to handle the action when the button is clicked
function handleAction(button) {
    const subjectCode = button.getAttribute("data-subject");
    // Implement your action here
    alert(`Action clicked for subject: ${subjectCode}`);
}

// Select the Save button
const saveBtn = document.getElementById("save_curriculumn");

// Add click event handler
saveBtn.addEventListener("click", () => {
    // Get curriculum data
    const curriculumData = getCurriculumData();
    fetchCurriculumData();
    // Call the saveCurriculum function to send data to the server
    saveCurriculum(curriculumData);

});

// Extract curriculum data from DOM
function getCurriculumData() {
    const data = {
        name: document.getElementById("curriculum_name").value,
        degree: document.getElementById("degree_program").value,
        description: document.getElementById("curriculum_description").value,
        sy: document.getElementById("modal_sy").value,
        major: document.getElementById("modal_major").value,
        year_name: document.getElementById("curriculum_year-name").value,
        curriculum_id: document.getElementById("curriculum_id").value,
        college: document.getElementById("college_program").value,

        // ... extract other fields

        years: [],
    };

    // Loop through year containers
    const yearContainers = document.querySelectorAll(".year-container");

    yearContainers.forEach((container) => {
 
        const yearNameDiv = container.querySelector(
            ".font-medium input.year-name-input-div"
        );
        const yearName = yearNameDiv.value;
        const yearId = yearNameDiv.dataset.yearId;

        // Get semesters within the container
        const semesters = [];

        const semesterContainers = container.querySelectorAll(".sem-container");

        semesterContainers.forEach((semesterContainer) => {
            // Extract semester name within the container
            const semNameInput = semesterContainer.querySelector(
                ".font-medium input.semester-name-input-div"
            );
            const semName = semNameInput.value;
            const semId = semNameInput.dataset.semId;

            // Extract subjects
            const subjects = [];

            const rows = semesterContainer.querySelectorAll("table tr");

            rows.forEach((row) => {
                const cells = row.cells;

                // Ensure that the row has at least 8 cells (Credits, Lec, Lab, Pre-Requisite, Remarks, code, name, Remarks)
                if (cells.length >= 8) {
                    const creditsCell = cells[3].querySelector("input"); // Assuming the input is in the fourth cell
                    const lecCell = cells[4].querySelector("input"); // Assuming the input is in the fifth cell
                    const labCell = cells[5].querySelector("input"); // Assuming the input is in the sixth cell
                    const prereqCell = cells[6]; // The pre-requisite cell (no input)
                    const codeCell = cells[1].querySelector("input"); // Assuming the input is in the second cell
                    const nameCell = cells[2].querySelector("input"); // Assuming the input is in the third cell
                    const remCell = cells[7].querySelector("input"); // Assuming the input is in the eighth cell

                    // Assuming there is a span with class "pre-requisite-span" inside prereqCell
                    const preReqSpan = prereqCell.querySelector('.pre-requisite-span');
                    const prereqText = preReqSpan ? preReqSpan.innerText.trim() : '';

                    if (
                        creditsCell &&
                        lecCell &&
                        labCell &&
                        prereqCell && // Ensure the pre-requisite cell exists
                        codeCell &&
                        nameCell &&
                        remCell
                    ) {
                        const subjectId = row.dataset.subjectId;

                        const subject = {
                            subjectId: subjectId, // Add the subjectId to your subject object
                            code: codeCell.value.trim(),
                            name: nameCell.value.trim(),
                            credits: creditsCell.value.trim(),
                            lec: lecCell.value.trim(),
                            lab: labCell.value.trim(),
                            prereq: prereqText, // Use innerText to get only the text content
                            remarks: remCell.value.trim(),
                        };

                        subjects.push(subject);
                    }
                }
            });

            semesters.push({
                id: semId,
                name: semName,
                subjects,
            });
        });

        data.years.push({
            id: yearId,
            name: yearName,
            semesters,
        });
    });

    return data;
}

// Define the saveCurriculum function
function saveCurriculum(data) {
    var _token = $('meta[name="csrf-token"]').attr("content");

    // Include the CSRF token in the data
    data._token = _token;

    $.ajax({
        url: "/curriculum/save-curriculum",
        type: "POST",
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": _token,
        },
        data: JSON.stringify(data),
        success: function (jsonResponse) {
            console.log("Curriculum saved!", jsonResponse);
            // Replace the standard alert with a SweetAlert
            Swal.fire({
                icon: "success",
                title: "Success",
                text: "Curriculum saved successfully!",
            });
        },
        error: function (error) {
            console.error("Error saving curriculum", error);
            // Replace the standard alert with a SweetAlert
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error saving curriculum",
            });
        },
    });
}

populateTable();



function updateCurriculum(button) {
    var curriculum_id = button.getAttribute("data-curriculum-id");
    var _token = $('meta[name="csrf-token"]').attr("content");
    console.log(curriculum_id);
    $.ajax({
        url: "curriculum/load-curriculum-update",
        type: "POST",
        data: {
            curriculum_id: curriculum_id,
        },
        headers: {
            "X-CSRF-TOKEN": _token,
        },
        success: function (response) {
            console.log(response);
            const curriculum = response.curriculum;

            // Set values in your HTML
            document.getElementById("curriculum_name").value = curriculum.name;
            document.getElementById("degree_program").value = curriculum.degree;
            document.getElementById("curriculum_description").value = curriculum.description;
            document.getElementById("modal_sy").value = curriculum.sy;
            document.getElementById("curriculum_year-name").value = curriculum.year_name;
            document.getElementById("curriculum_id").value = curriculum.id;
            document.getElementById("modal_major").value = curriculum.major;
            document.getElementById("college_program").value = curriculum.college;

            var modalContent = document.getElementById("modal-content");
            modalContent.innerHTML = "";

            curriculum.school_years.forEach(function (year) {
                // Handle each school year
                addAllYearTableDatabase(year);
            });
        },
        error: function (xhr, status, error) {
            console.log("Error Status Code:", xhr.status);
            console.log("Error Status Text:", xhr.statusText);
            console.log("Error Response Text:", xhr.responseText);
            console.log("Error:", error);
        },
    });
}

function addAllYearTableDatabase(year) {
    // Get the value from the input field
    var yearName = year.name; // Use the appropriate field from your data
    var yearId = year.id; 

    // Create a unique year container ID
    const yearContainerId = `year-container-${yearCounter}`;

    // Create a container div for the year with the unique ID
    var yearContainerDiv = document.createElement("div");
    yearContainerDiv.id = yearContainerId;
    yearContainerDiv.classList.add("col-span-12", "sm:col-span-12");

    // Create a unique ID for the SyDiv
    const schoolYearDivId = `sy-div-${yearContainerId}-${yearCounter++}`;
    const yearNameInputId = `year-name-input-${yearContainerId}-${yearCounter}`;

    yearContainerDiv.innerHTML = `
        <div class="intro-y box p-5 mt-5 year-container" data-semester-div-id="${schoolYearDivId}" id="${schoolYearDivId}">
            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                    <i data-lucide="chevron-down" class="w-4 h-4 mr-2"></i> <div id="curriculum_year_name_div">
                    <input type="text" id="${yearNameInputId}" name="${yearNameInputId}" data-year-id="${yearId}" class="form-control year-name-input-div" placeholder="E.g. First Year" value="${yearName}">
                    </div>
                    <a href="javascript:void(0);" class="text-danger ml-2"
                        data-year-container-id="${yearContainerId}"
                        data-school-year-div-id="${schoolYearDivId}"
                        onclick="removeSchoolYear(this)"> <i class="fa fa-trash w-4 h-4"></i> </a>
                </div>

                <div class="mt-5">
                    <div class="mt-5" id="semester-container-${yearContainerId}">
                        <!-- Add your semester content here -->
                    </div>
                    <div class="mb-2 mt-2 pt-2 first:mt-0 first:pt-0 w-full">
                        <button class="btn py-3 btn-outline-secondary border-dashed w-full" onclick="addSemester('${yearContainerId}')">
                            <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Semester
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Append the year container to the modal or wherever you want it
    var modalContent = document.getElementById("modal-content");
    modalContent.appendChild(yearContainerDiv);

    yearCounter++; // Increment the year counter for the next iteration

     year.semesters.forEach(function (semester) {
                    // Handle each semester within the school year

                    addAllSemesterDatabase(yearContainerId,semester)


                });
}

function addAllSemesterDatabase(yearContainerId, semester) {
    // Create a new semester structure div
    var semesterDiv = document.createElement("div");

    // Create a unique semester table ID
    const semesterTableId = `semester-table-${yearContainerId}-${yearCounter++}`;

    // Create unique IDs for the input and delete button
    const semesterNameInputId = `semester-name-input-${yearContainerId}-${yearCounter}`;
    const deleteButtonId = `delete-button-${yearContainerId}-${yearCounter}`;

    // Create a unique ID for the semesterDiv
    const semesterDivId = `semester-div-${yearContainerId}-${yearCounter++}`;

    semesterDiv.innerHTML = `
            <div class="pt-5 sem-container" data-semester-div-id="${semesterDivId}" id="${semesterDivId}">
                <div class="form-label xl:w-64 xl:!mr-10">
                    <div class="text-left">
                        <div class="flex items-center">
                            <div class="font-medium">
                                <input type="text" id="${semesterNameInputId}" name="${semesterNameInputId}" data-sem-id="${semester.id}" class="form-control semester-name-input-div" placeholder="E.g. Semester" value="${semester.name}">
                            </div>
                            <a href="javascript:void(0);" class="text-danger ml-2"
                                data-year-container-id="${yearContainerId}"
                                data-semester-table-id="${semesterTableId}"
                                data-semester-div-id="${semesterDivId}"
                                onclick="removeSemester(this)"> <i class="fa fa-trash w-4 h-4"></i> </a>
                        </div>
                    </div>
                </div>
                <div class="w-full mt-3 xl:mt-0 flex-1 bg-slate-50 dark:bg-transparent dark:border rounded-md">
                    <div class="overflow-x-auto">
                        <table id="${semesterTableId}" class="table border">
                            <thead>
                                <tr>
                                    <th class=" bg-slate-50 dark:bg-darkmode-800" style="width: 5%;">Grade</th>
                                    <th class="bg-slate-50 dark:bg-darkmode-800" style="width: 5%;">Course No.</th>
                                    <th class="bg-slate-50 dark:bg-darkmode-800 text-slate-500 whitespace-nowrap">Descriptive Title</th>
                                    <th class="bg-slate-50 dark:bg-darkmode-800 text-slate-500 whitespace-nowrap" >Credits</th>
                                    <th class=" bg-slate-50 dark:bg-darkmode-800 text-slate-500 whitespace-nowrap" >Lecture</th>
                                    <th class=" bg-slate-50 dark:bg-darkmode-800 text-slate-500 whitespace-nowrap" >Laboratory</th>
                                    <th class=" bg-slate-50 dark:bg-darkmode-800 text-slate-500 whitespace-nowrap" >Pre-Requisite</th>
                                    <th class=" bg-slate-50 dark:bg-darkmode-800 text-slate-500 whitespace-nowrap" >Remarks</th>
                                    <th class=" bg-slate-50 dark:bg-darkmode-800" style="width: 5%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Add your subject rows here -->
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-outline-primary border-dashed w-full mt-4"
                    data-semester-table-id="${semesterTableId}"
                    onclick="addDetailsToModalSubject(this)"

                    data-tw-toggle="modal" data-tw-target="#next-overlapping-modal-add-subject"
                    >
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Subject
                    </button>
                </div>
            </div>
        `;

    // Append the semester structure to the semester-container within the specified year container
    var semesterContainer = document.getElementById(
        `semester-container-${yearContainerId}`
    );
    semesterContainer.appendChild(semesterDiv);

    semester.subjects.forEach(function (subject) {
                        // Handle each subject within the semester
                        console.log("Subject Name:", subject.id);

                        addAllSubjectDatabase(subject,semesterTableId)
                    });
}

function addAllSubjectDatabase(subject, semesterTableId) {
    // Get the subject data
    const subjectId = subject.id || '';
    const subjectCode = subject.subject_code || '';
    const subjectDesc = subject.subject_description || '';
    const subjectCredit = subject.subject_credits || '';
    const subjectLec = subject.subject_lec || '';
    const subjectLab = subject.subject_lab || '';
    const subjectPrereq = subject.subject_prereq || '';

    // Find the specific table with the provided semesterTableId
    var semesterTable = document.getElementById(semesterTableId);

    if (semesterTable) {
        // Create a new subject row
        var subjectRow = document.createElement("tr");

        // Add subject row content
        subjectRow.innerHTML = `
            <td class="!pr-2"></td>
            <td class="whitespace-nowrap"><input disabled id="subject-modal-course-no" type="text" class="form-control" style="width:150px" placeholder="Course No." value="${subjectCode}"></td>
            <td class="!px-2"><input id="subject-modal-description" type="text" class="form-control" placeholder="Description" style="width:300px" value="${subjectDesc}"></td>
            <td class="!px-2"><input id="subject-modal-credits" type="text" class="form-control" placeholder="Credits" value="${subjectCredit}"></td>
            <td class="!px-2"><input id="subject-modal-lecture" type="text" class="form-control" placeholder="Lecture" value="${subjectLec}"> </td>
            <td class="!px-2"><input id="subject-modal-laboratory" type="text" class="form-control" placeholder="Laboratory" value="${subjectLab}"> </td>
            <td class="!px-2 pre-requisite_td">
                <button class="btn btn-link subject-code-button text-sm px-2 py-1 " data-tw-toggle="modal" data-tw-target="#next-overlapping-modal-add-subject" onclick="addPrerequisite('${subjectCode}', this)">Add</button>
                <button class="btn btn-link clear-button text-sm px-2 py-1" onclick="clearPreRequisites(this)">Clear</button>
                <span id="pre-requisite-span" class="inline-block pre-requisite-span pt-3 text-primary">${subjectPrereq}</span>
            </td>
            <td class="!px-2"><input id="subject-modal-remarks" type="text" class="form-control" placeholder="Remarks"> </td>
            <td class="!px-2"> <a href="javascript:;" onclick="removeSubject(this)"> <i class="fa fa-trash w-4 h-4"></i> </a> </td>
        `;

        // Append the subject row to the specified semester table
        var subjectTableBody = semesterTable.querySelector("tbody");
        subjectTableBody.appendChild(subjectRow);

        // Append the subject row to the specified semester table
        var semesterTable = document.getElementById(semesterTableId);
        var subjectTableBody = semesterTable.querySelector("tbody");

        var rowCount = semesterTable.querySelectorAll("tr").length;

        var uniqueId =
            subjectCode +
            "_" +
            semesterTableId +
            "_" +
            new Date().getTime() +
            "_" +
            rowCount;
        subjectRow.setAttribute("data-unique-id", uniqueId);
        subjectRow.setAttribute("data-table-id", semesterTableId);
        subjectRow.setAttribute("data-subject-id", subjectId);

        subjectTableBody.appendChild(subjectRow);
    } else {
        console.log("Table with ID '" + semesterTableId + "' not found.");
    }
}

// document.addEventListener("DOMContentLoaded", function () {
//     document.addEventListener("click", function (event) {
//         if (event.target.classList.contains("pre-requisite-span")) {
//             if (event.target.childNodes[0].nodeType === 3) {
//                 const currentText = event.target.childNodes[0].textContent.trim();

//                 // Split the text by commas
//                 const parts = currentText.split(',');

//                 // Remove the last part (after the last comma)
//                 parts.pop();

//                 // Join the remaining parts with commas
//                 const newText = parts.join(',');

//                 // Update the span content
//                 event.target.childNodes[0].textContent = newText.trim();
//             }
//         }
//     });
// });

// Add an event listener to the button
document.getElementById("clearModalButton").addEventListener("click", function() {
    // Clear the values of the modal fields
    document.getElementById("curriculum_name").value = "";
    document.getElementById("degree_program").value = "";
    document.getElementById("curriculum_description").value = "";
    document.getElementById("modal_sy").value = "";
    document.getElementById("curriculum_year-name").value = "";
    document.getElementById("curriculum_id").value = "";
    document.getElementById("college_program").value = "";

    document.getElementById("curriculum_schoolyear").value = "";

                var modalContent = document.getElementById("modal-content");
                modalContent.innerHTML = "";
});