<?php
include '../php/fetch_dashboard.php';
include '../php/fetch_branch.php';

if (!isset($_SESSION)) {
    session_start();
}
$user_branch = $_SESSION['user_branches'];

$user_type = $_SESSION['user_type'];

$working_count = 0;
$not_working_count = 0;

foreach ($working_data as $working_data_row) {
    $working_count += $working_data_row['record_cctv_working'];
    $not_working_count += $working_data_row['record_cctv_not_working'];
}
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
        <div class=" main container mx-auto px-4 py-8 overflow-auto max-h-screen">
            <!-- Flexbox container -->
            <div class="flex flex-wrap gap-4 justify-center">
                <div class="w-full">
                    <div class="bg-white p-4 shadow-md rounded-lg component flex flex-1 items-center gap-4">
                        <h2 class="text-lg font-semibold flex-1 mr-2 mb-2">Home</h2>
                        <!-- The button that triggers the dropdown -->
                        <div x-data="{ modelOpen: false }">
                            <button @click="modelOpen =!modelOpen" class="gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 flex items-center">
                                <i class="lni lni-search-alt"></i> Search
                            </button>

                            <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                    <div x-cloak @click="modelOpen = false" x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

                                    <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                                        <div class="flex items-center justify-between space-x-4 mb-5">
                                            <h1 class="text-xl font-medium text-gray-800 ">Search</h1>
                                            <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </div>

                                        <form class="mt-5 flex flex-wrap gap-4 p-0" onsubmit="return isValid()" method="POST">
                                            <div class="mt-4 w-full <?php echo $user_type == 1 && count($user_branch) == 1 ? 'hidden' : '' ?>">
                                                <label for="dashbaord_branch" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Branch</label>
                                                <select id="dashbaord_branch" name="dashbaord_branch" class="block w-full px-3 py-2 mt-2 text-gray-600 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40 <?php echo $user_type == 1 && count($user_branch) == 1 ? '' : 'required' ?>">
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

                                            <div class="mt-4 w-full">
                                                <label for="date" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Date</label>
                                                <input id="date" name="date" placeholder="Date" type="date" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            </div>

                                            <div class="flex w-full justify-end mt-6">
                                                <button id="dashboard_button" name="dashboard_button" type="submit" class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
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

                <div class="<?php echo $user_type == 1 ? 'hidden' : '' ?> grid lg:grid-cols-3 md:grid-cols-1 gap-6 w-full text-gray-800 dark:bg-gray-800 p-4 md:p-6 bg-gray-200 h-fit shadow-md component border-t-2 border-slate-50 rounded-lg">
                    <div class="flex items-center p-4 bg-white rounded">
                        <div class="flex flex-shrink-0 items-center justify-center bg-green-200 h-16 w-16 rounded">
                            <svg class="w-6 h-6 fill-current text-green-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-grow flex flex-col ml-4">
                            <span class="text-xl font-bold"><?php echo $working_count; ?></span>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500">Working Camera</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-white rounded">
                        <div class="flex flex-shrink-0 items-center justify-center bg-red-200 h-16 w-16 rounded">
                            <svg class="w-6 h-6 fill-current text-red-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-grow flex flex-col ml-4">
                            <span class="text-xl font-bold"><?php echo $not_working_count; ?></span>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500">Non Working Camera</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-white rounded">
                        <div class="flex flex-shrink-0 items-center justify-center bg-blue-200 h-16 w-16 rounded">
                            <svg class="w-6 h-6 fill-current text-blue-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-grow flex flex-col ml-4">
                            <span class="text-xl font-bold"><?php echo $compliant_count . '/' . $branch_count; ?></span>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500">Compliant Stores</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-md component h-fit w-full overflow-auto border-t-2 border-slate-50">
                    <h2 class=" text-lg font-semibold bg-gray-200 py-2 text-center rounded-t-lg">CCTV Report</h2>
                    <div class="w-full bg-white dark:bg-gray-800 p-4 md:p-6">
                        <div id="column-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        const dashboard_data = '<?php echo $dashboard_data; ?>';
        const dashboard = JSON.parse(dashboard_data);

        const options = {
            colors: ["#1A56DB", "#FDBA8C"],
            title: {
                text: "<?php echo $branch_name_new ?>",
                align: "center",
                style: {
                    fontSize: "18px",
                    fontWeight: "bold",
                    color: "#333"
                }
            },
            series: [{
                    name: "Working",
                    color: "#1A56DB",
                    data: [{
                            x: dashboard[0][0],
                            y: dashboard[0][1]
                        },
                        {
                            x: dashboard[1][0],
                            y: dashboard[1][1]
                        },
                        {
                            x: dashboard[2][0],
                            y: dashboard[2][1]
                        },
                        {
                            x: dashboard[3][0],
                            y: dashboard[3][1]
                        },
                        {
                            x: dashboard[4][0],
                            y: dashboard[4][1]
                        },
                        {
                            x: dashboard[5][0],
                            y: dashboard[5][1]
                        },
                        {
                            x: dashboard[6][0],
                            y: dashboard[6][1]
                        },
                    ],
                },
                {
                    name: "Non Working",
                    color: "#FDBA8C",
                    data: [{
                            x: dashboard[0][0],
                            y: dashboard[0][2]
                        },
                        {
                            x: dashboard[1][0],
                            y: dashboard[1][2]
                        },
                        {
                            x: dashboard[2][0],
                            y: dashboard[2][2]
                        },
                        {
                            x: dashboard[3][0],
                            y: dashboard[3][2]
                        },
                        {
                            x: dashboard[4][0],
                            y: dashboard[4][2]
                        },
                        {
                            x: dashboard[5][0],
                            y: dashboard[5][2]
                        },
                        {
                            x: dashboard[6][0],
                            y: dashboard[6][2]
                        },
                    ],
                },
            ],
            chart: {
                type: "bar",
                height: "320px",
                fontFamily: "Inter, sans-serif",
                toolbar: {
                    show: true,
                },
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "70%",
                    borderRadiusApplication: "end",
                    borderRadius: 8,
                },
            },
            tooltip: {
                shared: true,
                intersect: false,
                style: {
                    fontFamily: "Inter, sans-serif",
                },
            },
            states: {
                hover: {
                    filter: {
                        type: "darken",
                        value: 1,
                    },
                },
            },
            stroke: {
                show: true,
                width: 0,
                colors: ["transparent"],
            },
            grid: {
                show: true,
                strokeDashArray: 4,
                padding: {
                    left: 2,
                    right: 2,
                    top: -14
                },
            },
            dataLabels: {
                enabled: true,
            },
            legend: {
                show: true,
                formatter: function(seriesName, opts) {
                    return '<b>' + seriesName + '</b>';
                },
            },
            xaxis: {
                floating: false,
                labels: {
                    show: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                    }
                },
                axisBorder: {
                    show: true,
                },
                axisTicks: {
                    show: true,
                },
            },
            yaxis: {
                show: true,
            },
            fill: {
                opacity: 1,
            },
        }

        if (document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("column-chart"), options);
            chart.render();
        }
    </script>
</body>

</html>