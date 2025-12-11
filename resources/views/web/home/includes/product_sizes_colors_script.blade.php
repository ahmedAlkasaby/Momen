<script>
    // فتح المودال
    $(document).on('click', '.open-modal-btn', function() {

        let product = $(this).data('product');
        window.currentProduct = product; // نخزن المنتج لاستخدامه لاحقاً
        openProductModal(product);
    });

    window.openProductModal = function(product) {

        $('#modal-product-image').attr('src', product.image);
        $('#modal-product-name').text(product.name);
        $('#modal-product-price').text(product.price + " EGP");

        if (product.offer_price) {
            $('#modal-product-offer').removeClass('d-none');
            $('#modal-product-offer span').text(product.offer_price);
        } else {
            $('#modal-product-offer').addClass('d-none');
        }

        let colorBox = $('#modal-color-box').html('');
        product.colors.forEach(c => {
            colorBox.append(`
                <div class="col color-item">
                    <input type="radio" name="color" class="color-radio"
                           id="color-${c.id}" value="${c.id}">
                    <label for="color-${c.id}">
                        <span class="color-circle"
                              style="background:${c.code}; border:1px solid #ccc"></span>
                        <span class="color-name">${c.name}</span>
                    </label>
                </div>
            `);
        });

        let sizeBox = $('#modal-size-box').html('');
        product.sizes.forEach(s => {
            sizeBox.append(`
                <input type="radio" class="size-radio"
                       id="size-${s.id}" name="size" value="${s.id}">
                <label for="size-${s.id}">${s.name}</label>
            `);
        });

        $('#sizemodal').modal('show');
    };


    
    $(document).on('change', '.color-radio', function() {

        let colorId = $(this).val();
        let product = window.currentProduct;

        let allowedSizes = product.children
            .filter(c => c.color_id == colorId)
            .map(c => c.size_id);

        $('.size-radio').each(function() {
            let sizeId = $(this).val();

            if (allowedSizes.includes(parseInt(sizeId))) {
                $(this).show().next('label').show();
            } else {
                $(this).hide().next('label').hide();
                $(this).prop('checked', false);
            }
        });

    });

   
    $(document).on('change', '.size-radio', function() {

        let sizeId = $(this).val();
        let colorId = $('.color-radio:checked').val();
        let product = window.currentProduct;

        if (!colorId) return;

        let child = product.children.find(c =>
            c.size_id == sizeId && c.color_id == colorId
        );

        if (child) {
            console.log("Selected child:", child);
            window.selectedChild = child;
        }
    });

</script>
