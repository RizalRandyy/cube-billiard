<script>
    $(document).ready(function() {
        // Ambil data awal
        $.get('/pool-tables-data', data => {
            data.forEach(item => renderPoolTables(item.name, item.x, item.y, item.orientation, item.id,
                item.price_per_hour, item.status));
        });

        const layout = $('#layout'),
            modal = $('#modal'),
            rows = 8,
            cols = 5,
            slots = {};

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

        // Render meja
        function renderPoolTables(name, x, y, orientation, id = null, price = '', status = '') {
            const key = `${x},${y}`;
            const slot = slots[key];

            slot.empty().removeClass().addClass('relative w-[128px] h-[128px]');

            const picture = status == '1' ? 'meja-biru-horizontal.png' : 'meja-putih-horizontal.png';

            const clickable = status != 0 ? `onclick="bookingMeja(this)"` : '';

            const wrapper = $(`
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 
                                    flex cursor-pointer w-[96px] h-[48px] ${orientation === 'vertical' ? 'rotate-90' : ''}"
                            data-id="${id}" data-name="${name}" data-x="${x}" data-y="${y}" data-orientation="${orientation}" 
                            data-price_per_hour="${parseInt(price)}" data-status="${status}" ${clickable}>
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

        // Function booking meja
        window.bookingMeja = function(el) {
            const $el = $(el);
            $('#formBooking').attr('data-id', $el.data('id'));
            $('#formBooking').attr('data-name', $el.data('name'));
            $('#formBooking').attr('data-price_per_hour', $el.data('price_per_hour'));
            renderTimeSlots();
            toggleModal(true);
        }

        function toggleModal(show = true) {
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
                    const formattedPrice = formatPrice(rawPrice); // format nilainya
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

        window.closeModal = () => toggleModal(false);
        $('#modalOverlay').on('click', () => toggleModal(false));

        const notyf = new Notyf({
            duration: 3000,
            ripple: true,
            dismissible: true,
            position: {
                x: 'center',
                y: 'top'
            }
        });

        // Format price function
        function formatPrice(value) {
            if (typeof value === 'string') {
                value = value.replace(/[^\d]/g, '');
            }
            const number = parseInt(value, 10);
            if (isNaN(number)) return '';
            return number.toLocaleString('id-ID');
        }
    });
</script>
