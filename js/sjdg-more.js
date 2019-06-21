jQuery(function( $ ){
       $(document).ready(function () {
        $(".more-0").click(function () {
            this.classList.toggle("active");
            $(".i-0").toggle(300);

        });
        $(".more-1").click(function () {
            this.classList.toggle("active");
            $(".i-1").toggle(300);

        });
        $(".more-2").click(function () {
            this.classList.toggle("active");
            $(".i-2").toggle(300);

        });
        $(".more-3").click(function () {
            this.classList.toggle("active");
            $(".i-3").toggle(300);

        });
    });
});