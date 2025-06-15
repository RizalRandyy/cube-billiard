// Format price function
export function formatPricePoolTable(value) {
  if (typeof value === 'string') {
    value = value.replace(/[^\d]/g, '');
  }
  const number = parseInt(value, 10);
  if (isNaN(number)) return '';
  return number.toLocaleString('id-ID');
}