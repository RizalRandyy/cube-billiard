<script>
  $(document).ready(function () {
    const unavailableBookings = @json($unavailableBookings);
    const bookings = @json($bookings);
    renderDateButtons(new Date());

    flatpickr("#calendar-wrapper", {
      wrap: true,
      allowInput: true,
      clickOpens: true,
      locale: Indonesian,
      dateFormat: "d-m-Y",
      minDate: "today",
      maxDate: new Date().fp_incr(1),
      position: "below",
      onChange: function (selectedDates) {
        if (selectedDates.length) {
          renderDateButtons(selectedDates[0]);
        }
      }
    });

    function renderDateButtons(startDate) {
      const $container = $("#date-buttons");
      $container.empty();

      const days = ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];

      for (let i = 0; i < 7; i++) {
        const date = new Date(startDate);
        date.setDate(date.getDate() + i);

        const dayName = days[date.getDay()];
        const dayDate = date.getDate();
        const monthShort = date.toLocaleString("id-ID", {
          month: "short"
        });

        const isoDate = date.toLocaleDateString('sv-SE'); // Format: YYYY-MM-DD

        const $btn = $("<button></button>")
          .addClass(
            "flex flex-col items-center px-2 md:px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100"
          )
          .attr("data-date", isoDate)
          .html(
            `<span class="text-xs md:text-sm">${dayName}</span><span class="text-xs md:text-base font-semibold">${dayDate} ${monthShort}</span>`
          );

        if (i === 0) {
          $btn
            .removeClass("text-gray-700 hover:bg-gray-100")
            .addClass("bg-[#1C3F3A] text-white font-semibold hover:bg-[#1C3F3A] active-date");
        }

        $btn.on("click", function () {
          $("#date-buttons button")
            .removeClass(
              "bg-[#1C3F3A] text-white font-semibold active-date hover:bg-[#1C3F3A]")
            .addClass("text-gray-700 hover:bg-gray-100");

          $(this)
            .removeClass("text-gray-700 hover:bg-gray-100")
            .addClass(
              "bg-[#1C3F3A] text-white font-semibold hover:bg-[#1C3F3A] active-date");
          console.log($(this).attr("data-date"));
        });

        $container.append($btn);
      }
    }

    function normalizeTime(t) {
      return t.length === 5 ? t : t.slice(0, 5); // '13:00:00' → '13:00'
    }

    function isTimeOverlap(slotStart, slotEnd, bookingStart, bookingEnd) {
      const sStart = normalizeTime(slotStart);
      const sEnd = normalizeTime(slotEnd);
      const bStart = normalizeTime(bookingStart);
      const bEnd = normalizeTime(bookingEnd);

      return sStart < bEnd && sEnd > bStart;
    }

    window.renderTimeSlots = function () {
      const startHour = 9;
      const endHour = 21;
      const $timeSlots = $('#timeSlots');
      $timeSlots.empty();

      const tableId = parseInt($('#formBooking').attr('data-id'), 10);
      const date = $('.active-date').data('date'); // Format: YYYY-MM-DD

      for (let i = startHour; i < endHour; i++) {
        const start = `${String(i).padStart(2, '0')}:00`;
        const end = `${String(i + 1).padStart(2, '0')}:00`;
        const timeRange = `${start} - ${end}`;

        // Cek apakah slot ini sudah lewat (hanya untuk hari ini)
        const now = new Date();
        const selectedDate = new Date(date);
        const slotStartTime = new Date(`${date}T${start}:00`);
        const isPast = selectedDate.toDateString() === now.toDateString() && slotStartTime <= now;

        // Cek apakah slot ini sudah dibooking oleh orang lain
        const isUnavailable = unavailableBookings.some(b => {
          return (
            b.booking_date === date &&
            parseInt(b.pool_table_id) === tableId &&
            isTimeOverlap(start, end, b.start_time, b.end_time)
          );
        });

        // Cek jika user sendiri sudah punya booking di waktu yang sama
        const isDoubleBooked = bookings.some(b => {
          return (
            b.booking_date === date &&
            parseInt(b.pool_table_id) == tableId && // hanya disable meja yang dipilih
            isTimeOverlap(start, end, b.start_time, b.end_time)
          );
        });

        const shouldDisable = isUnavailable || isPast || isDoubleBooked;
        const disabledAttr = shouldDisable ? 'disabled' : '';
        const disabledClass = shouldDisable ?
          'bg-gray-300 text-gray-500 cursor-not-allowed' :
          'hover:bg-gray-100 text-gray-700';

        $timeSlots.append(`
                                    <button 
                                        type="button" 
                                        class="time-btn border rounded-lg p-2 md:p-4 text-center transition w-full ${disabledClass}" 
                                        data-time="${timeRange}" ${disabledAttr}>
                                        <p class="text-xs mb-1">60 Menit</p>
                                        <p class="font-bold text-sm">${timeRange}</p>
                                        <p class="price text-sm">Rp</p>
                                    </button>
                                `);
      }
    }


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

  });
</script>