document.addEventListener('DOMContentLoaded', () => {

    const totalEl = document.getElementById('grandTotal');
    const buyBtn = document.querySelector('.buyBtn');

    function recalculateTotal() {
        let sum = 0;

        document.querySelectorAll('.basket-item').forEach(item => {
            sum += parseFloat(item.dataset.total);
        });

        totalEl.textContent = sum.toFixed(2);
    }

    document.querySelectorAll('.deleteBtn').forEach(btn => {
        btn.addEventListener('click', () => {

            if (!confirm('Remove this item from basket?')) return;

            const basketItem = btn.closest('.basket-item');

            basketItem.style.opacity = '0';
            basketItem.style.transform = 'scale(0.95)';

            setTimeout(() => {
                basketItem.remove();
                recalculateTotal(); 
            }, 200);
        });
    });


    if (buyBtn) {
        buyBtn.addEventListener('click', () => {
            window.location.href = "checkout.php";
        });
    }

});
