// assets/js/script.js
jQuery(function($){
  // Default-Werte laden
  var zoomVal     = parseInt(localStorage.getItem('atlite_zoom'))     || parseInt(ATL_Settings.zoom);
  var contrastVal = localStorage.getItem('atlite_contrast')           || ATL_Settings.contrast;

  // Initial anwenden
  $('body').css('font-size', zoomVal + '%');
  if (contrastVal === 'on') {
    $('body').addClass('high-contrast');
  }

  // Zoom In (+10%)
  $(document).on('click', '#atl-zoom-in', function(){
    zoomVal = Math.min(zoomVal + 10, 300);
    $('body').css('font-size', zoomVal + '%');
    localStorage.setItem('atlite_zoom', zoomVal);
  });

  // Zoom Out (–10%)
  $(document).on('click', '#atl-zoom-out', function(){
    zoomVal = Math.max(zoomVal - 10, 50);
    $('body').css('font-size', zoomVal + '%');
    localStorage.setItem('atlite_zoom', zoomVal);
  });

  // Toggle High-Contrast
  $(document).on('click', '#atl-toggle-contrast', function(){
    $('body').toggleClass('high-contrast');
    contrastVal = $('body').hasClass('high-contrast') ? 'on' : 'off';
    localStorage.setItem('atlite_contrast', contrastVal);
  });
});
