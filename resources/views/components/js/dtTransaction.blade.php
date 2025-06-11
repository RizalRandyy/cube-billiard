<script>
  $(document).ready(function () {
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
        url: '/transactions-data?page=' + page + '&search=' + searchQuery,
        method: 'GET',
        success: function (response) {
          let rows = '';

          if (response.data.length === 0) {
            rows = `
                <tr>
                    <td colspan="6" class="py-3 px-6 text-center">Data tidak ditemukan</td>
                </tr>
                `;
          } else {
            $.each(response.data, function (index, transaction) {
              let isLatestIcon = transaction.is_latest == 0 ? `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="red" d="M6.4 18.308l-.708-.708l5.6-5.6l-5.6-5.6l.708-.708l5.6 5.6l5.6-5.6l.708.708l-5.6 5.6l5.6 5.6l-.708.708l-5.6-5.6z"/></svg>`
                :
                `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                  <path fill="none" stroke="green" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l5 5l9-11"/></svg>`;

              let paymentStatus = transaction.payment_status == 'failed' ? `<span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">${transaction.payment_status}</span>` : `<span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">${transaction.payment_status}</span>`;


              rows += `
                        <tr class="border hover:bg-gray-100">
                              <td class="px-6 py-4 whitespace-nowrap">${transaction.booking_group_id}</td>
                              <td class="px-6 py-4 whitespace-nowrap">${transaction.booking_group?.user?.name ?? '-'}</td>
                              <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">${transaction.paid_at ?? '-'}</td>
                              <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">${transaction.midtrans_order_id}</td>
                              <td class="px-6 py-4 whitespace-nowrap">${transaction.payment_type}</td>
                              <td class="px-6 py-4 whitespace-nowrap">${formatRupiah(transaction.amount)}</td>
                              <td class="px-6 py-4 whitespace-nowrap">${paymentStatus}</td>
                              <td class="px-6 py-4 whitespace-nowrap">${isLatestIcon}</td>
                              <td class="px-6 py-4 whitespace-nowrap">
                                  <x-button target="" href="" class="justify-center max-w-sm gap-2 text-xs">
                                    Detail
                                  </x-button>
                              </td>
                              
                          </tr>
                          <tr id="details-${index}" class="hidden sm:hidden">
                              <td colspan="6" class="px-6 py-4">
                                  <div>
                                      <p><strong>Nama:</strong> ${transaction.booking_group_id}</p>
                                      <p><strong>Email:</strong> ${transaction.midtrans_order_id}</p>
                                      <p><strong>Nomor telepon:</strong> ${transaction.payment_status}</p>
                                      <p><strong>Role:</strong> ${transaction.payment_type}</p>
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

    $('#search').on('keyup', function () {
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


    $(document).on('click', '.pagination-btn', function () {
      page = parseInt($(this).data('page'));
      fetchtransactions(page, searchQuery);
    });

    $(window).on('resize', function () {
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

    $(document).on('click', '.deleteBtn', function (e) {
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
            success: function (response) {
              notyf.success(response.message || 'Data berhasil dihapus.');
              fetchtransactions(page, searchQuery);
            },
            error: function () {
              notyf.error('Gagal menghapus data.');
            }
          });
        }
      });
    });
  });
</script>