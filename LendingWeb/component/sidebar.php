<link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

<div class="fixed inset-y-0 left-0 bg-blue-900 text-white p-6 transition-all duration-300 w-64" id="sidebar">


    <!-- Toggle Button -->
    <button onclick="toggleSidebar()" class="absolute top-4 right-4 bg-blue-700 p-2 rounded text-white">
        <span id="toggleIcon">☰</span>
    </button>

    <h2 class="text-xl font-semibold mb-6 transition-opacity duration-300 sidebar-text w-full">Lending Admin</h2>

    <?php
    $current_page = basename($_SERVER['PHP_SELF']); // Get current page filename
    ?>

    <ul class="space-y-4">
        <li>
            <a href="dashboard.php" class="flex items-center w-full p-2 rounded 
                <?php echo ($current_page == 'dashboard.php') ? 'bg-blue-700' : 'hover:bg-blue-700'; ?>">
                <span class="sidebar-icon">📊</span>
                <span class="ml-2 sidebar-text">Dashboard</span>
            </a>
        </li>

        <li>
            <a href="../customer_records.php    " class="flex items-center p-2 rounded 
                <?php echo ($current_page == 'customer_records.php') ? 'bg-blue-700' : 'hover:bg-blue-700'; ?>">
                <span class="sidebar-icon">👥</span>
                <span class="ml-2 sidebar-text">Client Records</span>
            </a>
        </li>
        <li>
            <a href="../clients_record.php" class="flex items-center p-2 rounded 
                <?php echo ($current_page == 'clients_record.php') ? 'bg-blue-700' : 'hover:bg-blue-700'; ?>">
                <span class="sidebar-icon">👥</span>
                <span class="ml-2 sidebar-text">Clients loans</span>
            </a>
        </li>

        <li>
            <a href="../payment_records.php" class="flex items-center p-2 rounded 
                <?php echo ($current_page == 'payment_records.php') ? 'bg-blue-700' : 'hover:bg-blue-700'; ?>">
                <span class="sidebar-icon">💳</span>
                <span class="ml-2 sidebar-text">Payments</span>
            </a>
        </li>
        <li>
            <a href="reports.php" class="flex items-center p-2 rounded 
                <?php echo ($current_page == 'reports.php') ? 'bg-blue-700' : 'hover:bg-blue-700'; ?>">
                <span class="sidebar-icon">📄</span>
                <span class="ml-2 sidebar-text">Reports</span>
            </a>
        </li>
        <li>
            <a href="logout.php" class="flex items-center p-2 rounded hover:bg-red-700">
                <span class="sidebar-icon">🚪</span>
                <span class="ml-2 sidebar-text">Logout</span>
            </a>
        </li>
    </ul>
</div>

<script>
    function toggleSidebar() {
        let sidebar = document.getElementById("sidebar");
        let texts = document.querySelectorAll(".sidebar-text");
        let toggleIcon = document.getElementById("toggleIcon");

        if (sidebar.classList.contains("w-64")) {
            sidebar.classList.remove("w-64");
            sidebar.classList.add("w-16");

            texts.forEach(text => {
                text.classList.add("hidden");
            });

            toggleIcon.innerText = "☰";
        } else {
            sidebar.classList.remove("w-16");
            sidebar.classList.add("w-64");

            texts.forEach(text => {
                text.classList.remove("hidden");
            });

            toggleIcon.innerText = "☰";
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>