// Ambil data awal
export function fetchInitialData(){
  $.get('/pool-tables-data', data => {
    data.forEach(item => renderPoolTablesUser(item.name, item.x, item.y, item.orientation, item
      .id,
      item.price_per_hour, item.status));
  });
}