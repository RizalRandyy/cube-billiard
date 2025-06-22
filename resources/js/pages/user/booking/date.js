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