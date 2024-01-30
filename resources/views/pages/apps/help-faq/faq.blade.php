<x-default-layout>
<div class="card help-faq p-15">
    <h1 class="title">Frequently Asked Questions</h1>
    <div class="wrap-question">
        <div class="box-question bg-state-body d-flex align-items-start " onclick="toggleAnswer(this)">
            {!! getIcon('plus-square', 'fs-2') !!}
            <div class="wrap-content">
                <h3 class="title-question">
                    When does CDSS need to submit payment report to CDA?
                </h3>
                <div class="content">
                    The report must be submitted by the 5th business day of each month through CDA’s secured website portal
                </div>
            </div>                     
        </div>
        <div class="box-question bg-state-body d-flex align-items-start " onclick="toggleAnswer(this)">
            {!! getIcon('plus-square', 'fs-2') !!}     
            <div class="wrap-content">
                <h3 class="title-question ">
                    When do counties need to submit the mRec or aRec reconciliation report to CDA?           
                </h3>
                <div class="content ">
                    The report must be submitted by the 5th business day of each month through CDA’s secured website portal.
                </div>
            </div>
        </div>
        <div class="box-question bg-state-body d-flex align-items-start" onclick="toggleAnswer(this)">
            {!! getIcon('plus-square', 'fs-2') !!}     
            <div class="wrap-content">
                <h3 class="title-question ">
                    I am having trouble submitting the report, who can I contact?
                </h3>
                <div class="content ">
                    Please contact our team at:
                    <br><br>
                    <strong>Daja Cayetano,</strong> <i>Project Coordinator</i>
                    <br>
                    <strong>Phone Number </strong>| (619) 205-6250 x1920
                    <br>
                    <strong>Email Address </strong>| <a href="mailto:dcayetano@cdasd.org">dcayetano@cdasd.org</a>
                    <br><br>
                    <strong>Liz Valadez,</strong> <i>Project Coordinator</i>
                    <br>
                    <strong>Phone Number </strong> | (619) 205-6250 x1923
                    <br>
                    <strong>Email Address </strong>| <a href="mailto:lvaladez@cdasd.org">lvaladez@cdasd.org</a>
                </div>
            </div>
        </div>
        <div class="box-question bg-state-body d-flex align-items-start" onclick="toggleAnswer(this)">
            {!! getIcon('plus-square', 'fs-2') !!}     
            <div class="wrap-content">
                <h3 class="title-question ">
                    How do I know the report I submitted was received by CDA?
                </h3>
                <div class="content ">
                    CDA’s secured portal is a one - way upload to CDA. Once you have submitted the report, you will not be able to access or download the report from the portal.
                    The user who submitted the report for your county will receive a confirmation email with details about the upload. You are also able to see the activity of
                    all users in your county under the  activity log.
                </div>
            </div>
        </div>
        <div class="box-question bg-state-body d-flex align-items-start" onclick="toggleAnswer(this)">
            {!! getIcon('plus-square', 'fs-2') !!}     
            <div class="wrap-content">
                <h3 class="title-question ">
                    I would like another user for my county, what can I do?        
                </h3>
                <div class="content ">
                    The portal has a limit of two (2) users per county. If you would like to update or disable a user account, please contact:
                    <br><br>
                    <strong>Daja Cayetano,</strong> <i>Project Coordinator</i>
                    <br>
                    <strong>Phone Number </strong>| (619) 205-6250 x1920
                    <br>
                    <strong>Email Address </strong>| <a href="mailto:dcayetano@cdasd.org">dcayetano@cdasd.org</a>
                    <br><br>
                    <strong>Liz Valadez,</strong> <i>Project Coordinator</i>
                    <br>
                    <strong>Phone Number </strong>| (619) 205-6250 x1923
                    <br>
                    <strong>Email Address </strong>| <a href="mailto:lvaladez@cdasd.org">lvaladez@cdasd.org</a>
                </div>
            </div>
        </div>
        <div class="box-question bg-state-body d-flex align-items-start" onclick="toggleAnswer(this)">
            {!! getIcon('plus-square', 'fs-2') !!}     
            <div class="wrap-content">
                <h3 class="title-question ">
                    How can a child care provider submit a W-9 Form to CDA?      
                </h3>
                <div class="content ">
                    Eligible child care providers can submit a W-9 Form to CDA electronically using the link below:
                    <br>
                    <br>
                    <ul>
                        <li>English: <a target="_blank" href="https://forms.cdasd.org/232275453406151" onclick="preventTabClose(event)">https://forms.cdasd.org/232275453406151</a></li>
                        <li>Spanish: <a target="_blank" href="https://forms.cdasd.org/232985402065154" onclick="preventTabClose(event)">https://forms.cdasd.org/232985402065154</a></li>
                    </ul>
                    <strong>Note: </strong><i>Even though it is not a requirement, CDA would appreciate counties supplying a copy of the provider’s W-9 Form that they have collected to help ensure timely payment to the child care provider. Click below to download a copy of the “Release of W-9 Form to CDA.”.</i>
                    <br/>
                    <br/>
                    <a id="download-faq" href="{{route('download-faq-w9')}}" onclick="preventTabClose(event)">Release of W-9 Form to CDA.pdf</a>
                </div>
            </div>
        </div>
        <div class="box-question bg-state-body d-flex align-items-start" onclick="toggleAnswer(this)">
            {!! getIcon('plus-square', 'fs-2') !!}     
            <div class="wrap-content">
                <h3 class="title-question ">
                    How can a child care provider get the status of their Cost of Care Plus Rate Payment?          
                </h3>
                <div class="content">
                    CDA is unable to issue payment without complete data and a valid W-9 Form. Once CDA has received all the information required, CDA will calculate and issue payment to the provider within 25 calendar days of complete information being received
                    <br>
                    <br>
                    CDA Project Specialists are available to assist providers with any questions they may have about the process. Providers may reach a CDA representative at (619) 205-6250.
                </div>
            </div>
        </div>
        <div class="box-question bg-state-body d-flex align-items-start" onclick="toggleAnswer(this)">
            {!! getIcon('plus-square', 'fs-2') !!}     
            <div class="wrap-content">
                <h3 class="title-question ">
                    How will child care providers receive payment? Will a receipt be included?           
                </h3>
                <div class="content ">
                    CDA will calculate and issue payment via check to eligible providers within 25 calendar days of complete information being received. An Explanation of Payment (EOP) letter will be included.
                    The EOP will show the payment month, child count, and applicable reduction of union due fees not to exceed $90.00
                    <br><br>
                    CDA Project Specialists are available to assist providers at (619) 205-6250 .
                </div>
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

    function preventTabClose(event) {
        event.stopPropagation();
    }
</script>
</x-default-layout>