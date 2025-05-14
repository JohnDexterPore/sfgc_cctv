<?php
include '../php/fetch_status.php';
include '../php/fetch_branch.php';
include '../php/fetch_area.php';

if (!isset($_SESSION)) {
    session_start();
}
$user_branch = $_SESSION['user_branches'];

$user_type = $_SESSION['user_type'];
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
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>

<body>
    <div class="md:flex flex-col md:flex-row md:min-h-screen w-full">
        <?php include 'navbar.php' ?>
        <div class="main container mx-auto px-4 py-8 overflow-auto max-h-screen">
            <!-- Flexbox container -->
            <div class="flex flex-wrap gap-4 justify-center">
                <!-- Component 1 -->
                <div class="w-full">
                    <div class="bg-white p-4 shadow-md rounded-lg component flex flex-1 items-center gap-4">
                        <h2 class="text-lg font-semibold flex-1 mr-2 mb-2">Records</h2>
                        <div x-data="{ modelOpen: false }">
                            <button @click="modelOpen =!modelOpen" class="flex items-center text-center bg-grey-light hover:bg-grey text-grey-darkest font-bold rounded">
                                <i class="lni lni-plus"></i>
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

                                        <form class="mt-5 flex flex-wrap gap-4 p-0" action="../php/add_status.php" enctype="multipart/form-data" onsubmit="return isValid()" method="POST">
                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                                <label for="date" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Date</label>
                                                <input <?php
                                                        echo $user_type == 1 ? 'readonly' : '';
                                                        ?> id="date" name="date" placeholder="Date" type="datetime-local" value="<?php $currentDateTime = date('Y-m-d H:i:s');
                                                                                                                                    echo $currentDateTime;
                                                                                                                                    ?>" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            </div>

                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box <?php echo $user_type == 1 && count($user_branch) == 1 ? "hidden" : ''; ?>">
                                                <label for="branch" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Branch</label>
                                                <select id="branch" name="branch" class="block w-full px-3 py-2 mt-2 text-gray-600 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40 <?php echo $user_type == 1 && count($user_branch) == 1 ? "" : 'required'; ?>">
                                                    <option value="">Select an Branch</option>
                                                    <?php
                                                    include '../php/fetch_branch.php';
                                                    if ($user_type == 0) {
                                                        foreach ($branches as $branches_result_row) {
                                                            $branch_name = utf8_encode($branches_result_row['cctv_branch']);
                                                            $branch_code = utf8_encode($branches_result_row['cctv_store_code']);
                                                            echo "<option value='$branch_code'>$branch_code" . " - " . " $branch_name</option>";
                                                        }
                                                    } elseif (count($user_branch) > 1) {
                                                        foreach ($branches as $branches_result_row) {
                                                            if (in_array($branches_result_row['cctv_store_code'], $user_branch)) {
                                                                $branch_name = utf8_encode($branches_result_row['cctv_branch']);
                                                                $branch_code = utf8_encode($branches_result_row['cctv_store_code']);
                                                                echo "<option value='$branch_code'>$branch_code" . " - " . " $branch_name</option>";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                                <label for="working_cctv" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Number of Working CCTV</label>
                                                <input min="0" max="99" required id="working_cctv" name="working_cctv" placeholder="XX" type="number" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            </div>

                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                                <label for="cctv_image" class="block text-sm text-gray-700 dark:text-gray-200">Upload image/s</label>
                                                <input required accept="image/*" id="cctv_image" name="cctv_image" type="file" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            </div>

                                            <div class="flex mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box justify-between">
                                                <div class="flex items-center">
                                                    <input id="cctv_status_defective" type="checkbox" value="Defective DVR" name="cctv_status_defective" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <label for="cctv_status_defective" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Defective DVR</label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input id="cctv_status_closed" type="checkbox" value="Store Closed" name="cctv_status_closed" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <label for="cctv_status_closed" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Store Closed</label>
                                                </div>
                                            </div>

                                            <div class="mt-4 w-full box-sizing border-box hidden" id="reasonDiv">
                                                <label for="reason" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Reason</label>
                                                <input id="reason" name="reason" placeholder="Reason" type="textarea" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" disabled>
                                            </div>

                                            <script>
                                                const cctv_image = document.getElementById('cctv_image');
                                                const working_cctv = document.getElementById('working_cctv');
                                                const storeOpenCheckbox = document.getElementById('cctv_status_defective');
                                                const storeClosedCheckbox = document.getElementById('cctv_status_closed');
                                                const reasonInput = document.getElementById('reason');
                                                const reasonDiv = reasonInput.parentNode;

                                                storeOpenCheckbox.addEventListener('change', (event) => {
                                                    if (event.target.checked) {
                                                        storeClosedCheckbox.checked = false;
                                                        reasonInput.disabled = true;
                                                        reasonInput.required = false;
                                                        reasonInput.value = ''; // Clear the text box
                                                        reasonDiv.classList.add('hidden');
                                                        working_cctv.value = 0;
                                                        working_cctv.readOnly = true;
                                                    } else {
                                                        working_cctv.value = '';
                                                        working_cctv.disabled = false;
                                                        cctv_image.disabled = false;
                                                        cctv_image.required = true;
                                                    }
                                                });

                                                storeClosedCheckbox.addEventListener('change', (event) => {
                                                    if (event.target.checked) {
                                                        storeOpenCheckbox.checked = false;
                                                        reasonInput.disabled = false;
                                                        reasonInput.required = true;
                                                        reasonDiv.classList.remove('hidden');
                                                        working_cctv.value = 0;
                                                        working_cctv.readOnly = true;
                                                        cctv_image.disabled = true;
                                                        cctv_image.required = false;
                                                    } else {
                                                        reasonInput.disabled = true;
                                                        reasonInput.required = false;
                                                        reasonInput.value = ''; // Clear the text box
                                                        reasonDiv.classList.add('hidden');
                                                        working_cctv.value = '';
                                                        working_cctv.readOnly = false;
                                                        cctv_image.disabled = false;
                                                        cctv_image.required = true;
                                                    }
                                                });
                                            </script>
                                            <div class="flex w-full justify-end mt-6">
                                                <button id="add_status_button" name="add_status_button" type="submit" class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                                    Create Report
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div x-data="{ modelOpen: false }">
                            <button @click="modelOpen =!modelOpen" class="gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 flex items-center">
                                <i class="lni lni-search-alt"></i> Search
                            </button>

                            <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                    <div x-cloak @click="modelOpen = false" x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

                                    <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                                        <div class="flex items-center justify-between space-x-4 mb-5">
                                            <h1 class="text-xl font-medium text-gray-800 ">Search Records</h1>
                                            <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </div>

                                        <form class="mt-5 flex flex-wrap gap-4 p-0" onsubmit="return isValid()" method="POST">
                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box">
                                                <label for="search_date" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Date</label>
                                                <input id="search_date" name="search_date" placeholder="Date" type="date" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            </div>

                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box <?php echo $user_type == 1 && count($user_branch) == 1 ? "hidden" : ''; ?>">
                                                <label for="search_branch" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Branch</label>
                                                <select id="search_branch" name="search_branch" class="block w-full px-3 py-2 mt-2 text-gray-600 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40 <?php echo $user_type == 1 && count($user_branch) == 1 ? "" : 'required'; ?>">
                                                    <option value="">Select an Branch</option>
                                                    <?php
                                                    include '../php/fetch_branch.php';
                                                    if ($user_type == 0) {
                                                        foreach ($branches as $branches_result_row) {
                                                            $branch_name = utf8_encode($branches_result_row['cctv_branch']);
                                                            $branch_code = utf8_encode($branches_result_row['cctv_store_code']);
                                                            echo "<option value='$branch_code'>$branch_code" . " - " . " $branch_name</option>";
                                                        }
                                                    } elseif (count($user_branch) > 1) {
                                                        foreach ($branches as $branches_result_row) {
                                                            if (in_array($branches_result_row['cctv_store_code'], $user_branch)) {
                                                                $branch_name = utf8_encode($branches_result_row['cctv_branch']);
                                                                $branch_code = utf8_encode($branches_result_row['cctv_store_code']);
                                                                echo "<option value='$branch_code'>$branch_code" . " - " . " $branch_name</option>";
                                                            }
                                                        }
                                                    }

                                                    ?>
                                                </select>
                                            </div>

                                            <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box <?php echo $user_type == 1 ? "hidden" : ''; ?>">
                                                <label for="search_area" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Area</label>
                                                <select id="search_area" name="search_area" class="block w-full px-3 py-2 mt-2 text-gray-600 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                                    <option value="">Select an Option</option>
                                                    <?php
                                                    foreach ($cctv_area as $cctv_area_row) {
                                                        $area_name = utf8_encode($cctv_area_row['cctv_area']);
                                                        echo "<option value='$area_name'>$area_name</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="flex w-full justify-end mt-6">
                                                <button id="search_button" name="search_button" type="submit" class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                                    Search
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Component 2 -->
                <div class="w-full">
                    <div class="bg-white shadow-md rounded-lg p-4 component" style="height: 77vh; max-height: 77vh">
                        <div class="overflow-auto h-full">
                            <table id="table" class="w-full table-auto overflow-auto">
                                <thead class="bg-gray-200 sticky top-0">
                                    <tr>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Actions</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Remarks</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Area</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Date</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Branch</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Working</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Not Working</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Total</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Status</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Reason</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Brand</th>
                                        <th class="px-4 py-2 text-left whitespace-nowrap">Serial No.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Extracted function to generate the modal HTML
                                    function generateModalHtml($uniqueId, $statusResultRow)
                                    {
                                    ?>
                                        <div data-dialog-backdrop="<?php echo $uniqueId; ?>" data-dialog-backdrop-close="true" class="pointer-events-none fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black bg-opacity-60 opacity-0 backdrop-blur-sm transition-opacity duration-300">
                                            <div class="relative h-[90%] max-h-[90%] overflow-hidden m-4 w-3/4 min-w-[90%] max-w-[90%] rounded-lg bg-white font-sans text-base font-light leading-relaxed text-blue-gray-500 antialiased shadow-2xl" role="dialog" data-dialog="<?php echo $uniqueId; ?>">
                                                <!-- modal content -->
                                                <div class="flex shrink-0 items-center justify-between p-4 font-sans text-2xl font-semibold leading-snug text-blue-gray-900 antialiased">
                                                    <div class="flex items-center gap-3">
                                                        <button class="select-none rounded-lg bg-green-500 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md shadow-green-500/20 transition-all hover:shadow-lg hover:shadow-green-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button" data-ripple-light="true" onclick="downloadImage('<?php echo $statusResultRow['record_file_name']; ?>')">
                                                            Download
                                                        </button>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <button class="select-none rounded-lg bg-red-500 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md shadow-red-500/20 transition-all hover:shadow-lg hover:shadow-red-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button" data-ripple-light="true" data-dialog-close="<?php echo $uniqueId; ?>">
                                                            Close
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="relative h-full border-t w-full border-b border-t-blue-gray-100 border-b-blue-gray-100 p-0 font-sans text-base font-light leading-relaxed text-blue-gray-500 antialiased flex justify-center">
                                                    <div class="zoom-container relative h-full border-t w-full overflow-auto border-b border-t-blue-gray-100 border-b-blue-gray-100 p-0 font-sans text-base font-light leading-relaxed text-blue-gray-500 antialiased flex justify-center">
                                                        <img id="zoom-image-<?php echo $uniqueId; ?>" class="object-cover" src="../image_uploads/<?php echo $statusResultRow['record_file_name']; ?>" draggable="false" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }

                                    // Main code
                                    $rowNumber = 0;
                                    foreach ($status as $statusResultRow) {
                                        if ($user_type == 0) {
                                            $rowNumber++;
                                            $rowClass = $rowNumber % 2 === 0 ? 'bg-gray-200' : '';
                                            $uniqueId = 'modal_' . $rowNumber;
                                            $remarksCode = $statusResultRow['record_cctv_remarks'];
                                            $remarks = match ($remarksCode) {
                                                0 => 'Complete',
                                                1 => 'Incomplete - No picture',
                                                2 => 'Incomplete - Picture Re-Used',
                                                default => '',
                                            };
                                            $style = match ($remarksCode) {
                                                0 => 'text-green-500',
                                                1 => 'text-orange-500',
                                                2 => 'text-red-500',
                                                default => '',
                                            };
                                        ?>
                                            <tr class="<?php echo $rowClass; ?>">
                                                <th scope="row" class="px-4 py-2 gap-1 flex text-left whitespace-nowrap">
                                                    <button onclick="openModal('<?php echo htmlspecialchars($statusResultRow['record_transac_id'], ENT_QUOTES); ?>')" class="<?php echo $user_type == 1 ? "hidden" : ''; ?> bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                                        <i class="lni lni-pencil"></i>
                                                    </button>
                                                    <?php if (!empty($statusResultRow['record_file_name'])) { ?>
                                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" data-dialog-target="<?php echo $uniqueId; ?>">
                                                            <i class="lni lni-eye"></i>
                                                        </button>
                                                    <?php } ?>
                                                    <?php
                                                    // Generate the modal HTML
                                                    generateModalHtml($uniqueId, $statusResultRow);
                                                    ?>
                                                </th>
                                                <td class="px-4 py-2 text-left whitespace-nowrap <?php echo $style ?>"><?php echo $remarks ?></td>
                                                <td class="px-4 py-2 text-left whitespace-nowrap"><?php echo $statusResultRow['record_branch_area']; ?></td>
                                                <td class="px-4 py-2 text-left whitespace-nowrap"><?php echo $statusResultRow['record_input_date']->format('m/d/Y'); ?></td>
                                                <td class="px-4 py-2 text-left whitespace-nowrap"><?php echo $statusResultRow['record_branch']; ?></td>
                                                <td class="px-4 py-2 text-left whitespace-nowrap text-green-500"><?php echo $statusResultRow['record_cctv_working']; ?></td>
                                                <td class="px-4 py-2 text-left whitespace-nowrap text-red-500"><?php echo $statusResultRow['record_cctv_not_working']; ?></td>
                                                <td class="px-4 py-2 text-left whitespace-nowrap"><?php echo $statusResultRow['record_cctv_working'] + $statusResultRow['record_cctv_not_working']; ?></td>
                                                <td class="px-4 py-2 text-left whitespace-nowrap"><?php echo $statusResultRow['record_status']; ?></td>
                                                <td class="px-4 py-2 text-left whitespace-nowrap"><?php echo $statusResultRow['record_reason']; ?></td>
                                                <td class="px-4 py-2 text-left whitespace-nowrap"><?php echo $statusResultRow['record_cctv_name']; ?></td>
                                                <td class="px-4 py-2 text-left whitespace-nowrap"><?php echo $statusResultRow['record_serial_no']; ?></td>
                                            </tr>
                                            <?php
                                        } else {
                                            $allowedBranch = in_array($statusResultRow['record_store_code'], $user_branch);
                                            if ($allowedBranch) {
                                                $rowNumber++;
                                                $rowClass = $rowNumber % 2 === 0 ? 'bg-gray-200' : '';
                                                $uniqueId = 'modal_' . $rowNumber;
                                                $remarksCode = $statusResultRow['record_cctv_remarks'];
                                                $remarks = match ($remarksCode) {
                                                    0 => 'Complete',
                                                    1 => 'Incomplete - No picture',
                                                    2 => 'Incomplete - Picture Re-Used',
                                                    default => '',
                                                };
                                                $style = match ($remarksCode) {
                                                    0 => 'text-green-500',
                                                    1 => 'text-orange-500',
                                                    2 => 'text-red-500',
                                                    default => '',
                                                };
                                            ?>
                                                <tr class="<?php echo $rowClass; ?>">
                                                    <th scope="row" class="px-4 py-2 gap-1 flex text-left whitespace-nowrap">
                                                        <button onclick="openModal('<?php echo htmlspecialchars($statusResultRow['record_transac_id'], ENT_QUOTES); ?>')" class="<?php echo $user_type == 1 ? "hidden" : ''; ?> bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                                            <i class="lni lni-pencil"></i>
                                                        </button>
                                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" data-dialog-target="<?php echo $uniqueId; ?>">
                                                            <i class="lni lni-eye"></i>
                                                        </button>
                                                        <?php
                                                        // Generate the modal HTML
                                                        generateModalHtml($uniqueId, $statusResultRow);
                                                        ?>
                                                    </th>
                                                    <td class="px-4 py-2 text-left whitespace-nowrap"><?php echo $statusResultRow['record_branch_area']; ?></td>
                                                    <td class="px-4 py-2 text-left whitespace-nowrap"><?php echo $statusResultRow['record_input_date']->format('m/d/Y H:i:s A'); ?></td>
                                                    <td class="px-4 py-2 text-left whitespace-nowrap"><?php echo $statusResultRow['record_branch']; ?></td>
                                                    <td class="px-4 py-2 text-left whitespace-nowrap text-green-500"><?php echo $statusResultRow['record_cctv_working']; ?></td>
                                                    <td class="px-4 py-2 text-left whitespace-nowrap text-red-500"><?php echo $statusResultRow['record_cctv_not_working']; ?></td>
                                                    <td class="px-4 py-2 text-left whitespace-nowrap"><?php echo $statusResultRow['record_cctv_working'] + $statusResultRow['record_cctv_not_working']; ?></td>
                                                    <td class="px-4 py-2 text-left whitespace-nowrap <?php echo $style ?>"><?php echo $remarks ?></td>
                                                    <td class="px-4 py-2 text-left whitespace-nowrap"><?php echo $statusResultRow['record_input_by']; ?></td>
                                                    <td class="px-4 py-2 text-left whitespace-nowrap"><?php echo $statusResultRow['record_cctv_name']; ?></td>
                                                    <td class="px-4 py-2 text-left whitespace-nowrap"><?php echo $statusResultRow['record_serial_no']; ?></td>
                                                </tr>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <style>
                                .zoom-container {
                                    overflow: auto;
                                }

                                .zoom-image {
                                    transition: transform 0.3s;
                                }

                                .zoom-image.zoomed {
                                    transform: scale(2);
                                }
                            </style>

                            <script>
                                function downloadImage(filename) {
                                    const imgSrc = '../image_uploads/' + filename;
                                    const a = document.createElement('a');
                                    a.href = imgSrc;
                                    a.download = filename;
                                    a.click();
                                }

                                document.querySelectorAll('.zoom-container').forEach(container => {
                                    const zoomImage = container.querySelector('img');
                                    let zoomLevel = 1;
                                    let isZoomed = false;
                                    let startX = 0;
                                    let startY = 0;
                                    let translateX = 0;
                                    let translateY = 0;
                                    let isDragging = false;
                                    let touchStartX = 0;
                                    let touchStartY = 0;

                                    container.addEventListener('touchstart', (e) => {
                                        if (isZoomed) {
                                            e.preventDefault();
                                            touchStartX = e.touches[0].clientX;
                                            touchStartY = e.touches[0].clientY;
                                            isDragging = true;
                                        }
                                    }, {
                                        passive: false
                                    });

                                    container.addEventListener('touchmove', (e) => {
                                        if (isDragging) {
                                            e.preventDefault();
                                            const deltaX = e.touches[0].clientX - touchStartX;
                                            const deltaY = e.touches[0].clientY - touchStartY;
                                            translateX += deltaX;
                                            translateY += deltaY;
                                            touchStartX = e.touches[0].clientX;
                                            touchStartY = e.touches[0].clientY;
                                            zoomImage.style.transform = `scale(${zoomLevel}) translate(${translateX}px, ${translateY}px)`;
                                        }
                                    }, {
                                        passive: false
                                    });

                                    container.addEventListener('touchend', () => {
                                        isDragging = false;
                                    });

                                    container.addEventListener('touchcancel', () => {
                                        isDragging = false;
                                    });

                                    container.addEventListener('wheel', (e) => {
                                        e.preventDefault();
                                        if (e.deltaY > 0) {
                                            zoomLevel += 0.1;
                                        } else {
                                            zoomLevel -= 0.1;
                                        }
                                        zoomImage.style.transform = `scale(${zoomLevel}) translate(${translateX}px, ${translateY}px)`;
                                        if (zoomLevel > 1) {
                                            isZoomed = true;
                                            zoomImage.classList.add('zoomed');
                                        } else {
                                            isZoomed = false;
                                            zoomImage.classList.remove('zoomed');
                                        }
                                    }, {
                                        passive: false
                                    });

                                    container.addEventListener('dblclick', () => {
                                        if (isZoomed) {
                                            zoomLevel = 1;
                                            zoomImage.style.transform = `scale(${zoomLevel}) translate(${0}px, ${0}px)`;
                                            isZoomed = false;
                                            zoomImage.classList.remove('zoomed');
                                        } else {
                                            zoomLevel = 2;
                                            zoomImage.style.transform = `scale(${zoomLevel}) translate(${0}px, ${0}px)`;
                                            isZoomed = true;
                                            zoomImage.classList.add('zoomed');
                                        }
                                    });

                                    container.addEventListener('mousedown', (e) => {
                                        if (isZoomed) {
                                            startX = e.clientX;
                                            startY = e.clientY;
                                            isDragging = true;
                                        }
                                    });

                                    container.addEventListener('mousemove', (e) => {
                                        if (isDragging) {
                                            translateX += e.clientX - startX;
                                            translateY += e.clientY - startY;
                                            startX = e.clientX;
                                            startY = e.clientY;
                                            zoomImage.style.transform = `scale(${zoomLevel}) translate(${translateX}px, ${translateY}px)`;
                                        }
                                    });

                                    container.addEventListener('mouseup', () => {
                                        isDragging = false;
                                    });

                                    container.addEventListener('mouseleave', () => {
                                        isDragging = false;
                                    });
                                });
                            </script>
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
                                    <form class="mt-5 flex flex-wrap gap-4 p-0" action="../php/add_status.php" onsubmit="return isValid()" method="POST">
                                        <!-- form fields here -->
                                        <div class="mt-4 w-full md:w-[calc(50%-0.5rem)] lg:w-[calc(50%-0.5rem)] box-sizing border-box hidden">
                                            <label for="transac_id" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Transac ID</label>
                                            <input id="transac_id" name="transac_id" placeholder="XXXXXX or XXXXXXXXX" type="number" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                        </div>

                                        <div class="mt-4 w-full">
                                            <label for="add_status_branch" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Branch</label>
                                            <input readonly id="add_status_branch" name="add_status_branch" placeholder="Branch" type="text" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                        </div>

                                        <div class="mt-4 w-full <?php echo $user_type == 1 ? "hidden" : ''; ?>">
                                            <label for="remarks" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Area</label>
                                            <select id="remarks" name="remarks" class="block w-full px-3 py-2 mt-2 text-gray-600 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                                <option value="">Select an Option</option>
                                                <option value="0">Complete</option>
                                                <option value="1">Incomplete - No picture</option>
                                                <option value="2">Incomplete - Picture Reused</option>
                                            </select>
                                        </div>

                                        <div class="flex w-full justify-end mt-6">
                                            <button id="add_remarks_button" name="add_remarks_button" type="submit" class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
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
            add_remarks(id)
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

    <script src="https://unpkg.com/@material-tailwind/html@latest/scripts/dialog.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function add_remarks(id) {
            $.ajax({
                type: "GET",
                url: "../php/add_status.php",
                data: {
                    id: id
                }, // Pass the id as a data object
                dataType: "json", // Lowercase
                success: function(response) {
                    console.log("Success: ", response);

                    // Access userId from the returned data
                    var transac_id = id;

                    // Set values in the modal
                    $("#transac_id").val(transac_id);
                    $("#add_status_branch").val(response.record_branch);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching user data: ", status, error);
                }
            });
        }
    </script>
</body>

</html>