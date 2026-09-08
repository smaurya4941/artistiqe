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
            console.log('Continue clicked'); // ✅ debug

            if (currentStep < totalSteps) {
                currentStep++;
                updateStep();
            } else {
                document.getElementById('artworkForm').submit();
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
