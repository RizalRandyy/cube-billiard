// Function assign value booking meja
window.bookingMeja = function (el) {
  const $el = $(el);
  $('#formBooking').attr('data-id', $el.data('id'));
  $('#formBooking').attr('data-name', $el.data('name'));
  $('#formBooking').attr('data-price_per_hour', $el.data('price_per_hour'));
  renderTimeSlots();
  toggleModalPoolTableUser(true);
}