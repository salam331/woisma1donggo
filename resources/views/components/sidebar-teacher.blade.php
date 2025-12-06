<!-- Sidebar Teacher (MerakiUI Style) -->
<div class="flex flex-col w-64 h-screen px-4 py-6 overflow-y-auto bg-white border-r dark:bg-gray-900 dark:border-gray-700">
    
    <div class="flex items-center space-x-2 mb-8">
        <span class="text-xl font-bold text-primary">Teacher Panel</span>
    </div>

    <nav class="space-y-1">

        <!-- Dashboard -->
        <a href="{{ route('guru.dashboard') }}"
            class="flex items-center px-4 py-2 text-gray-700 transition-colors duration-200 rounded-lg hover:bg-gray-100 hover:text-primary dark:text-gray-300 dark:hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
            </svg>
            Dashboard
        </a>

        <!-- Attendances -->
        <a href="{{ url('/teacher/attendances') }}"
            class="flex items-center px-4 py-2 text-gray-700 transition-colors duration-200 rounded-lg hover:bg-gray-100 hover:text-primary dark:text-gray-300 dark:hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                <path d="M6 2a1 1 0 00-1 1v1H3.5A1.5 1.5 0 002 5.5v11A1.5 1.5 0 003.5 18h13a1.5 1.5 0 001.5-1.5v-11A1.5 1.5 0 0016.5 4H15V3a1 1 0 00-1-1H6zm8 4v2H6V6h8z" />
            </svg>
            Attendances
        </a>

        <!-- Materials -->
        <a href="{{ url('/teacher/materials') }}"
            class="flex items-center px-4 py-2 text-gray-700 rounded-lg transition-colors duration-200 hover:bg-gray-100 hover:text-primary dark:text-gray-300 dark:hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 20l9-5V9l-9-5-9 5v6l9 5z" />
            </svg>
            Materials
        </a>

        <!-- Grades -->
        <a href="{{ url('/teacher/grades') }}"
            class="flex items-center px-4 py-2 text-gray-700 rounded-lg transition-colors duration-200 hover:bg-gray-100 hover:text-primary dark:text-gray-300 dark:hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-6h6v6m2 4H7m10-12V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v4H5l7 7 7-7h-3z" />
            </svg>
            Grades
        </a>

        <!-- Exams -->
        <a href="{{ url('/teacher/exams') }}"
            class="flex items-center px-4 py-2 text-gray-700 rounded-lg transition-colors duration-200 hover:bg-gray-100 hover:text-primary dark:text-gray-300 dark:hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
            </svg>
            Exams
        </a>

        <!-- Announcements -->
        <a href="{{ url('/teacher/announcements') }}"
            class="flex items-center px-4 py-2 text-gray-700 rounded-lg transition-colors duration-200 hover:bg-gray-100 hover:text-primary dark:text-gray-300 dark:hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5l7 7-7 7" />
            </svg>
            Announcements
        </a>

    </nav>

</div>
