<script>
    $(document).ready(function() {
        let page = 1;
        let lastPage = 1;
        let searchQuery = '';

        function fetchusers(page, searchQuery = '') {

            $.ajax({
                url: '/users-data?page=' + page + '&search=' + searchQuery,
                method: 'GET',
                success: function(response) {
                    let rows = '';

                    if (response.data.length === 0) {
                        rows = `
                <tr>
                    <td colspan="6" class="py-3 px-6 text-center">Data tidak ditemukan</td>
                </tr>
                `;
                    } else {
                        $.each(response.data, function(index, user) {
                            let roles = user.roles.map(role => role.name).join(', ');

                            rows += `
                        <tr class="border hover:bg-gray-100">
                              <td class="px-6 py-4 whitespace-nowrap">${user.name}</td>
                              <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">${user.email}</td>
                              <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">${user.phone}</td>
                              <td class="px-6 py-4 whitespace-nowrap">${roles}</td>
                              <td class="px-6 py-4 whitespace-nowrap">
                                  <x-button target="" href="/admin/users/${user.id}/edit" variant="warning" class="justify-center max-w-sm gap-2">
                                    <x-icons.pencil class="w-3 h-3"></x-icons.pencil>
                                  </x-button>
                                  <!-- Destroy form -->
                                      <form action="/admin/users/${user.id}" method="POST" class="inline-block deleteForm">
                                          @csrf
                                          @method('DELETE')
                                        <x-button variant="danger" class="justify-center max-w-sm gap-2 deleteBtn">
                                            <x-icons.trash class="w-3 h-3"></x-icons.trash>
                                        </x-button>
                                      </form>
                                  <button onclick="toggleDetails(${index})" class="bg-green-800 text-white p-2 rounded sm:hidden">
                                    <x-icons.chevron-down class="w-3 h-3"></x-icons.chevron-down>
                                  </button>
                              </td>
                          </tr>
                          <tr id="details-${index}" class="hidden sm:hidden">
                              <td colspan="6" class="px-6 py-4">
                                  <div>
                                      <p><strong>Nama:</strong> ${user.name}</p>
                                      <p><strong>Email:</strong> ${user.email}</p>
                                      <p><strong>Nomor telepon:</strong> ${user.phone}</p>
                                      <p><strong>Role:</strong> ${roles}</p>
                                  </div>
                              </td>
                          </tr>
                    `;
                        });


                    }
                    $('#itemTable').html(rows);

                    lastPage = response.last_page;

                    $('#currentPage').text(page);

                    generatePaginationButtons(page, lastPage);
                }
            });
        }

        fetchusers(page);

        $('#search').on('keyup', function() {
            searchQuery = $(this).val();
            page = 1;
            fetchusers(page, searchQuery);
        });

        function generatePaginationButtons(page, lastPage) {
            let paginationButtons = '';
            let maxButtons = window.innerWidth <= 640 ? 5 : 10;
            let half = Math.floor(maxButtons / 2);

            let startPage = Math.max(1, page - half);
            let endPage = Math.min(lastPage, page + half);

            if (endPage - startPage + 1 < maxButtons) {
                if (startPage === 1) {
                    endPage = Math.min(lastPage, startPage + maxButtons - 1);
                } else if (endPage === lastPage) {
                    startPage = Math.max(1, endPage - maxButtons + 1);
                }
            }

            for (let i = startPage; i <= endPage; i++) {
                paginationButtons += `
            <button class="pagination-btn ${i === page ? 'bg-black text-white' : 'bg-gray-200 text-gray-700'} px-3 py-1 rounded hover:bg-black hover:text-white" data-page="${i}">
                ${i}
            </button>
        `;
            }

            $('#paginationNumbers').html(paginationButtons);
        }


        $(document).on('click', '.pagination-btn', function() {
            page = parseInt($(this).data('page'));
            fetchusers(page, searchQuery);
        });

        $(window).on('resize', function() {
            generatePaginationButtons(page, lastPage);
        });

        const notyf = new Notyf({
            duration: 3000,
            ripple: true,
            dismissible: true,
            position: {
                x: 'center',
                y: 'top',
            }
        });

        $(document).on('click', '.deleteBtn', function(e) {
            e.preventDefault();

            const form = $(this).closest('form');
            const actionUrl = form.attr('action');

            Swal.fire({
                title: 'Hapus Data?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                focusCancel: true,
                background: '#fff',
                color: '#111827',
                customClass: {
                    popup: 'rounded-xl shadow-lg px-6 py-4',
                    confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg focus:outline-none mr-5',
                    cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg focus:outline-none',
                    title: 'text-lg font-bold',
                    htmlContainer: 'text-sm',
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: actionUrl,
                        type: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            notyf.success(response.message || 'Data berhasil dihapus.');
                            fetchusers(page, searchQuery);
                        },
                        error: function() {
                            notyf.error('Gagal menghapus data.');
                        }
                    });
                }
            });
        });
    });
</script>
