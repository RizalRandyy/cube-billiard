<script>
    $(document).ready(function() {
        let page = 1;
        let lastPage = 1;
        let searchQuery = '';

        function fetchtransactions(page, searchQuery = '') {
            function formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(number);
            }

            $.ajax({
                url: '/payment-history-data?page=' + page + '&search=' + searchQuery,
                method: 'GET',
                success: function(response) {
                    let rows = '';

                    if (response.data.length === 0) {
                        rows = `
                <tr>
                    <td colspan="8" class="py-3 px-6 text-center">Data tidak ditemukan</td>
                </tr>
                `;
                    } else {
                        $.each(response.data, function(index, transaction) {
                            let isLatestIcon = transaction.is_latest == 0 ?
                                `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="red" d="M6.4 18.308l-.708-.708l5.6-5.6l-5.6-5.6l.708-.708l5.6 5.6l5.6-5.6l.708.708l-5.6 5.6l5.6 5.6l-.708.708l-5.6-5.6z"/></svg>` :
                                `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                  <path fill="none" stroke="green" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l5 5l9-11"/></svg>`;

                            let paymentStatus;
                            if (transaction.payment_status == 'failed') {
                                paymentStatus =
                                    `<span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">${transaction.payment_status}</span>`;
                            } else if (transaction.payment_status == 'pending') {
                                paymentStatus =
                                    `<span class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-yellow-900 dark:text-yellow-300">${transaction.payment_status}</span>`;
                            } else {
                                paymentStatus =
                                    `<span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">${transaction.payment_status}</span>`;
                            }

                            const detailRouteBase =
                                "{{ route('user.paymentHistory.show', ['transaction' => 'REPLACE_ID']) }}";
                            const href = detailRouteBase.replace('REPLACE_ID', transaction
                                .id);

                            rows += `
                        <tr class="border hover:bg-gray-100">
                              <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">${transaction.booking_group_id}</td>
                              <td class="px-6 py-4 whitespace-nowrap">${transaction.paid_at ?? '-'}</td>
                              <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">${transaction.midtrans_order_id}</td>
                              <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">${transaction.payment_type}</td>
                              <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">${formatRupiah(transaction.amount)}</td>
                              <td class="px-6 py-4 whitespace-nowrap">${paymentStatus}</td>
                              <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">${isLatestIcon}</td>
                              <td class="px-6 py-4 whitespace-nowrap">
                                  <x-button target="" href="${href}" class="justify-center max-w-sm gap-2 text-xs">
                                    Detail
                                  </x-button>
                                  <button onclick="toggleDetails(${index})" class="bg-green-800 text-white p-2 rounded sm:hidden">
                                    <x-icons.chevron-down class="w-3 h-3"></x-icons.chevron-down>
                                  </button>
                              </td>
                              
                          </tr>
                          <tr id="details-${index}" class="hidden sm:hidden">
                              <td colspan="6" class="px-6 py-4">
                                  <div>
                                      <p><strong>Id:</strong> ${transaction.booking_group_id}</p>
                                      <p><strong>Tanggal Pembayaran:</strong> ${transaction.paid_at ?? '-'}</p>
                                      <p><strong>Order Id:</strong> ${transaction.midtrans_order_id}</p>
                                      <p><strong>Metode Pembayaran:</strong> ${transaction.payment_type}</p>
                                      <p><strong>Total Pembayaran:</strong> ${formatRupiah(transaction.amount)}</p>
                                      <p><strong>Status:</strong> ${paymentStatus}</p>
                                      <div class="flex">
                                        <p><strong>Pembayaran Terakhir: </strong></p>
                                        ${isLatestIcon}
                                      </div>
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

        fetchtransactions(page);

        $('#search').on('keyup', function() {
            searchQuery = $(this).val();
            page = 1;
            fetchtransactions(page, searchQuery);
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
            fetchtransactions(page, searchQuery);
        });

        $(window).on('resize', function() {
            generatePaginationButtons(page, lastPage);
        });
    });
</script>
