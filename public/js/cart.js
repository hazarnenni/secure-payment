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
        credentials: 'same-origin' // Important to include cookies
    })
    .then(response => response.json())
    .then(data => {
        document.querySelector('.cart-count').textContent = data.count;
    })
    .catch(error => {
        console.error('Error fetching cart count:', error);
    });
}

// Fetch cart count on page load
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
