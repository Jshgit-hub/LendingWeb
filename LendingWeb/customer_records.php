<?php
$conn = new mysqli('localhost', 'root', '', 'lending');

// Fetch Client Records
$customers = $conn->query("
    SELECT 
        c.client_id,
        c.surname, 
        c.first_name, 
        c.middle_name, 
        c.gender,
        c.age,
        c.birthdate,
        c.civil_status,
        c.living_arrangement,
        c.religion,
        c.contact_no,
        c.email,
        c.nationality,
        c.id_type,
        c.id_number,
        c.date_registered,
        l.loan_type,
        COUNT(l.loan_id) AS loan_count
    FROM clients c
    LEFT JOIN loans l ON c.client_id = l.client_id
    GROUP BY c.client_id, l.loan_type
    ORDER BY c.client_id ASC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Records</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-100 flex flex-col md:flex-row md:flex-wrap ">

    <!-- Sidebar -->
    <?php include "component/sidebar.php"; ?>

    <!-- Main Content -->
    <div class="flex-1 p-6 md:ml-64">
        <div class="max-w-full mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4 text-gray-700">Client Records</h2>

            <!-- Search & Entries -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-2 md:space-y-0">
                <div>
                    <label for="entries" class="text-gray-600 mr-2">Show:</label>
                    <select id="entries" class="p-2 border rounded-md">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span class="text-gray-600">entries</span>
                </div>

                <input type="text" id="search" class="p-2 border rounded-md w-64" placeholder="Search Clients...">
            </div>

            <!-- Client Table -->
            <div class="overflow-x-auto flex flex-wrap">
                <table class="w-full table-auto border border-gray-300 text-sm" id="clientTable">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="border p-2">Client ID</th>
                            <th class="border p-2">First Name</th>
                            <th class="border p-2">Middle Name</th>
                            <th class="border p-2">Surname</th>
                            <th class="border p-2">Gender</th>
                            <th class="border p-2">Age</th>
                            <th class="border p-2 hidden md:table-cell">Birthdate</th>
                            <th class="border p-2 hidden md:table-cell">Civil Status</th>
                            <th class="border p-2">Contact No.</th>
                            <th class="border p-2">Email</th>
                            <th class="border p-2">Loan Type Availed</th>
                            <th class="border p-2">Times Borrowed</th>
                            <th class="border p-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $customers->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="border p-2"><?= $row['client_id'] ?></td>
                            <td class="border p-2"><?= $row['first_name'] ?></td>
                            <td class="border p-2"><?= $row['middle_name'] ?></td>
                            <td class="border p-2"><?= $row['surname'] ?></td>
                            <td class="border p-2"><?= $row['gender'] ?></td>
                            <td class="border p-2"><?= $row['age'] ?></td>
                            <td class="border p-2 hidden md:table-cell"><?= $row['birthdate'] ?></td>
                            <td class="border p-2 hidden md:table-cell"><?= $row['civil_status'] ?></td>
                            <td class="border p-2"><?= $row['contact_no'] ?? 'N/A' ?></td>
                            <td class="border p-2"><?= $row['email'] ?? 'N/A' ?></td>
                            <td class="border p-2"><?= $row['loan_type'] ?? 'No Loan Yet' ?></td>
                            <td class="border p-2"><?= $row['loan_count'] ?></td>
                            <td class="border p-2 text-center flex justify-between">
                                <button onclick="openEditModal(
    <?= $row['client_id'] ?>, 
    '<?= addslashes($row['surname']) ?>',
    '<?= addslashes($row['first_name']) ?>',
    '<?= addslashes($row['middle_name']) ?>',
    '<?= $row['gender'] ?>',
    <?= $row['age'] ?>,
    '<?= $row['birthdate'] ?>',
    '<?= $row['civil_status'] ?>',
    '<?= addslashes($row['living_arrangement']) ?>',
    '<?= addslashes($row['religion']) ?>',
    '<?= $row['contact_no'] ?>',
    '<?= addslashes($row['email']) ?>',
    '<?= addslashes($row['nationality']) ?>',
    '<?= addslashes($row['id_type']) ?>',
    '<?= addslashes($row['id_number']) ?>'
)" class="text-blue-500 text-lg mx-2">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-blue-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>
                                </button>


                                </button>
                                <button onclick="openDeleteModal(<?= $row['client_id'] ?>)" class="mx-2">
                                    <svg class="w-6 h-6 text-red-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                </button>

                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-between items-center mt-4">
                <span id="pageInfo" class="text-gray-600 justify-start"></span>
                <div class="flex justify-between space-x-4">
                    <button id="prevPage" class="p-2 bg-blue-500 text-white rounded-md justify-end">Previous</button>
                    <button id="nextPage" class="p-2 bg-blue-500 text-white rounded-md">Next</button>
                </div>
            </div>

        </div>
    </div>


    <?php include "modal/EditClientInfo.php" ?>




    <!-- Pagination & Search Script -->
    <script>
    $(document).ready(function() {
        let rowsPerPage = 10;
        let currentPage = 1;

        function updateTable() {
            let searchTerm = $("#search").val().toLowerCase();
            let rows = $("#clientTable tbody tr");

            rows.hide();
            let filteredRows = rows.filter(function() {
                return $(this).text().toLowerCase().includes(searchTerm);
            });

            let totalPages = Math.ceil(filteredRows.length / rowsPerPage);
            if (currentPage > totalPages) currentPage = totalPages;

            let start = (currentPage - 1) * rowsPerPage;
            let end = start + rowsPerPage;
            filteredRows.slice(start, end).show();

            $("#pageInfo").text(`Page ${currentPage} of ${totalPages || 1}`);
        }

        $("#entries").change(function() {
            rowsPerPage = parseInt($(this).val());
            currentPage = 1;
            updateTable();
        });

        $("#search").keyup(function() {
            currentPage = 1;
            updateTable();
        });

        $("#prevPage").click(function() {
            if (currentPage > 1) {
                currentPage--;
                updateTable();
            }
        });

        $("#nextPage").click(function() {
            let totalRows = $("#clientTable tbody tr:visible").length;
            let totalPages = Math.ceil(totalRows / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                updateTable();
            }
        });

        updateTable();
    });
    </script>

</body>

</html>