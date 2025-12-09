<script>
    $(document).on('click', '.open-modal-btn', function() {
        console.log($(this).data('product'));
        let product = $(this).data('product');
        openProductModal(product);
    });

    window.openProductModal = function(product) {

        // صورة
        $('#modal-product-image').attr('src', product.image);

        // اسم
        $('#modal-product-name').text(product.name);

        // سعر
        $('#modal-product-price').text(product.price + " EGP");

        if (product.offer_price) {
            $('#modal-product-offer').removeClass('d-none');
            $('#modal-product-offer span').text(product.offer_price);
        } else {
            $('#modal-product-offer').addClass('d-none');
        }

        // ألوان
        let colorBox = $('#modal-color-box').html('');
        product.colors.forEach(c => {
            colorBox.append(`
            <div class="col color-item">
                <input type="radio" name="color" id="color-${c.id}" value="${c.id}">
                <label for="color-${c.id}">
                    <span class="color-circle" style="background:${c.code};border:1px solid #ccc"></span>
                    <span class="color-name">${c.name}</span>
                </label>
            </div>
        `);
        });

        // مقاسات
        let sizeBox = $('#modal-size-box').html('');
        product.sizes.forEach(s => {
            sizeBox.append(`
            <input type="radio" id="size-${s.id}" name="size" value="${s.id}">
            <label for="size-${s.id}">${s.name}</label>
        `);
        });

        // افتح المودال
        $('#sizemodal').modal('show');
    };
</script>
