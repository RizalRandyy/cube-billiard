import { modalPoolTable } from "./layout-grid";

// Modal toggle
window.toggleModal = function (show = true) {
  const overlay = $('#modalOverlayPoolTable'),
    content = $('#modalContentPoolTable');
  if (show) {
    modalPoolTable.removeClass('hidden');
    setTimeout(() => {
      overlay.removeClass('opacity-0').addClass('opacity-50');
      content.removeClass('opacity-0 scale-95').addClass('opacity-100 scale-100');
      console.log($('#formMeja').attr('data-id'));
    }, 10);
  } else {
    overlay.removeClass('opacity-50').addClass('opacity-0');
    content.removeClass('opacity-100 scale-100').addClass('opacity-0 scale-95');
    setTimeout(() => {
      modalPoolTable.addClass('hidden');
      $('.modal-title').text('Tambah Meja Biliar');
      $('.delete-btn').addClass('invisible');
      $('#formMeja').removeAttr('data-id');
      $('#formMeja')[0].reset();
      $('.input-error-message').remove();
      $('#formMeja input, #formMeja select').removeClass(
        'border-red-600');
    }, 300);
  }
}