<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Application Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-10">

    <div class="max-w-4xl mx-auto bg-white p-8 rounded shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Loan Details</h2>
        <form action="backend/process_loan.php" method="POST">

            <!-- Loan Type -->
            <div class="mb-6">
                <label class="block mb-2 font-medium">Loan Type:</label>
                <select class="border p-2 w-full rounded" name="loan_type" required>
                    <option value="Personal Loan">Personal Loan</option>
                    <option value="Business Loan">Business Loan</option>
                    <option value="Secured Loan">Secured Loan</option>
                    <option value="Micro Loan">Micro Loan</option>
                    <option value="Peer-to-Peer Loan">Peer-to-Peer Loan</option>
                </select>
            </div>

            <!-- Loan Amount & Loan Term -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <label>Loan Amount<input class="border p-2 rounded w-full" type="number" step="0.01" name="loan_amount" required></label>
                <label>Loan Term (in months)<input class="border p-2 rounded w-full" type="number" name="loan_term" required></label>
            </div>

            <!-- Interest Rate -->
            <div class="mb-6">
                <label>Interest Rate (%)<input class="border p-2 rounded w-full" type="number" step="0.01" name="interest_rate" required></label>
            </div>

            <!-- First Payment & Last Payment -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <label>First Payment Date<input class="border p-2 rounded w-full" type="date" name="first_payment" required></label>
                <label>Last Payment Date<input class="border p-2 rounded w-full" type="date" name="last_payment" required></label>
            </div>

            <!-- Late Payment Penalty (Percentage) -->
            <div class="mb-6">
                <label>Late Payment Penalty (%)<input class="border p-2 rounded w-full" type="number" step="0.01" name="late_payment_penalty" required></label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full">Submit Loan Application</button>

        </form>
    </div>

</body>

</html>