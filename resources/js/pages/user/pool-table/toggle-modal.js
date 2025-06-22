import { modal } from "./layout-grid";
import { formatPricePoolTable } from "../../../helpers/format-price";

window.toggleModalPoolTableUser = function (show = true) {
  const overlay = $('#modalOverlay'),
    content = $('#modalContent');
  if (show) {
    modal.removeClass('hidden');
    setTimeout(() => {
      overlay.removeClass('opacity-0').addClass('opacity-50');
      content.removeClass('opacity-0 scale-95').addClass('opacity-100 scale-100');
      // console.log($('#formBooking').attr('data-id'));
      $('.modal-title').text('Booking Meja ' + $('#formBooking').attr('data-name'));
      // console.log($('#formBooking').attr('data-name'));
      const rawPrice = $('#formBooking').attr('data-price_per_hour'); // ambil nilai atribut
      const formattedPrice = formatPricePoolTable(rawPrice); // format nilainya
      $('.price').text('Rp ' + formattedPrice); // tampilkan
      // console.log($('#formBooking').attr('data-price_per_hour'));
    }, 10);
  } else {
    overlay.removeClass('opacity-50').addClass('opacity-0');
    content.removeClass('opacity-100 scale-100').addClass('opacity-0 scale-95');
    setTimeout(() => {
      modal.addClass('hidden');
      $('#formBooking').removeAttr('data-id');
      $('#formBooking')[0].reset();
      $('.input-error-message').remove();
      $('#formBooking input, #formBooking select').removeClass(
        'border-red-600');
    }, 300);
  }
}

window.closeModalPoolTableUser = () => toggleModalPoolTableUser(false);
$('#modalOverlay').on('click', () => toggleModalPoolTableUser(false));