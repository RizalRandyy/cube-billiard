import Swal from "sweetalert2";

export const SwalDeleteUser = () => {
  return Swal.fire({
    title: 'Hapus Data?',
    text: 'Data yang dihapus tidak dapat dikembalikan.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal',
    focusCancel: true,
    background: '#fff',
    color: '#111827',
    customClass: {
      popup: 'rounded-xl shadow-lg px-6 py-4',
      confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg focus:outline-none mr-5',
      cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg focus:outline-none',
      title: 'text-lg font-bold',
      htmlContainer: 'text-sm',
    },
    buttonsStyling: false,
  });
};

export const SwalResetPasswordUser = (roleName) => {
  return Swal.fire({
    title: 'Reset Password?',
    html: `<p class="text-gray-700 dark:text-gray-200">Kata sandi baru akan ditetapkan sesuai dengan role Anda: <span class="font-semibold text-yellow-600 dark:text-yellow-400">"${roleName}"</span>.</p>`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, Reset!',
    cancelButtonText: 'Batal',
    focusCancel: true,
    background: '#fff',
    color: '#111827',
    customClass: {
      popup: 'rounded-xl shadow-lg px-6 py-4',
      confirmButton: 'bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-4 py-2 rounded-lg focus:outline-none mr-5',
      cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg focus:outline-none',
      title: 'text-lg font-bold',
      htmlContainer: 'text-sm',
    },
    buttonsStyling: false
  })
}

export const SwalDeletePoolTableAdmin = () => {
  return Swal.fire({
    title: 'Hapus Data?',
    text: 'Data yang dihapus tidak dapat dikembalikan.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal',
    background: '#fff',
    color: '#111827',
    customClass: {
      popup: 'rounded-xl shadow-lg px-6 py-4',
      confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg focus:outline-none mr-5',
      cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg focus:outline-none',
      title: 'text-lg font-bold',
      htmlContainer: 'text-sm',
    },
    buttonsStyling: false
  })
}

export const SwalPaymentInfo = (transaction) => {
  Swal.fire({
    title: 'Pembayaran Berhasil',
    html: `<p class="mb-1 text-base">Status: <strong>${transaction.payment_status ?? '-'}</strong></p>
                                  <p class="mb-1 text-base">Metode: <strong>${transaction.payment_type ?? '-'}</strong></p>
                                  <p class="mb-1 text-base">Total: <strong>Rp ${Number(transaction.amount ?? 0).toLocaleString('id-ID')}</strong></p>`,
    icon: 'success',
    confirmButtonText: 'Ok',
    focusCancel: true,
    background: '#fff',
    color: '#111827',
    customClass: {
      popup: 'rounded-xl shadow-lg px-6 py-4',
      confirmButton: 'bg-gray-700 hover:bg-gray-500 text-white font-medium px-4 py-2 rounded-lg focus:outline-none mr-5 transtion-all ease-in-out duration-300',
      title: 'text-lg font-bold',
      htmlContainer: 'text-sm',
    },
    buttonsStyling: false
  });
}