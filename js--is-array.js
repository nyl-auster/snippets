@desc check if a variable is an array in javascript
@tags js, array, isArray, is array

function isArray(myArray) {
  return myArray.constructor.toString().indexOf("Array") > -1;
}

