
function getParamsFromUrl(param) {
  var params = [];
  if (location.search.indexOf('?') === -1) return [];
  location.search.substring(1).split('&').map(function(item){
    var parts = item.split('=');
    params[parts[0]] = parts[1];
  });
  return param ? params[param] : params;
}

