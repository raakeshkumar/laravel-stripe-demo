<form action="{{route('payment_process')}}" id="stripe" method="post">
    <input id="card-holder-name" type="text">
    
    <!-- Stripe Elements Placeholder -->
    <div id="card-element"></div>
    <input name="pmethod" type="hidden" id="pmethod" value="" />
    <button id="card-button">
        Process Payment
    </button>
</form>

<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe('{{ env("STRIPE_KEY") }}');

    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const form = document.getElementById('stripe');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const { paymentMethod, error } = await stripe.createPaymentMethod(
            'card', cardElement, {
                billing_details: { name: cardHolderName.value }
            }
        );

        if (error) {
            // Display "error.message" to the user...
        } else {
            console.log('Card verified successfully');
            console.log(paymentMethod.id);
            document.getElementById('pmethod').setAttribute('value', paymentMethod.id);
            form.submit();
        }
    });
</script>