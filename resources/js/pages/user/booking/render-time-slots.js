
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
    const isUnavailable = unavailableBookingsPoolTableUser.some(b => {
      return (
        b.booking_date === date &&
        parseInt(b.pool_table_id) === tableId &&
        isTimeOverlap(start, end, b.start_time, b.end_time)
      );
    });

    // Cek jika user sendiri sudah punya booking di waktu yang sama
    const isDoubleBooked = bookingsPoolTableUser.some(b => {
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