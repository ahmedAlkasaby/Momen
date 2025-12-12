<script>
    // فتح المودال
    $(document).on('click', '.open-modal-btn', function() {

        let product = $(this).data('product');
        window.currentProduct = product;
        window.selectedChild = null;
        openProductModal(product);
    });

    window.openProductModal = function(product) {

        // ===============================
        //   UPDATE MAIN PRODUCT DATA
        // ===============================
        $('#modal-product-image').attr('src', product.image);
        $('#modal-product-name').text(product.name);
        $('#modal-product-price').text(product.price + " EGP");

        if (product.offer_price) {
            $('#modal-product-offer').removeClass('d-none');
            $('#modal-product-offer span').text(product.offer_price);
        } else {
            $('#modal-product-offer').addClass('d-none');
        }

        // ===============================
        //   BUILD COLORS
        // ===============================
        let colorBox = $('#modal-color-box').html('');
        product.colors.forEach(c => {
            colorBox.append(`
                <div class="col color-item">
                    <input type="radio" name="color" class="color-radio"
                           id="color-${c.id}" value="${c.id}">
                    <label for="color-${c.id}">
                        <span class="color-circle" style="background:${c.code};"></span>
                        <span class="color-name">${c.name}</span>
                    </label>
                </div>
            `);
        });

        // ===============================
        //   BUILD SIZES
        // ===============================
        let sizeBox = $('#modal-size-box').html('');
        product.sizes.forEach(s => {
            sizeBox.append(`
                <input type="radio" class="size-radio"
                       id="size-${s.id}" name="size" value="${s.id}">
                <label for="size-${s.id}">${s.name}</label>
            `);
        });

        // ===============================
        //    AUTO SELECT FIRST COLOR
        // ===============================
        setTimeout(() => {
            let firstColor = $('.color-radio').first();
            if (firstColor.length) {
                firstColor.prop('checked', true).trigger('change');
            }
        }, 50);

        $('#sizemodal').modal('show');
    };


    // ====================================================
    //   ON COLOR CHANGE → FILTER SIZES + AUTO SELECT SIZE
    // ====================================================
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

        // AUTO SELECT FIRST AVAILABLE SIZE
        setTimeout(() => {
            let firstVisible = $('.size-radio:visible').first();
            if (firstVisible.length) {
                firstVisible.prop('checked', true).trigger('change');
            }
        }, 50);
    });


    // ====================================================
    //   ON SIZE CHANGE → UPDATE CHILD DATA (image/price)
    // ====================================================
    $(document).on('change', '.size-radio', function() {

        let sizeId = $(this).val();
        let colorId = $('.color-radio:checked').val();
        let product = window.currentProduct;

        if (!colorId) return;

        let child = product.children.find(c =>
            c.size_id == sizeId && c.color_id == colorId
        );

        if (child) {
            window.selectedChild = child;

            window.currentImages = child.images; // كل صور الـ child
            window.currentImageIndex = 0;
            if (window.currentImages.length > 0) {
                $('#modal-product-image').attr('src', window.currentImages[0]);
            }


            // CHANGE PRICE
            $('#modal-product-price').text(child.price + " EGP");

            if (child.offer_price && child.offer_price > 0) {
                $('#modal-product-offer').removeClass('d-none');
                $('#modal-product-offer span').text(child.offer_price);
            } else {
                $('#modal-product-offer').addClass('d-none');
            }
        }
    });
    $(document).on('click', '#img-next', function() {
        if (!window.currentImages || window.currentImages.length === 0) return;

        window.currentImageIndex++;

        if (window.currentImageIndex >= window.currentImages.length) {
            window.currentImageIndex = 0; // نرجع لأول صورة
        }

        $('#modal-product-image')
            .attr('src', window.currentImages[window.currentImageIndex]);
    });

    $(document).on('click', '#img-prev', function() {
        if (!window.currentImages || window.currentImages.length === 0) return;

        window.currentImageIndex--;

        if (window.currentImageIndex < 0) {
            window.currentImageIndex = window.currentImages.length - 1; // آخر صورة
        }

        $('#modal-product-image')
            .attr('src', window.currentImages[window.currentImageIndex]);
    });




    // ====================================================
    //   ADD TO CART
    // ====================================================
    $(document).on('click', '#modal-add-to-cart', function() {

        if (!window.selectedChild) {
            showToast("{{ __('web.select_size_color_first') }}", 'error');
            return;
        }

        $.ajax({
            url: "{{ route('carts.store') }}",
            method: "POST",
            data: {
                product_id: window.selectedChild.id,
                amount: 1,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {

                if (res.success === true) {
                    showToast(res.message, 'success');
                    $('#sizemodal').modal('hide');
                } else {
                    showToast(res.message, 'error');
                }
            },
            error: function(xhr) {

                let msg = xhr.responseJSON?.message ?? "{{ __('web.error_occurred') }}";
                showToast(msg, 'error');
            }
        });
    });
</script>

<div id="toast"
    style="
    position: fixed; 
    bottom: 20px; 
    left: 50%; 
    transform: translateX(-50%);
    background: #222; 
    color: #fff; 
    padding: 12px 20px; 
    border-radius: 6px; 
    display: none;
    z-index: 9999;">
</div>

<script>
    function showToast(msg, type = 'success') {
        let t = $('#toast');
        t.text(msg);

        if (type === 'error') {
            t.css('background', '#c0392b');
        } else {
            t.css('background', '#27ae60');
        }

        t.fadeIn(300);
        setTimeout(() => t.fadeOut(300), 2500);
    }
</script>
