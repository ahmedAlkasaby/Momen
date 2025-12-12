<style>
    .select-size-btn {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--primary-color, #000);
    color: #fff;
    border: none;
    padding: 6px 14px;
    border-radius: 10px;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 5px;
    opacity: 0;
    transition: 0.3s ease-in-out;
    cursor: pointer;
}

.product-card:hover .select-size-btn {
    opacity: 1;
}

.product-card:hover .product-card__counter {
    opacity: 0;
}
.color-radio,
.size-radio {
    appearance: none !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    width: 0;
    height: 0;
    margin: 0;
    padding: 0;
    position: absolute;
    opacity: 0;
}
.color-item {
    cursor: pointer;
}

.color-item label {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3px;
}

.color-circle {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 2px solid #ccc;
    display: inline-block;
}

.color-radio:checked + label .color-circle {
    border: 2px solid #000;
    transform: scale(1.1);
    transition: 0.2s;
}
.size-radio + label {
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-right: 8px;
    cursor: pointer;
}

.size-radio:checked + label {
    background: #000;
    color: #fff;
    border-color: #000;
}

.modal-image-wrapper {
    position: relative;
    width: 100%;
}

.img-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 32px;
    font-weight: bold;
    background: rgba(0,0,0,0.45);
    color: #fff;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    line-height: 32px;
    text-align: center;
    cursor: pointer;
    user-select: none;
    transition: .2s;
}

.img-arrow:hover {
    background: rgba(0,0,0,0.7);
}

.img-prev {
    left: 5px;
}

.img-next {
    right: 5px;
}


</style>