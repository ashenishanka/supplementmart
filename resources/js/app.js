

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('productVariantPicker', (variants, defaultVariantId, basePrice, baseComparePrice, baseStock) => ({
    variants,
    selected: defaultVariantId,
    quantity: 1,

    get variant() {
        return this.variants.find((v) => v.id === this.selected) ?? null;
    },

    get price() {
        return this.variant ? Number(this.variant.current_price) : Number(basePrice);
    },

    get comparePrice() {
        return this.variant ? Number(this.variant.price) : Number(baseComparePrice);
    },

    get onSale() {
        return this.price < this.comparePrice;
    },

    get stock() {
        return this.variant ? this.variant.stock : baseStock;
    },

    formatPrice(value) {
        return 'Rs. ' + Number(value).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    },
}));

Alpine.start();
