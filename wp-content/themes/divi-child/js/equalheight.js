function equalHeight(containerSelector) {
  var currentTallest = 0,
    currentRowStart = 0,
    rowDivs = [],
    $el,
    topPosition = 0;
  jQuery(containerSelector).each(function () {
    $el = jQuery(this);
    jQuery($el).height("auto");
    topPosition = $el.position().top;

    if (currentRowStart !== topPosition) {
      for (var currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
        jQuery(rowDivs[currentDiv]).height(currentTallest);
      }
      rowDivs.length = 0; // Empty the array
      currentRowStart = topPosition;
      currentTallest = $el.height();
      rowDivs.push($el);
    } else {
      rowDivs.push($el);
      currentTallest = Math.max(currentTallest, $el.height());
    }
  });
  for (var currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
    jQuery(rowDivs[currentDiv]).height(currentTallest);
  }
}
jQuery(window).on("load", function () {
  equalHeight(".et_pb_testimonial .et_pb_testimonial_content");
  equalHeight(".events-row .et_pb_module_heading");
  equalHeight(".events-row .et_pb_text_inner");

});
jQuery(window).on("resize", function () {
  equalHeight(".et_pb_testimonial .et_pb_testimonial_content");
  equalHeight(".events-row .et_pb_text_inner");
});
