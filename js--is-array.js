/**
 * Vérifier si une variable javascript est un array.
 * @param myArray
 * @returns {boolean}
 */
function isArray(myArray) {
  return myArray.constructor.toString().indexOf("Array") > -1;
}

