/* Preloader
 * -------------------------------------------------- */
var drumPreloader = function() {
    jQuery( document ).ready(function() {
        // will first fade out the loading animation
        jQuery(".loading-inner").fadeOut("slow", function() {
            // will fade out the whole DIV that covers the website.
            jQuery("#preloader").delay(300).fadeOut("slow");
        });
    });
};

/* Initialize
 * ------------------------------------------------------ */
(function drumInit() {
    drumPreloader();
})();