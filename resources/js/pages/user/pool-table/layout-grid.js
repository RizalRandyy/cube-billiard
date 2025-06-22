export const layout = $('#layout');
export const modal = $('#modal');
export const rows = 8;
export const cols = 5;
export const slots = {};

// Generate grid
for (let y = 0; y < cols; y++) {
  for (let x = 0; x < rows; x++) {
    const key = `${x},${y}`,
      isEntrance = x === 7 && y === 4;
    const slot = $('<div></div>')
      .addClass(
        `border-none w-[128px] h-[128px] flex items-center justify-center text-xs rounded ${isEntrance ? 'text-white font-bold' : 'bg-white'}`
      )
      .attr({
        'data-x': x,
        'data-y': y
      })
      // .text(isEntrance ? 'PINTU' : `(${x},${y})`);
      .text(isEntrance ? 'PINTU' : ``);


    if (isEntrance) {
      slot.html(
        '<span class="text-xs px-5 py-5 bg-green-600 rounded">PINTU</span>');
      slot.css('cursor', 'not-allowed');
    };

    slots[key] = slot;
    layout.append(slot);
  }
}