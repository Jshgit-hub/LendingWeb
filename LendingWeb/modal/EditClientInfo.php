<!-- Edit Client Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center p-4">

    <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg relative">
        <form method="POST" action="../backend/clientControls.php"
            class="bg-white w-full max-w-2xl p-6 rounded-lg shadow-lg relative">

            <!-- Modal Title -->
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Client</h2>

            <input type="hidden" name="edit_client_id" id="edit_client_id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Surname -->
                <div>
                    <label class="block text-gray-700 font-medium">Surname</label>
                    <input type="text" name="edit_surname" id="edit_surname"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <!-- First Name -->
                <div>
                    <label class="block text-gray-700 font-medium">First Name</label>
                    <input type="text" name="edit_first_name" id="edit_first_name"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <!-- Middle Name -->
                <div>
                    <label class="block text-gray-700 font-medium">Middle Name</label>
                    <input type="text" name="edit_middle_name" id="edit_middle_name"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-gray-700 font-medium">Gender</label>
                    <select name="edit_gender" id="edit_gender"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 outline-none">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <!-- Age -->
                <div>
                    <label class="block text-gray-700 font-medium">Age</label>
                    <input type="number" name="edit_age" id="edit_age"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <!-- Birthdate -->
                <div>
                    <label class="block text-gray-700 font-medium">Birthdate</label>
                    <input type="date" name="edit_birthdate" id="edit_birthdate"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <!-- Civil Status -->
                <div>
                    <label class="block text-gray-700 font-medium">Civil Status</label>
                    <select name="edit_civil_status" id="edit_civil_status"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 outline-none">
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Widowed">Widowed</option>
                        <option value="Legally Separated">Legally Separated</option>
                    </select>
                </div>

                <!-- Living Arrangement -->
                <div>
                    <label class="block text-gray-700 font-medium">Living Arrangement</label>
                    <input type="text" name="edit_living_arrangement" id="edit_living_arrangement"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <!-- Contact No. -->
                <div>
                    <label class="block text-gray-700 font-medium">Contact No.</label>
                    <input type="text" name="edit_contact_no" id="edit_contact_no"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-700 font-medium">Email</label>
                    <input type="email" name="edit_email" id="edit_email"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <!-- Nationality -->
                <div>
                    <label class="block text-gray-700 font-medium">Nationality</label>
                    <input type="text" name="edit_nationality" id="edit_nationality"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <!-- ID Type -->
                <div>
                    <label class="block text-gray-700 font-medium">ID Type</label>
                    <input type="text" name="edit_id_type" id="edit_id_type"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <!-- ID Number -->
                <div>
                    <label class="block text-gray-700 font-medium">ID Number</label>
                    <input type="text" name="edit_id_number" id="edit_id_number"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end mt-6">
                <button type="submit" name="update_client"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all">
                    Save
                </button>
                <button type="button" onclick="closeEditModal()"
                    class="ml-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all">
                    Cancel
                </button>
            </div>
        </form>
    </div>


    <!-- Delete Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <form method="POST" action="../backend/clientControls.php" class="bg-white p-6 rounded shadow-md">
            <h2 class="text-xl font-semibold mb-4">Confirm Delete</h2>
            <input type="hidden" name="delete_client_id" id="delete_client_id">
            <p>Are you sure you want to delete this client?</p>
            <button type="submit" name="confirm_delete" class="bg-red-500 text-white p-2 rounded mt-4">Delete</button>
            <button type="button" onclick="closeDeleteModal()"
                class="ml-2 bg-gray-500 text-white p-2 rounded">Cancel</button>
        </form>
    </div>


    <!-- Script -->
    <script>
    function openEditModal(id, surname, firstName, middleName, gender, age, birthdate, civilStatus, livingArrangement,
        religion, contactNo, email, nationality, idType, idNumber) {
        document.getElementById("edit_client_id").value = id;
        document.getElementById("edit_surname").value = surname;
        document.getElementById("edit_first_name").value = firstName;
        document.getElementById("edit_middle_name").value = middleName;
        document.getElementById("edit_gender").value = gender;
        document.getElementById("edit_age").value = age;
        document.getElementById("edit_birthdate").value = birthdate;
        document.getElementById("edit_civil_status").value = civilStatus;
        document.getElementById("edit_living_arrangement").value = livingArrangement;
        document.getElementById("edit_religion").value = religion;
        document.getElementById("edit_contact_no").value = contactNo;
        document.getElementById("edit_email").value = email;
        document.getElementById("edit_nationality").value = nationality;
        document.getElementById("edit_id_type").value = idType;
        document.getElementById("edit_id_number").value = idNumber;

        document.getElementById("editModal").classList.remove("hidden");
    }

    function closeEditModal() {
        document.getElementById("editModal").classList.add("hidden");
    }

    function openDeleteModal(id) {
        document.getElementById("delete_client_id").value = id;
        document.getElementById("deleteModal").classList.remove("hidden");
    }

    function closeDeleteModal() {
        document.getElementById("deleteModal").classList.add("hidden");
    }
    </script>