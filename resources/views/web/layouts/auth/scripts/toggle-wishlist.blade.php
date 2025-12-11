<script>

$(document).ready(function () {
    $(".product-card__addToFavIcon").click(function (e) {
        e.preventDefault();

        var $this = $(this);
        var url = $this.data("url");

        $.ajax({
            url: url,
            type: "POST",
            data: { product_id: $this.data("id") },
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            success: function (response) {
                if (response.toggle == "yes") {
                    $this.attr("src", $this.data("heart"));
                } else if (response.toggle == "no") {
                    $this.attr("src", $this.data("red-heart"));
                }
            },
        });
    });
});
</script>
