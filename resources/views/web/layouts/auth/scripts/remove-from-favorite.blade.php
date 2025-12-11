<script>

$(document).ready(function() {
    $(".removeFavorite").click(function(e) {
        e.preventDefault();

        var $this = $(this);
        var id = $this.data("id");
        
        $.ajax({
            url: "/favorites", 
            type: "POST",
            data: { product_id: id },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(response) {
                console.log(response);
                if (response.status == "success") {
                    $this.closest("tr").remove();
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });
});
</script>