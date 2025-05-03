@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Secure Payment</h2>

        <!-- Step Tracker -->
        <div class="flex justify-between items-center mb-6">
            @foreach (['Preparing', 'Verifying', 'Processing', 'Complete'] as $index => $step)
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full text-white flex items-center justify-center text-sm font-semibold step-indicator bg-gray-300" id="step{{ $index + 1 }}">
                        {{ $index + 1 }}
                    </div>
                    <span class="text-xs mt-1 text-gray-600">{{ $step }}</span>
                </div>
            @endforeach
        </div>

        <!-- Payment Form -->
        <form id="payment-form" class="space-y-4">
            <div id="card-element" class="p-3 border border-gray-300 rounded-lg shadow-sm bg-white"></div>
            <button id="submit" type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition flex items-center justify-center">
                <span id="button-text">Pay Now</span>
                <span id="spinner" class="ml-2 hidden animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
            </button>
            <div id="payment-message" class="text-sm text-red-500 text-center mt-2"></div>
        </form>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ $stripeKey }}');
    const elements = stripe.elements();
    const card = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
                '::placeholder': { color: '#aab7c4' }
            },
            invalid: { color: '#fa755a', iconColor: '#fa755a' }
        }
    });
    card.mount('#card-element');

    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit');
    const buttonText = document.getElementById('button-text');
    const spinner = document.getElementById('spinner');
    const paymentMessage = document.getElementById('payment-message');

    function updateStep(stepNumber) {
        for (let i = 1; i <= 4; i++) {
            const el = document.getElementById(`step${i}`);
            el.classList.remove('bg-indigo-600', 'text-white');
            el.classList.add('bg-gray-300', 'text-black');
        }
        const current = document.getElementById(`step${stepNumber}`);
        current.classList.add('bg-indigo-600', 'text-white');
        current.classList.remove('bg-gray-300', 'text-black');
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        updateStep(1);
        submitButton.disabled = true;
        buttonText.classList.add('hidden');
        spinner.classList.remove('hidden');
        paymentMessage.textContent = '';

        const response = await fetch("{{ route('payment.process') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({})
        });

        const { clientSecret } = await response.json();
        updateStep(2);

        const result = await stripe.confirmCardPayment(clientSecret, {
            payment_method: { card }
        });

        if (result.error) {
            updateStep(4);
            paymentMessage.textContent = result.error.message;
            buttonText.classList.remove('hidden');
            spinner.classList.add('hidden');
            submitButton.disabled = false;
        } else if (result.paymentIntent.status === 'succeeded') {
            updateStep(4);
            paymentMessage.textContent = '✅ Payment successful!';
            paymentMessage.classList.remove('text-red-500');
            paymentMessage.classList.add('text-green-600');
        }
    });
</script>
@endsection
