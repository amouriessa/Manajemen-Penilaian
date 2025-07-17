<div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="z-10 w-full max-w-md p-6 mx-auto bg-white rounded-lg shadow-xl dark:bg-gray-800">
        <div class="sm:flex sm:items-start">
            <div
                class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
                    {{ $title }}
                </h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $description }}
                    </p>
                </div>
            </div>
        </div>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
            <button type="button" id="confirmDeleteBtn"
                class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                Hapus
            </button>
            <button type="button" onclick="closeDeleteModal()"
                class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                Batal
            </button>
        </div>
    </div>
</div>
<script>
    // Delete User Modal Functions
    let currentUserId = null;

    function confirmDelete(userId) {
        currentUserId = userId;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('confirmDeleteBtn').addEventListener('click', executeDelete);
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('confirmDeleteBtn').removeEventListener('click', executeDelete);
        currentUserId = null;
    }

    function executeDelete() {
        if (currentUserId) {
            document.getElementById(`delete-form-${currentUserId}`).submit();
        }
    }
</script>
