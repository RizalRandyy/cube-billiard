export const layoutAdminPage = $('#layoutAdminPage');
export const modalPoolTable = $('#modalPoolTable');
export const positionXInput = $('#positionX');
export const positionYInput = $('#positionY');

export const rows = 8;
export const cols = 5;
export const slotsAdminPage = {};

// Generate grid
for (let y = 0; y < cols; y++) {
  for (let x = 0; x < rows; x++) {
    const key = `${x},${y}`,
      isEntrance = x === 7 && y === 4;
    const slot = $('<div></div>')
      .addClass(
        `border-none w-[128px] h-[128px] flex items-center justify-center text-xs rounded ${isEntrance ? 'text-white font-bold' : 'bg-white hover:bg-blue-100 cursor-pointer'}`
      )
      .attr({
        'data-x': x,
        'data-y': y
      })
      // .text(isEntrance ? 'PINTU' : `(${x},${y})`);
      .text(isEntrance ? 'PINTU' : ``);

    if (!isEntrance) {
      slot.on('click', function () {
        const key = `${x},${y}`;
        const slotHasPoolTable = slotsAdminPage[key].find('[data-id]').length > 0;

        if (slotHasPoolTable) return; // Jangan buka form tambah jika sudah ada meja

        positionXInput.val(x);
        positionYInput.val(y);
        toggleModal(true);
      });
    } else {
      slot.html(
        '<span class="text-xs px-5 py-5 bg-green-600 rounded">PINTU</span>');
      slot.css('cursor', 'not-allowed');
    };

    slotsAdminPage[key] = slot;
    layoutAdminPage.append(slot);
  }
}