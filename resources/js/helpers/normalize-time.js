export function normalizeTime(t) {
  return t.length === 5 ? t : t.slice(0, 5); // '13:00:00' → '13:00'
}