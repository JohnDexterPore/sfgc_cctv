<?php
include '../php/fetch_branch.php';
include '../php/fetch_brand.php';
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
    <div class="md:flex flex-col md:flex-row md:min-h-screen w-full h-screen">
        <?php include 'navbar.php' ?>
        <div class="main container mx-auto px-4 py-8 h-full w-full overflow-auto">
            <!-- Flexbox container -->
            <div class="flex flex-wrap gap-4 h-full">
                <div class="w-full">
                    <div class="bg-white p-4 shadow-md rounded-lg component flex flex-1 items-center gap-2">
                        <h2 class="text-lg font-semibold flex-1 mr-2 mb-2">Customize</h2>
                        <div x-data="{ modelOpen: false }">
                            <button @click="modelOpen =!modelOpen" class="gap-2 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow inline-flex items-center">
                                <i class="lni lni-plus text-grey-darkest font-bold"></i>
                                <span>Add Branch</span>
                            </button>

                            <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                    <div x-cloak @click="modelOpen = false" x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

                                    <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                                        <div class="flex items-center justify-between space-x-4 mb-5">
                                            <h1 class="text-xl font-medium text-gray-800 ">Add Branch</h1>

                                            <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </div>

                                        <form class="mt-5 flex flex-wrap gap-4 p-0" action="../php/add_store.php" onsubmit="return isValid()" method="POST">
                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                                <label for="cctv_branch" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Branch Name</label>
                                                <input id="cctv_branch" name="cctv_branch" placeholder="BC branch name" type="text" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            </div>

                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                                <label for="cctv_store_code" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Store Code</label>
                                                <input id="cctv_store_code" name="cctv_store_code" placeholder="XXXXXX" type="text" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            </div>

                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                                <label for="area_id" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Area ID</label>
                                                <input id="area_id" name="area_id" placeholder="XX" type="number" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            </div>

                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                                <label for="cctv_type" class="block text-sm text-gray-700 capitalize dark:text-gray-200">DVR Brand</label>
                                                <select id="cctv_type" name="cctv_type" class="block w-full px-3 py-2 mt-2 text-gray-600 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                                    <option value="">Select an Option</option>
                                                    <?php
                                                    foreach ($brands as $brands_result_row) {
                                                        $brand_name = utf8_encode($brands_result_row['brand_name']);
                                                        echo "<option value='$brand_name'>$brand_name</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                                <label for="serial" class="block text-sm text-gray-700 capitalize dark:text-gray-200">DVR's Serial Number</label>
                                                <input id="serial" name="serial" placeholder="XXXXXXXXX" type="text" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            </div>

                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                                <label for="count" class="block text-sm text-gray-700 capitalize dark:text-gray-200">CCTV Count</label>
                                                <input id="count" name="count" placeholder="No. of CCTV's" type="number" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            </div>

                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                                <label for="cctv_status" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Branch Status</label>
                                                <select id="cctv_status" name="cctv_status" class="block w-full px-3 py-2 mt-2 text-gray-600 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                                    <option value="">Select an Option</option>
                                                    <option value="0">Close</option>
                                                    <option value="1">Open</option>
                                                </select>
                                            </div>

                                            <div class="flex w-full justify-end mt-6">
                                                <button id="add_store_button" name="add_store_button" type="submit" class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                                    Create Branch
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div x-data="{ modelOpen: false }">
                            <button @click="modelOpen =!modelOpen" class="gap-2 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow inline-flex items-center">
                                <i class="lni lni-plus text-grey-darkest font-bold"></i>
                                <span>Add DVR Type</span>
                            </button>

                            <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                    <div x-cloak @click="modelOpen = false" x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

                                    <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                                        <div class="flex items-center justify-between space-x-4 mb-5">
                                            <h1 class="text-xl font-medium text-gray-800 ">CCTV Report of
                                                <?php
                                                $currentDateTime = date('F j');
                                                echo $currentDateTime;
                                                ?></h1>

                                            <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </div>

                                        <form class="mt-5 flex flex-wrap gap-4 p-0" action="../php/add_brand.php" onsubmit="return isValid()" method="POST">
                                            <div class="mt-4 w-full box-sizing border-box">
                                                <label for="brand" class="block text-sm text-gray-700 capitalize dark:text-gray-200">DVR Brand</label>
                                                <input id="brand" name="brand" placeholder="DVR Brand" type="text" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            </div>

                                            <div class="flex w-full justify-end mt-6">
                                                <button id="add_brand_button" name="add_brand_button" type="submit" class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                                    Add DVR Brand
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="resizable resize-x w-full md:w-[calc(100%-1rem)] lg:w-[calc(75%-0.5rem)] box-sizing border-box overflow-y-hidden h-5/6">
                    <h2 class=" text-lg font-semibold bg-gray-200 py-2 text-center rounded-t-lg">Branches</h2>
                    <div class="bg-white shadow-md component h-full w-full overflow-auto border-t-2 border-slate-50">
                        <div class="bg-white">
                            <table class="table-auto">
                                <thead class="bg-gray-200 sticky top-0">
                                    <tr>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Actions</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Store Code</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Branch</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Area</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Status</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">DVR Brand</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Serial No.</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">CCTV Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rowNumber = 0; // Initialize row number
                                    include '../php/fetch_branch.php';
                                    foreach ($branches as $branches_result_row) {
                                        $rowNumber++;
                                        $rowClass = $rowNumber % 2 === 0 ? 'bg-gray-200' : '';

                                        // Output table row
                                        echo '<tr class="' . $rowClass . '">';
                                        echo '<th scope="row" class="px-4 py-2 gap-1 flex text-left whitespace-nowrap">';
                                    ?>
                                        <button onclick="openModalBranch('<?php echo htmlspecialchars($branches_result_row['cctv_id'], ENT_QUOTES); ?>')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            <i class="lni lni-pencil"></i>
                                        </button>
                                    <?php
                                        $cctv_branch = utf8_encode($branches_result_row['cctv_branch']);
                                        echo "<td class='px-4 py-2 text-left whitespace-nowrap'>" . $branches_result_row['cctv_store_code'] . "</td>";
                                        echo "<td class='px-4 py-2 text-left whitespace-nowrap'>" . $cctv_branch . "</td>";
                                        echo "<td class='px-4 py-2 text-left whitespace-nowrap'>" . $branches_result_row['cctv_area'] . "</td>";
                                        echo "<td class='px-4 py-2 text-left whitespace-nowrap'>";
                                        echo $branches_result_row['cctv_status'] == 1 ? 'Open' : 'Close';
                                        echo "</td>";
                                        echo "<td class='px-4 py-2 text-left whitespace-nowrap'>" . $branches_result_row['cctv_type'] . "</td>";
                                        echo "<td class='px-4 py-2 text-left whitespace-nowrap'>" . $branches_result_row['cctv_serial'] . "</td>";
                                        echo "<td class='px-4 py-2 text-left whitespace-nowrap'>" . $branches_result_row['cctv_count'] . "</td>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="modalBranch" class="fixed inset-0 z-50 overflow-y-auto transition-all duration-300 ease-out opacity-0 invisible">
                            <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                <div name="outsideModalBranch" class="fixed inset-0 transition-opacity duration-1000 ease-out" aria-hidden="true">
                                    <div id="outsideModalBranch" class="absolute inset-0 bg-gray-500 bg-opacity-40"></div>
                                </div>
                                <div id="theModal" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" class="inline-block w-full max-w-xl p-8 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                                    <!-- Modal header -->
                                    <div class="flex items-center justify-between space-x-4 mb-5">
                                        <h1 class="text-xl font-medium text-gray-800 ">Edit Branch</h1>
                                        <button class="text-gray-600 focus:outline-none hover:text-gray-700" onclick="closeModalBranch()">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <form class="mt-5 flex flex-wrap gap-4 p-0" action="../php/update_branch.php" onsubmit="return isValid()" method="POST">
                                        <!-- form fields here -->
                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box hidden">
                                            <label for="edit_cctv_id" class="block text-sm text-gray-700 capitalize dark:text-gray-200"></label>
                                            <input id="edit_cctv_id" name="edit_cctv_id" placeholder="XXXXXX or XXXXXXXXX" type="number" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                        </div>

                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                            <label for="edit_cctv_branch" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Branch Name</label>
                                            <input id="edit_cctv_branch" name="edit_cctv_branch" placeholder="BC branch name" type="text" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                        </div>

                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                            <label for="edit_cctv_store_code" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Store Code</label>
                                            <input id="edit_cctv_store_code" name="edit_cctv_store_code" placeholder="XXXXXX" type="text" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                        </div>

                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                            <label for="edit_area_id" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Area ID</label>
                                            <input id="edit_area_id" name="edit_area_id" placeholder="XX" type="number" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                        </div>

                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                            <label for="edit_cctv_type" class="block text-sm text-gray-700 capitalize dark:text-gray-200">DVR Brand</label>
                                            <select id="edit_cctv_type" name="edit_cctv_type" class="block w-full px-3 py-2 mt-2 text-gray-600 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                                <option value="">Select an Option</option>
                                                <?php
                                                foreach ($brands as $brands_result_row) {
                                                    $brand_name = utf8_encode($brands_result_row['brand_name']);
                                                    echo "<option value='$brand_name'>$brand_name</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                            <label for="edit_serial" class="block text-sm text-gray-700 capitalize dark:text-gray-200">DVR's Serial Number</label>
                                            <input id="edit_serial" name="edit_serial" placeholder="XXXXXXXXX" type="text" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                        </div>

                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                            <label for="edit_count" class="block text-sm text-gray-700 capitalize dark:text-gray-200">CCTV Count</label>
                                            <input id="edit_count" name="edit_count" placeholder="No. of CCTV's" type="number" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                        </div>

                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                            <label for="edit_cctv_status" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Branch Status</label>
                                            <select id="edit_cctv_status" name="edit_cctv_status" class="block w-full px-3 py-2 mt-2 text-gray-600 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                                <option value="">Select an Option</option>
                                                <option value="0">Close</option>
                                                <option value="1">Open</option>
                                            </select>
                                        </div>

                                        <div class="flex w-full justify-end mt-6">
                                            <button id="edit_branch_button" name="edit_branch_button" type="submit" class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                                Update Branch
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="resizable resize-x w-full md:w-[calc(100%-1rem)] lg:w-[calc(25%-0.5rem)] box-sizing border-box overflow-y-hidden h-5/6">
                    <h2 class="text-lg font-semibold bg-gray-200 py-2 text-center rounded-t-lg">DVR Brand</h2>
                    <div class="bg-white shadow-md component h-full w-full overflow-auto border-t-2 border-slate-50">
                        <div class="bg-white">
                            <table class="table-auto">
                                <thead class="bg-gray-200 sticky top-0">
                                    <tr>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Actions</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Brand Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rowNumber = 0; // Initialize row number
                                    foreach ($brands as $brand_result_row) {
                                        $rowNumber++;
                                        $rowClass = $rowNumber % 2 === 0 ? 'bg-gray-200' : '';

                                        // Output table row
                                        echo '<tr class="' . $rowClass . '">';
                                        echo '<th scope="row" class="px-4 py-2 gap-1 flex text-left whitespace-nowrap">';
                                    ?>
                                        <button onclick="openModalBrand('<?php echo htmlspecialchars($brand_result_row['brand_id'], ENT_QUOTES); ?>')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            <i class="lni lni-pencil"></i>
                                        </button>
                                    <?php
                                        echo "<td class='px-4 py-2 text-left whitespace-nowrap'>" . $brand_result_row['brand_name'] . "</td>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="modalBrand" class="fixed inset-0 z-50 overflow-y-auto transition-all duration-300 ease-out opacity-0 invisible">
                            <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                <div name="outsideModalBrand" class="fixed inset-0 transition-opacity duration-1000 ease-out" aria-hidden="true">
                                    <div id="outsideModalBrand" class="absolute inset-0 bg-gray-500 bg-opacity-40"></div>
                                </div>
                                <div id="theModal" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" class="inline-block w-full max-w-xl p-8 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                                    <!-- Modal header -->
                                    <div class="flex items-center justify-between space-x-4 mb-5">
                                        <h1 class="text-xl font-medium text-gray-800 ">Edit Brand</h1>
                                        <button class="text-gray-600 focus:outline-none hover:text-gray-700" onclick="closeModalBrand()">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <form class="mt-5 flex flex-wrap gap-4 p-0" action="../php/update_brand.php" onsubmit="return isValid()" method="POST">
                                        <!-- form fields here -->
                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box hidden">
                                            <label for="edit_brand_id" class="block text-sm text-gray-700 capitalize dark:text-gray-200"></label>
                                            <input id="edit_brand_id" name="edit_brand_id" placeholder="XXXXXX or XXXXXXXXX" type="number" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                        </div>

                                        <div class="mt-4 w-full box-sizing border-box">
                                            <label for="edit_brand" class="block text-sm text-gray-700 capitalize dark:text-gray-200">DVR Brand</label>
                                            <input id="edit_brand" name="edit_brand" placeholder="DVR Brand" type="text" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                        </div>

                                        <div class="flex w-full justify-end mt-6">
                                            <button id="edit_brand_button" name="edit_brand_button" type="submit" class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                                Update Brand
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
        function openModalBranch(id) {
            const modal = document.getElementById("modalBranch");
            modal.classList.remove("opacity-0");
            modal.classList.add("opacity-100");
            modal.classList.remove("invisible");
            modal.classList.add("visible");
            edit_branch(id)
        }

        function closeModalBranch() {
            const modal = document.getElementById("modalBranch");
            modal.classList.remove("opacity-100");
            modal.classList.add("opacity-0");
            modal.classList.remove("visible");
            modal.classList.add("invisible");
        }

        const outsideModalBranch = document.getElementById("outsideModalBranch");

        outsideModalBranch.addEventListener("click", function(event) {
            if (event.target === outsideModalBranch) {
                // You clicked on the outsideModal element itself
                closeModalBranch();
            }
        });

        function openModalBrand(id) {
            const modal = document.getElementById("modalBrand");
            modal.classList.remove("opacity-0");
            modal.classList.add("opacity-100");
            modal.classList.remove("invisible");
            modal.classList.add("visible");
            edit_brand(id)
        }

        function closeModalBrand() {
            const modal = document.getElementById("modalBrand");
            modal.classList.remove("opacity-100");
            modal.classList.add("opacity-0");
            modal.classList.remove("visible");
            modal.classList.add("invisible");
        }

        const outsideModalBrand = document.getElementById("outsideModalBrand");

        outsideModalBrand.addEventListener("click", function(event) {
            if (event.target === outsideModalBrand) {
                // You clicked on the outsideModal element itself
                closeModalBrand();
            }
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script>
        function edit_branch(branch_id) {
            $.ajax({
                type: "GET",
                url: "../php/add_store.php",
                data: {
                    branch_id: branch_id
                }, // Pass the id as a data object
                dataType: "json", // Lowercase
                success: function(response) {
                    console.log("Success: ", response);

                    // Access userId from the returned data
                    var branchId = branch_id;

                    // Set values in the modal
                    $("#edit_cctv_id").val(branchId);
                    $("#edit_cctv_branch").val(response.cctv_branch);
                    $("#edit_area_id").val(response.cctv_area);
                    $("#edit_cctv_type").val(response.cctv_type);
                    $("#edit_serial").val(response.cctv_serial);
                    $("#edit_count").val(response.cctv_count);
                    $("#edit_cctv_status").val(response.cctv_status);
                    $("#edit_cctv_store_code").val(response.cctv_store_code);

                },
                error: function(xhr, status, error) {
                    console.error("Error fetching branch data: ", status, error);
                }
            });
        }
    </script>
    <script>
        function edit_brand(brand_id) {
            $.ajax({
                type: "GET",
                url: "../php/add_brand.php",
                data: {
                    brand_id: brand_id
                }, // Pass the id as a data object
                dataType: "json", // Lowercase
                success: function(response) {
                    console.log("Success: ", response);

                    // Access userId from the returned data
                    var brandId = brand_id;

                    // Set values in the modal
                    $("#edit_brand_id").val(brandId);
                    $("#edit_brand").val(response.brand_name);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching branch data: ", status, error);
                }
            });
        }
    </script>
</body>

</html>