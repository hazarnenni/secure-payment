@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Stripe Payment</h2>

    <form id="payment-form">
        <div class="mb-3">
            <label for="amount">Amount (USD)</label>
            <input type="number" name="amount" id="amount" class="form-control" required min="1" step="0.01">
        </div>

        <div id="payment-element" class="my-3"></div>

        <button id="submit" class="btn btn-primary">
            <span id="button-text">Pay</span>
            <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
        </button>

        <div id="payment-message" class="mt-3 text-danger"></div>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    let stripe = Stripe("{{ $stripeKey }}");
    let elements;
    let clientSecret;

    const form = document.getElementById('payment-form');
    const amountInput = document.getElementById('amount');
    const submitButton = document.getElementById('submit');
    const buttonText = document.getElementById('button-text');
    const spinner = document.getElementById('spinner');
    const paymentMessage = document.getElementById('payment-message');

    amountInput.addEventListener('change', async () => {
        await createPaymentIntent();
    });

    async function createPaymentIntent() {
        const amount = amountInput.value;
        if (!amount || amount < 1) return;

        const res = await fetch('{{ route('payment.intent') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ amount }),
        });

        const data = await res.json();
        clientSecret = data.clientSecret;

        elements = stripe.elements({ clientSecret });
        const paymentElement = elements.create("payment");
        paymentElement.mount("#payment-element");
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        if (!clientSecret) {
            await createPaymentIntent();
        }

        submitButton.disabled = true;
        buttonText.classList.add('d-none');
        spinner.classList.remove('d-none');

        const { error } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                return_url: '{{ route("payment.success") }}',
            },
        });

        if (error) {
            paymentMessage.textContent = error.message;
            submitButton.disabled = false;
            buttonText.classList.remove('d-none');
            spinner.classList.add('d-none');
        }
    });
</script>
@endsection
