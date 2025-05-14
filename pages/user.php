<?php
include '../php/fetch_user.php';
include '../php/fetch_branch.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCTV - Monitoring</title>
    <link rel="stylesheet" href="../css/entrance_animation.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="https://bonchon.sfo3.digitaloceanspaces.com/logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            "50": "#eff6ff",
                            "100": "#dbeafe",
                            "200": "#bfdbfe",
                            "300": "#93c5fd",
                            "400": "#60a5fa",
                            "500": "#3b82f6",
                            "600": "#2563eb",
                            "700": "#1d4ed8",
                            "800": "#1e40af",
                            "900": "#1e3a8a",
                            "950": "#172554"
                        }
                    }
                },
                fontFamily: {
                    'body': [
                        'Inter',
                        'ui-sans-serif',
                        'system-ui',
                        '-apple-system',
                        'system-ui',
                        'Segoe UI',
                        'Roboto',
                        'Helvetica Neue',
                        'Arial',
                        'Noto Sans',
                        'sans-serif',
                        'Apple Color Emoji',
                        'Segoe UI Emoji',
                        'Segoe UI Symbol',
                        'Noto Color Emoji'
                    ],
                    'sans': [
                        'Inter',
                        'ui-sans-serif',
                        'system-ui',
                        '-apple-system',
                        'system-ui',
                        'Segoe UI',
                        'Roboto',
                        'Helvetica Neue',
                        'Arial',
                        'Noto Sans',
                        'sans-serif',
                        'Apple Color Emoji',
                        'Segoe UI Emoji',
                        'Segoe UI Symbol',
                        'Noto Color Emoji'
                    ]
                }
            }
        }
    </script>
</head>

<body>
    <div class="md:flex flex-col md:flex-row md:min-h-screen w-full">
        <?php include 'navbar.php' ?>
        <div class="main container mx-auto px-4 py-8 overflow-auto max-h-screen">
            <!-- Flexbox container -->
            <div class="flex flex-wrap gap-4 justify-center">
                <!-- Component 1 -->
                <div class="w-full">
                    <div class="bg-white p-4 shadow-md rounded-lg component flex flex-1 items-center gap-2">
                        <h2 class="text-lg font-semibold flex-1 mr-2 mb-2">Users</h2>
                        <div x-data="{ modelOpen: false }">
                            <button @click="modelOpen =!modelOpen" class="flex items-center text-center bg-grey-light hover:bg-grey text-grey-darkest font-bold rounded">
                                <i class="lni lni-plus"></i>
                            </button>

                            <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                    <div x-cloak @click="modelOpen = false" x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

                                    <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                                        <div class="flex items-center justify-between space-x-4 mb-5">
                                            <h1 class="text-xl font-medium text-gray-800 ">Add User</h1>

                                            <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </div>

                                        <form class="mt-5 flex flex-wrap gap-4 p-0" action="../php/add_user.php" onsubmit="return isValid()" method="POST">
                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                                <label for="employee_number" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Employee Number</label>
                                                <input id="employee_number" name="employee_number" placeholder="XXXXXX or XXXXXXXXX" type="number" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            </div>

                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box hidden">
                                                <label for="reg_by" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Full Name</label>
                                                <input id="reg_by" name="reg_by" placeholder="Juan DelaCruz" type="text" value="<?php echo $user_fullname ?>" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            </div>

                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                                <label for="fullname" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Full Name</label>
                                                <input id="fullname" name="fullname" placeholder="Juan DelaCruz" type="text" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            </div>

                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                                <label for="email" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Email</label>
                                                <input id="email" name="email" placeholder="email@bonchon.com.ph" type="email" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            </div>

                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                                <label for="password" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Password</label>
                                                <input id="password" name="password" placeholder="******" type="password" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            </div>

                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                                <label for="branch" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Branch</label>
                                                <select id="branch" name="branch" class="block w-full px-3 py-2 mt-2 text-gray-600 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                                    <option value="">Select an Option</option>
                                                    <?php
                                                    include '../php/fetch_branch.php';
                                                    foreach ($branches as $branches_result_row) {
                                                        $branch_name = utf8_encode($branches_result_row['cctv_branch']);
                                                        $branch_code = utf8_encode($branches_result_row['cctv_store_code']);
                                                        echo "<option value='$branch_code'>$branch_code" . " - " . " $branch_name</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                                <label for="designation" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Designation</label>
                                                <input id="designation" name="designation" placeholder="Job Title" type="text" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            </div>

                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                                <label for="user_type" class="block text-sm text-gray-700 capitalize dark:text-gray-200">User Type</label>
                                                <select id="user_type" name="user_type" class="block w-full px-3 py-2 mt-2 text-gray-600 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                                    <option value="">Select a Role</option>
                                                    <option value="0">Admin</option>
                                                    <option value="1">User</option>
                                                </select>
                                            </div>

                                            <div class="flex w-full justify-end mt-6">
                                                <button id="add_user_button" name="add_user_button" type="submit" class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                                    Create User
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include '../pages/search_bar.php'; ?>

                    </div>
                </div>

                <!-- Component 2 -->
                <div class="w-full">
                    <div class="bg-white p-4 shadow-md rounded-lg component" style="height: 77vh; max-height: 77vh">
                        <div class="overflow-auto h-full">
                            <table id="table" class="w-full table-auto overflow-auto">
                                <thead class="bg-gray-200 sticky top-0">
                                    <tr>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Actions</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Employee Number</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Email</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Password</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Name</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Branch</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Designation</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">User Role</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Registered Date</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Registered By</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Status</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Last-log</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rowNumber = 0; // Initialize row number
                                    foreach ($users as $user_result_row) {
                                        // Alternate row background color
                                        $rowNumber++;
                                        $rowClass = $rowNumber % 2 === 0 ? 'bg-gray-200' : '';

                                        // Define user role
                                        $user_role = $user_result_row['user_type'];
                                        $user_role = $user_role == 0 ? "Admin" : "User";

                                        // Define user status
                                        $user_status = $user_result_row['user_status'];
                                        $user_status = $user_status == 0 ? "Active" : "Deactivated";

                                        // Output table row
                                        echo '<tr class="' . $rowClass . '">';
                                        echo '<th scope="row" class="px-4 py-2 gap-1 flex text-left whitespace-nowrap">';
                                    ?>
                                        <button onclick="openModal('<?php echo htmlspecialchars($user_result_row['user_id'], ENT_QUOTES); ?>')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            <i class="lni lni-pencil"></i>
                                        </button>
                                    <?php
                                        echo "<td class='px-4 py-2 text-left whitespace-nowrap'>" . $user_result_row['user_employee_number'] . "</td>";
                                        echo "<td class='px-4 py-2 text-left whitespace-nowrap'>" . $user_result_row['user_email'] . "</td>";
                                        echo "<td class='px-4 py-2 text-left whitespace-nowrap'>" . $user_result_row['user_password'] . "</td>";
                                        echo "<td class='px-4 py-2 text-left whitespace-nowrap'>" . $user_result_row['user_fullname'] . "</td>";
                                        echo "<td class='px-4 py-2 text-left whitespace-nowrap'>" . $user_result_row['user_branch'] . "</td>";
                                        echo "<td class='px-4 py-2 text-left whitespace-nowrap'>" . $user_result_row['user_designation'] . "</td>";
                                        echo "<td class='px-4 py-2 text-left whitespace-nowrap'>" . $user_role . "</td>";
                                        echo "<td class='px-4 py-2 text-left whitespace-nowrap'>" . $user_result_row['user_reg_date']->format('Y-m-d H:i:s') . "</td>";
                                        echo "<td class='px-4 py-2 text-left whitespace-nowrap'>" . $user_result_row['user_reg_by'] . "</td>";
                                        echo "<td class='px-4 py-2 text-left whitespace-nowrap'>" . $user_status . "</td>";
                                        if ($user_result_row['user_last_log'] !== null) {
                                            echo "<td class='px-4 py-2 text-left whitespace-nowrap'>" . $user_result_row['user_last_log']->format('Y-m-d H:i:s') . "</td>";
                                        } else {
                                            echo "<td class='px-4 py-2 text-left whitespace-nowrap'></td>";
                                        }
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div id="myModal" class="fixed inset-0 z-50 overflow-y-auto transition-all duration-300 ease-out opacity-0 invisible">
                            <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                <div name="outsideModal" class="fixed inset-0 transition-opacity duration-1000 ease-out" aria-hidden="true">
                                    <div id="outsideModal" class="absolute inset-0 bg-gray-500 bg-opacity-40"></div>
                                </div>
                                <div id="theModal" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" class="inline-block w-full max-w-xl p-8 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                                    <!-- Modal header -->
                                    <div class="flex items-center justify-between space-x-4 mb-5">
                                        <h1 class="text-xl font-medium text-gray-800 ">Edit User</h1>
                                        <button class="text-gray-600 focus:outline-none hover:text-gray-700" onclick="closeModal()">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <form class="mt-5 flex flex-wrap gap-4 p-0" action="../php/update_user.php" onsubmit="return isValid()" method="POST">
                                        <!-- form fields here -->
                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box hidden">
                                            <label for="edit_id" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Employee ID</label>
                                            <input id="edit_id" name="edit_id" placeholder="XXXXXX or XXXXXXXXX" type="number" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                        </div>

                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                            <label for="edit_employee_number" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Employee Number</label>
                                            <input id="edit_employee_number" name="edit_employee_number" placeholder="XXXXXX or XXXXXXXXX" type="number" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                        </div>

                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                            <label for="edit_fullname" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Full Name</label>
                                            <input id="edit_fullname" name="edit_fullname" placeholder="Juan DelaCruz" type="text" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                        </div>

                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                            <label for="email" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Email</label>
                                            <input id="edit_email" name="edit_email" placeholder="email@bonchon.com.ph" type="email" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                        </div>

                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                            <label for="edit_password" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Password</label>
                                            <input id="edit_password" name="edit_password" placeholder="******" type="password" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                        </div>

                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                            <label for="edit_branch" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Branch</label>
                                            <select id="edit_branch" name="edit_branch" class="block w-full px-3 py-2 mt-2 text-gray-600 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                                <option value="">Select an Option</option>
                                                <?php
                                                include '../php/fetch_branch.php';
                                                foreach ($branches as $branches_result_row) {
                                                    $branch_name = utf8_encode($branches_result_row['cctv_branch']);
                                                    $branch_code = utf8_encode($branches_result_row['cctv_store_code']);
                                                    echo "<option value='$branch_code'>$branch_code" . " - " . " $branch_name</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                            <label for="edit_designation" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Designation</label>
                                            <input id="edit_designation" name="edit_designation" placeholder="Job Title" type="text" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                        </div>

                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                            <label for="edit_user_type" class="block text-sm text-gray-700 capitalize dark:text-gray-200">User Type</label>
                                            <select id="edit_user_type" name="edit_user_type" class="block w-full px-3 py-2 mt-2 text-gray-600 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                                <option value="">Select a Role</option>
                                                <option value="0">Admin</option>
                                                <option value="1">User</option>
                                            </select>
                                        </div>

                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                            <label for="edit_user_status" class="block text-sm text-gray-700 capitalize dark:text-gray-200">User Type</label>
                                            <select id="edit_user_status" name="edit_user_status" class="block w-full px-3 py-2 mt-2 text-gray-600 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                                <option value="">Select Status</option>
                                                <option value="0">Active</option>
                                                <option value="1">Deactivated</option>
                                            </select>
                                        </div>

                                        <div class="flex w-full justify-end mt-6">
                                            <button id="edit_user_button" name="edit_user_button" type="submit" class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                                Update User
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openModal(id) {
            const modal = document.getElementById("myModal");
            modal.classList.remove("opacity-0");
            modal.classList.add("opacity-100");
            modal.classList.remove("invisible");
            modal.classList.add("visible");
            edit_employee(id)
        }

        function closeModal() {
            const modal = document.getElementById("myModal");
            modal.classList.remove("opacity-100");
            modal.classList.add("opacity-0");
            modal.classList.remove("visible");
            modal.classList.add("invisible");
        }

        const outsideModal = document.getElementById("outsideModal");

        outsideModal.addEventListener("click", function(event) {
            if (event.target === outsideModal) {
                // You clicked on the outsideModal element itself
                closeModal();
            }
        });
    </script>
    <script src="../js/search.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function edit_employee(id) {
            $.ajax({
                type: "GET",
                url: "../php/add_user.php",
                data: {
                    id: id
                }, // Pass the id as a data object
                dataType: "json", // Lowercase
                success: function(response) {
                    console.log("Success: ", response);

                    // Access userId from the returned data
                    var userId = id;

                    // Set values in the modal
                    $("#edit_id").val(userId);
                    $("#edit_employee_number").val(response.user_employee_number);
                    $("#edit_fullname").val(response.user_fullname);
                    $("#edit_email").val(response.user_email);
                    $("#edit_password").val(response.user_password);
                    $("#edit_branch").val(response.user_branch);
                    $("#edit_designation").val(response.user_designation);
                    $("#edit_user_type").val(response.user_type);
                    $("#edit_user_status").val(response.user_status);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching user data: ", status, error);
                }
            });
        }
    </script>

</body>

</html>