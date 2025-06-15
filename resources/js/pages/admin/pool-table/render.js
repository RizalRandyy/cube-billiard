import { slotsAdminPage } from "./layout-grid";

// Render meja
window.renderPoolTables = function(name, x, y, orientation, id = null, price = '', status = '') {
  const key = `${x},${y}`;
  const slot = slotsAdminPage[key];

  slot.empty().removeClass().addClass('relative w-[128px] h-[128px]');

  const picture = status == '1' ? 'meja-biru-horizontal.png' : 'meja-putih-horizontal.png';

  const wrapper = $(`
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 
                                    flex cursor-pointer w-[96px] h-[48px] ${orientation === 'vertical' ? 'rotate-90' : ''}"
                            data-id="${id}" data-name="${name}" data-x="${x}" data-y="${y}" data-orientation="${orientation}" 
                            data-price_per_hour="${parseInt(price)}" data-status="${status}" onclick="editMeja(this)">
                            <img src="/assets/images/${picture}" alt="${name}" class="object-contain w-full h-full">
                        </div>
                    `);

  const label = $(`
                        <div class="absolute top-1 left-1 bg-black bg-opacity-50 text-white text-xs px-1 rounded pointer-events-none">
                            ${name}
                        </div>
                    `);

  slot.append(wrapper).append(label);
}