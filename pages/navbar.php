<?php
include '../php/auto_redirect.php';
if (!isset($_SESSION)) {
  session_start();
}
$user_fullname = $_SESSION['user_fullname'];
$user_designation = $_SESSION['user_designation'];
?>

<div class="md:flex flex-col md:flex-row md:min-h-screen shadow-2xl">
  <div @click.away="open = false" class="flex flex-col w-full md:w-64 text-gray-700 bg-white dark-mode:text-gray-200 dark-mode:bg-gray-800 flex-shrink-0" x-data="{ open: false }">
    <div class="flex-shrink-0 px-8 py-4 flex flex-row items-center justify-between">
      <a href="#" class="flex items-center text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">
        <img src="https://bonchon.sfo3.digitaloceanspaces.com/logo.png" alt="CCTV Monitoring" class="max-w-full h-auto w-6 md:w-8 lg:w-10 mr-2">
        <span>CCTV Monitoring</span>
      </a>
      <button class="rounded-lg md:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
        <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
          <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
          <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
      </button>
    </div>
    <nav :class="{'block': open, 'hidden': !open}" class="flex-grow md:block px-4 pb-4 md:pb-0 md:overflow-y-auto">
      <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="welcome_page.php">Home</a>
      <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="records.php">Records</a>
      <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline <?php echo $user_type == 1 ? "hidden" : ''; ?>" href="user.php">Users</a>
      <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline <?php echo $user_type == 1 ? "hidden" : ''; ?>" href="customize.php">Customize</a>

      <div :class="{'block': open, 'hidden':!open}" class="md:block md:absolute bottom-0 left-0 w-full md:w-64 py-4 bg-white dark-mode:bg-gray-800">
        <div class="flex items-center justify-between md:px-4 lg:px-4 items-center"> <!-- Add items-center here -->

          <div>
            <span class="truncate text-center px-4 py-2 mt-2 text-sm font-semibold text-gray-900 text-gray-700 dark-mode:text-gray-200 max-w-[250px]" title="<?php echo $user_fullname ?>">
              <?php echo $user_fullname ?>
            </span>
            <span class="truncate text-center px-4 py-2 mt-2 text-sm font-semibold text-gray-900 text-gray-700 dark-mode:text-gray-200 max-w-[250px]" title="<?php echo $user_fullname ?>">
              <?php echo $user_designation ?>
            </span>
          </div>

          <a href="../php/logout.php?logout=yes" onclick="return confirm('Log Out?')" class="bg-orange-500 px-4 py-2 mt-2 text-sm font-semibold text-gray-900 hover:bg-orange-700 text-white font-bold rounded">
            <i class="lni lni-exit"></i>
          </a>
        </div>
      </div>
    </nav>
  </div>
</div>