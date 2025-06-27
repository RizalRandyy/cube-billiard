import './bootstrap';
import 'flowbite';
import Alpine from 'alpinejs';
import $ from 'jquery';
import PerfectScrollbar from 'perfect-scrollbar'
import collapse from '@alpinejs/collapse'
import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';
import Swal from 'sweetalert2';
import "flatpickr/dist/flatpickr.min.css";
import { Indonesian } from "flatpickr/dist/l10n/id.js";
import flatpickr from "flatpickr";
import Chart from 'chart.js/auto';

import { SwalDeleteUser, SwalResetPasswordUser, SwalDeletePoolTableAdmin, SwalPaymentInfo } from './helpers/swal';
import { slotsAdminPage } from './pages/admin/pool-table/layout-grid';
import { formatPricePoolTable } from './helpers/format-price';
import { normalizeTime } from './helpers/normalize-time';
import { isTimeOverlap } from './helpers/is-time-overlap';

window.Chart = Chart;

window.Flatpickr = flatpickr;

window.Indonesian = Indonesian;

window.Swal = Swal;

window.SwalDeleteUser = SwalDeleteUser;

window.SwalResetPasswordUser = SwalResetPasswordUser;

window.SwalDeletePoolTableAdmin = SwalDeletePoolTableAdmin;

window.SwalPaymentInfo = SwalPaymentInfo

window.PerfectScrollbar = PerfectScrollbar;

window.slotsAdminPage = slotsAdminPage;

window.formatPricePoolTable = formatPricePoolTable;

window.normalizeTime = normalizeTime;

window.isTimeOverlap = isTimeOverlap;

window.$ = $;

window.jQuery = $;

window.Notyf = Notyf;

window.notyf = new Notyf({
    duration: 3000,
    ripple: true,
    dismissible: true,
    position: {
        x: 'center',
        y: 'top',
    }
});

window.addEventListener('DOMContentLoaded', () => {
    if (window.flashMessage) {
        window.notyf.success(window.flashMessage);
    }
});


document.addEventListener('alpine:init', () => {
    Alpine.data('mainState', () => {
        let lastScrollTop = 0
        const init = function () {
            window.addEventListener('scroll', () => {
                let st =
                    window.pageYOffset || document.documentElement.scrollTop
                if (st > lastScrollTop) {
                    // downscroll
                    this.scrollingDown = true
                    this.scrollingUp = false
                } else {
                    // upscroll
                    this.scrollingDown = false
                    this.scrollingUp = true
                    if (st == 0) {
                        //  reset
                        this.scrollingDown = false
                        this.scrollingUp = false
                    }
                }
                lastScrollTop = st <= 0 ? 0 : st // For Mobile or negative scrolling
            })
        }

        return {
            init,
            isSidebarOpen: window.innerWidth > 1024,
            isSidebarHovered: false,
            handleSidebarHover(value) {
                if (window.innerWidth < 1024) {
                    return
                }
                this.isSidebarHovered = value
            },
            handleWindowResize() {
                if (window.innerWidth <= 1024) {
                    this.isSidebarOpen = false
                } else {
                    this.isSidebarOpen = true
                }
            },
            scrollingDown: false,
            scrollingUp: false,
        }
    })
})

Alpine.plugin(collapse)

Alpine.start();
