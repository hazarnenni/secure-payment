$(document).on('click', '.add-to-cart', function () {
    let productId = $(this).data('product-id');

    $.ajax({
        url: '/cart/add',
        method: 'POST',
        data: {
            product_id: productId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status === 'success') {
                toastr.success(response.message, 'Succès');
                fetchCartCount();
            } else {
                toastr.error(response.message || 'Une erreur est survenue.', 'Erreur');
            }
        },
        error: function () {
            toastr.error('Une erreur est survenue lors de l\'ajout.', 'Erreur');
        }
    });
});

toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: 'toast-top-right',
    timeOut: '3000'
};


function fetchCartCount() {
    fetch('/cart/count', {
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        document.querySelector('.cart-count').textContent = data.count;
    })
    .catch(error => {
        console.error('Error fetching cart count:', error);
    });
}

document.addEventListener('DOMContentLoaded', fetchCartCount);



document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const productId = this.dataset.id;

            fetch(`/cart/remove/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    toastr.success(data.message);
                    this.closest('.cart-item').remove();
                    fetchCartCount();
                    if (document.querySelectorAll('.cart-item').length === 0) {
                        location.reload();
                    }
                } else {
                    toastr.error('Failed to remove item.');
                }
            })
            .catch(error => {
                console.error('Remove failed:', error);
                toastr.error('Error removing item.');
            });
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.quantity-control').forEach(control => {
        const input = control.querySelector('.quantity-input');
        const minusBtn = control.querySelector('.quantity-btn.minus');
        const plusBtn = control.querySelector('.quantity-btn.plus');
        const productId = control.dataset.id;

        function updateQuantity(newQuantity) {
            fetch(`/cart/update/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantity: newQuantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    toastr.success(data.message);
                    refreshCartSummary();
                } else {
                    toastr.error('Impossible de mettre à jour la quantité.');
                }
            })
            .catch(error => {
                console.error(error);
                toastr.error('Erreur de mise à jour du panier.');
            });
        }

        minusBtn.addEventListener('click', () => {
            let qty = parseInt(input.value) || 1;
            if (qty > 1) {
                input.value = --qty;
                updateQuantity(qty);
            }
        });

        plusBtn.addEventListener('click', () => {
            let qty = parseInt(input.value) || 1;
            input.value = ++qty;
            updateQuantity(qty);
        });

        input.addEventListener('change', () => {
            let qty = Math.max(parseInt(input.value) || 1, 1);
            input.value = qty;
            updateQuantity(qty);
        });
    });
});

function refreshCartSummary() {
    fetch('/cart/summary')
        .then(res => res.json())
        .then(data => {
            document.getElementById('summary-subtotal-label').innerText = `Subtotal (${data.quantity} items)`;
            document.getElementById('summary-subtotal-value').innerText = `$${data.subtotal}`;
            document.getElementById('summary-total-value').innerText = `$${data.total}`;
        })
        .catch(err => console.error('Failed to update summary', err));
}

