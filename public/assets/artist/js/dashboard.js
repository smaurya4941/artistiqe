document.addEventListener('DOMContentLoaded', function () {

    let currentStep = 1;
    const totalSteps = 4;

    const stepText = document.getElementById('step-text');
    const steps = document.querySelectorAll('.step');
    const contents = document.querySelectorAll('.step-content');
    const nextBtns = document.querySelectorAll('.btn-next');
    const backBtn = document.getElementById('backBtn');

    function updateStep() {
        contents.forEach(c => c.classList.remove('active'));

        const activeStep = document.querySelector(
            `.step-content[data-step="${currentStep}"]`
        );
         if (activeStep) activeStep.classList.add('active');

    steps.forEach(s => s.classList.remove('active','done'));
    steps.forEach(s => {
        const step = parseInt(s.dataset.step);
        if (step < currentStep) s.classList.add('done');
        if (step === currentStep) s.classList.add('active');
    });

    // 🔥 BACK BUTTON
    if (backBtn) backBtn.disabled = currentStep === 1;

    // 🔥 CHANGE BUTTON TEXT ON LAST STEP
    document.querySelectorAll('.btn-next').forEach(btn => {
        btn.innerText = (currentStep === totalSteps)
            ? 'Publish Artwork'
            : 'Continue';
    });
        if (backBtn) {
    backBtn.addEventListener('click', function () {
        if (currentStep > 1) {
            currentStep--;
            updateStep();
        }
    });
}

        if (activeStep) activeStep.classList.add('active');

        steps.forEach(s => s.classList.remove('active','done'));
        steps.forEach(s => {
            const step = parseInt(s.dataset.step);
            if (step < currentStep) s.classList.add('done');
            if (step === currentStep) s.classList.add('active');
        });

        if (stepText) {
            const titles = [
                'ARTWORK DETAILS',
                'UPLOAD IMAGES',
                'DELIVERY & LOGISTICS',
                'PRICING & PUBLISH'
            ];
            stepText.innerText = `STEP ${currentStep} OF 4 • ${titles[currentStep - 1]}`;
        }

        if (backBtn) backBtn.disabled = currentStep === 1;
    }

    nextBtns.forEach(btn => {
    btn.addEventListener('click', function () {

        const actionInput = document.getElementById('actionType');
        const form = document.getElementById('artworkForm');

        if (actionInput) {
            actionInput.value = 'publish';
        }

        if (currentStep < totalSteps) {
            currentStep++;
            updateStep();
        } else if (form) {
            form.submit();
        }
    });
});


    if (backBtn) {
        backBtn.addEventListener('click', function () {
            if (currentStep > 1) {
                currentStep--;
                updateStep();
            }
        });
    }

    updateStep();
});
document.addEventListener('DOMContentLoaded', function () {

    /* PRIMARY IMAGE */
    const primaryInput = document.getElementById('primaryInput');
    const primaryPreview = document.getElementById('primaryPreview');
    const primaryDrop = document.getElementById('primaryDrop');

    if (primaryInput) {
        primaryInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            primaryPreview.src = URL.createObjectURL(file);
            primaryPreview.hidden = false;
            primaryDrop.querySelector('.upload-placeholder').style.display = 'none';
        });
    }

    /* ANGLE IMAGES */
    document.querySelectorAll('.angle-box').forEach(box => {
        const input = box.querySelector('input');
        const img = box.querySelector('img');

        box.addEventListener('click', () => input.click());

        input.addEventListener('change', () => {
            const file = input.files[0];
            if (!file) return;

            img.src = URL.createObjectURL(file);
            img.hidden = false;
            box.querySelector('.plus').style.display = 'none';
            box.querySelector('.angle-text').style.display = 'none';
        });
    });

});
document.addEventListener('DOMContentLoaded', function () {

    const deliveryCards = document.querySelectorAll('.delivery-card');

    deliveryCards.forEach(card => {
        card.addEventListener('click', () => {

            // remove active from all
            deliveryCards.forEach(c => {
                c.classList.remove('active');
                c.querySelector('input').checked = false;
            });

            // activate clicked
            card.classList.add('active');
            card.querySelector('input').checked = true;
        });
    });

});
document.addEventListener('DOMContentLoaded', function () {

    const priceInput = document.getElementById('priceInput');
    const commissionEl = document.getElementById('commission');
    const gstEl = document.getElementById('gst');
    const earnEl = document.getElementById('earn');
    const summaryPrice = document.getElementById('summaryPrice');

    if (!priceInput) return;

    priceInput.addEventListener('input', function () {
        const price = parseFloat(this.value) || 0;

        const commission = price * 0.20;
        const gst = commission * 0.18;
        const earn = price - commission - gst;

        commissionEl.innerText = `-$${commission.toFixed(2)}`;
        gstEl.innerText = `-$${gst.toFixed(2)}`;
        earnEl.innerText = `$${earn.toFixed(2)}`;
        summaryPrice.innerText = `$${price.toFixed(0)}`;
    });

});

