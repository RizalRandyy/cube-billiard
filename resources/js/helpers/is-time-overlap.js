export function isTimeOverlap(slotStart, slotEnd, bookingStart, bookingEnd) {
  const sStart = normalizeTime(slotStart);
  const sEnd = normalizeTime(slotEnd);
  const bStart = normalizeTime(bookingStart);
  const bEnd = normalizeTime(bookingEnd);

  return sStart < bEnd && sEnd > bStart;
}