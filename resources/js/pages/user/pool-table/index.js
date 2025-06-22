import '../booking/date.js'
import '../booking/render-date-buttons.js'; 
import '../booking/render-time-slots.js'; 
import './render.js'; 
import './assign-value.js';
import './toggle-modal.js';
import { fetchInitialData } from './fetch-data.js';

$(function () {
  window.unavailableBookingsPoolTableUser = window.Laravel.unavailableBookingsPoolTableUser;
  window.bookingsPoolTableUser = window.Laravel.bookingsPoolTableUser;

  renderDateButtons(new Date());

  fetchInitialData();

  // Toggle button selection
  $(document).on('click', '.time-btn:not([disabled])', function () {
    $(this).toggleClass('bg-[#1C3F3A] text-white border-none active hover:bg-[#1C3F3A]')
      .toggleClass('text-gray-700 hover:bg-gray-100');

    $(this).find('p')
      .toggleClass('text-white')
      .toggleClass('text-gray-700 text-gray-500');

    // Ambil semua waktu yang dipilih
    const selectedTimes = $('.time-btn.active').map(function () {
      return $(this).data('time');
    }).get(); // .get() untuk ubah ke array JavaScript biasa

    // Update input hidden
    // Bersihkan input lama
    $('#formBooking input[name="selected_time[]"]').remove();

    selectedTimes.forEach(time => {
      $('#formBooking').append(
        `<input type="hidden" name="selected_time[]" value="${time}">`
      );
    });

    // Ambil informasi dari tombol yang diklik
    const tableId = $('#formBooking').attr('data-id');
    const date = $('.active-date').data('date');

    // Isi input hidden yang lain
    $('#pool_table_id').val(tableId);
    $('#booking_date').val(date);
    $('#start_time').val(selectedTimes[0] || '');
    $('#end_time').val(selectedTimes[selectedTimes.length - 1] || '');

    console.log("Jam dipilih:", selectedTimes);
  });
})