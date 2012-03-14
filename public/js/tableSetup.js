/**
 * Helper functions for button click setups
 *
 * author Mark Tustin
 */

$(function() {
    $("table").delegate('td','mouseover mouseleave', function(e) {
        if (e.type == 'mouseover') {
          $(this).parent().addClass("hover");
        } else {
          $(this).parent().removeClass("hover");
        }
    });
});