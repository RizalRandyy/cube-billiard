<script>
    $(document).ready(function() {
        let page = 1;
        let lastPage = 1;
        let searchQuery = '';
        let id = $('#bookingGroupId').val();

        const formatTime = (timeString) => {
            if (!timeString) return '-';
            return timeString.split(':').slice(0, 2).join(':'); // Ambil jam dan menit
        };

        function fetchbookedtables(page, searchQuery = '') {

            $.ajax({
                url: '/booked-tables-user-data/' + id + '?page=' + page + '&search=' + searchQuery,
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
                        $.each(response.data, function(index, booking) {
                            rows += `
                        <tr class="border hover:bg-gray-100">
                              <td class="px-6 py-4 whitespace-nowrap">${booking.pool_table?.name ?? '-'}</td>
                              <td class="px-6 py-4 whitespace-nowrap">${booking.booking_date}</td>
                              <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">${formatTime(booking.start_time)} - ${formatTime(booking.end_time)}</td>
                              <td class="px-6 py-4 whitespace-nowrap md:hidden">
                                <button onclick="toggleDetails(${index})" class="bg-green-800 text-white p-2 rounded sm:hidden">
                                    <x-icons.chevron-down class="w-3 h-3"></x-icons.chevron-down>
                                  </button>
                                </td>
                              
                          </tr>
                          <tr id="details-${index}" class="hidden sm:hidden">
                              <td colspan="6" class="px-6 py-4">
                                  <div>
                                      <p><strong>Id Meja:</strong> ${booking.pool_table_id}</p>
                                      <p><strong>Nama Meja:</strong> ${booking.pool_table?.name ?? '-'}</p>
                                      <p><strong>Tanggal Booking:</strong> ${booking.booking_date}</p>
                                      <p><strong>Jam Mulai:</strong> ${booking.start_time}</p>
                                      <p><strong>Jam Selesai:</strong> ${booking.end_time}</p>
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

        fetchbookedtables(page);

        $('#search').on('keyup', function() {
            searchQuery = $(this).val();
            page = 1;
            fetchbookedtables(page, searchQuery);
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
            fetchbookedtables(page, searchQuery);
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
                            notyf.success(response.message ||
                                'Data berhasil dihapus.');
                            fetchbookedtables(page, searchQuery);
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
