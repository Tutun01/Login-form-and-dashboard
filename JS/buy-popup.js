document.addEventListener("DOMContentLoaded", function () {

    const popup = document.getElementById("popup");
    const closeBtn = document.getElementById("closePopup");
    const quantityInput = document.getElementById("quantity");
    const totalPriceSpan = document.getElementById("totalPrice");
    const buyBtn = document.getElementById("buyButton");

    const pricePerItem = parseFloat(popup.dataset.price);

   
    window.openPopup = function () {
        popup.style.display = "flex";
        updatePrice();
    };

  
    closeBtn.addEventListener("click", function () {
        popup.style.display = "none";
    });

   
    quantityInput.addEventListener("input", updatePrice);

    function updatePrice() {
        let qty = parseInt(quantityInput.value);

        if (isNaN(qty) || qty < 0) qty = 0;
        if (qty > parseInt(quantityInput.max)) {
            qty = quantityInput.max;
        }

        quantityInput.value = qty;

        const total = pricePerItem * qty;
        totalPriceSpan.textContent = total.toFixed(2);
    }

    buyBtn.addEventListener("click", () => {
    const productId = buyBtn.dataset.id;
    const quantity = document.getElementById("quantity").value;

        fetch("add_to_cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            id: buyBtn.dataset.id,
            qty: quantityInput.value
        })
    })
    .then(res => res.text())
    .then(() => {
        window.location.href = "basket.php";
    });



});
});
