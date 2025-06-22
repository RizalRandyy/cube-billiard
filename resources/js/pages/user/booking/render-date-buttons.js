window.renderDateButtons = function (startDate) {
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