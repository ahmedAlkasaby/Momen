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

</style>