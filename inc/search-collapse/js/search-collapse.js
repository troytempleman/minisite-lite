jQuery(document).ready(function() {
    jQuery(".navbar .search-submit.search-collapse").click(function() {
        $(".navbar .search-collapse").removeClass("search-collapse");
        $(".navbar .search-field").focus();
        window.setTimeout(submittize,1000);
    });

    jQuery(".navbar .search-field").blur(function() {
        $(".navbar .search-field, .navbar .search-submit").addClass("search-collapse");
        window.setTimeout(buttonize,1000);
    })

    function buttonize() {
        $(".navbar .search-submit").attr("type","button");
    }

    function submittize() {
        $(".navbar .search-submit").attr("type","submit");
    }
});