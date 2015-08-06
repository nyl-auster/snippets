@desc drupal behavior example
@tags drupal 7, drupal, behavior

// créer une fonction anonyme et lui passer l'objet jquery
(function($) {
// la méthode pour créer du js dans Drupal passe par des behaviors,
// ces derniers sont appelés automatiquement par Drupal et permettent de réappliquer
// des comportements js à des éléments html qui viennent d'être rafraichis par ajax.
  Drupal.behaviors.modulestarter = {
    attach : function (context) {
      alert('js example included by module starter');
    }
  };
})(jQuery);