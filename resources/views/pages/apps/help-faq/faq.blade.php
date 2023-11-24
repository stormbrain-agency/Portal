<x-default-layout>
<div class="card help-faq p-15">
    <h1 class="title">Frequently Asked Questions</h1>
    <div class="wrap-question">
        <div class="box-question bg-state-body d-flex align-items-start " onclick="toggleAnswer(this)">
            {!! getIcon('plus-square', 'fs-2') !!}
            <div class="wrap-content">
                <h3 class="title-question">
                    Are there any other eligibility requirements to receive the one-time Transitional Subsidy Payment?
                </h3>
                <div class="content">However, in order for CDA to issue payment, eligible child care providers will receive an email requesting to submit a valid W-9 Form.</div>
            </div>                     
        </div>
        <div class="box-question bg-state-body d-flex align-items-start " onclick="toggleAnswer(this)">
            {!! getIcon('plus-square', 'fs-2') !!}     
            <div class="wrap-content">
                <h3 class="title-question ">
                    How does CDA know which Stage One or Bridge Program providers to pay?            
                </h3>
                <div class="content ">However, in order for CDA to issue payment, eligible child care providers will receive an email requesting to submit a valid W-9 Form.</div>
            </div>
        </div>
        <div class="box-question bg-state-body d-flex align-items-start" onclick="toggleAnswer(this)">
            {!! getIcon('plus-square', 'fs-2') !!}     
            <div class="wrap-content">
                <h3 class="title-question ">
                    How will child care providers receive the one-time Transitional Subsidy payments?           
                </h3>
                <div class="content ">However, in order for CDA to issue payment, eligible child care providers will receive an email requesting to submit a valid W-9 Form.</div>
            </div>
        </div>
        <div class="box-question bg-state-body d-flex align-items-start" onclick="toggleAnswer(this)">
            {!! getIcon('plus-square', 'fs-2') !!}     
            <div class="wrap-content">
                <h3 class="title-question ">
                    When will child care providers receive the one-time Transitional Provider Subsidy payments?                </h3>
                <div class="content ">However, in order for CDA to issue payment, eligible child care providers will receive an email requesting to submit a valid W-9 Form.</div>
            </div>
        </div>
    </div>
</div>
<script>
    function toggleAnswer(box) {
        var elements = document.getElementsByClassName("box-question");
        var child = box.querySelector('.ki-duotone');
        if(box.classList.contains('active')){
            box.classList.remove('active');
            child.classList.replace('ki-minus-square', 'ki-plus-square');
        }else{
            for (let i = 0; i < elements.length; i++) {
                elements[i].classList.remove('active');
                elements[i].querySelector('.ki-duotone').classList.replace('ki-minus-square','ki-plus-square');
            }
            box.classList.add('active');
            child.classList.replace('ki-plus-square', 'ki-minus-square');
        }
    }
</script>
</x-default-layout>