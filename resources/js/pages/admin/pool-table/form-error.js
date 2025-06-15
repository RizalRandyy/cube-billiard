window.showFormPoolTableErrors = function(errors) {
  // Hapus error sebelumnya
  $('.input-error-message').remove();

  Object.keys(errors).forEach(key => {
    const messages = errors[key];
    const input = $(`[name="${key}"]`);
    if (input.length > 0) {
      const errorEl = $(
        `<p class="text-red-600 text-sm mt-1 input-error-message">${messages[0]}</p>`
      );
      input.addClass('border-red-600'); // tandai input error
      input.after(errorEl);
    }
  });
}