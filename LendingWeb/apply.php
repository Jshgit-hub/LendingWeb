<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Registration Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-10">

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6 text-center">Client Registration Form</h2>

        <form action="backend/process.php" method="POST">

            <!-- Personal Information -->
            <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Surname</label>
                    <input class="border p-2 rounded w-full" type="text" name="surname" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">First Name</label>
                    <input class="border p-2 rounded w-full" type="text" name="first_name" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Middle Name</label>
                    <input class="border p-2 rounded w-full" type="text" name="middle_name">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gender</label>
                    <select class="border p-2 rounded w-full" name="gender" required>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Age</label>
                    <input class="border p-2 rounded w-full" type="number" name="age" required>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Birthdate</label>
                    <input class="border p-2 rounded w-full" type="date" name="birthdate" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Civil Status</label>
                    <select class="border p-2 rounded w-full" name="civil_status" required>
                        <option>Single</option>
                        <option>Married</option>
                        <option>Widowed</option>
                        <option>Legally Separated</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Living Arrangement</label>
                    <input class="border p-2 rounded w-full" type="text" name="living_arrangement">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Religion</label>
                    <input class="border p-2 rounded w-full" type="text" name="religion" value="Seventh-Day Adventist" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nationality</label>
                    <input class="border p-2 rounded w-full" type="text" name="nationality" value="Filipino" readonly>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                <input class="border p-2 w-full rounded" type="text" name="contact_no" required>
                <label class="block text-sm font-medium text-gray-700 mt-4">Email Address</label>
                <input class="border p-2 w-full rounded" type="email" name="email">
                <label class="block text-sm font-medium text-gray-700 mt-4">National ID number:</label>
                <input class="border p-2 w-full rounded" type="number" name="IdNum">
            </div>

            <!-- Address Section -->
            <h3 class="text-lg font-semibold mb-4">Address</h3>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Permanent Address</label>
                    <input class="border p-2 rounded w-full" type="text" name="perm_house_no" placeholder="House No. / Street / Barangay">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Present Address</label>
                    <input class="border p-2 rounded w-full" type="text" name="pres_house_no" placeholder="House No. / Street / Barangay">
                </div>
            </div>

            <!-- Source of Income -->
            <h3 class="text-lg font-semibold mb-4">Source of Income</h3>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Company Name</label>
                    <input class="border p-2 rounded w-full" type="text" name="company">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Position</label>
                    <input class="border p-2 rounded w-full" type="text" name="position">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Monthly Salary</label>
                    <input class="border p-2 rounded w-full" type="number" name="salary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Years in Job</label>
                    <input class="border p-2 rounded w-full" type="number" name="years_in_job">
                </div>
            </div>

            <!-- Reference Section -->
            <h3 class="text-lg font-semibold mb-4">Reference</h3>
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Reference Name</label>
                    <input class="border p-2 rounded w-full" type="text" name="ref_name">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <input class="border p-2 rounded w-full" type="text" name="ref_contact">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Relationship</label>
                    <input class="border p-2 rounded w-full" type="text" name="ref_relationship">
                </div>
            </div>

            <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full hover:bg-blue-600">Submit</button>

        </form>
    </div>

</body>

</html>