<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if (session()->has('error'))
                    <div class="mb-4 bg-red-500">
                        {{ session('error') }}
                    </div>
                @elseif(session()->has('message'))
                    <div class="mb-4 bg-green-500">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="form w-100">
                    <form wire:submit.prevent="verifyCode">
                        <!-- Enter Verification code-->
                        <div>
                            <h1 class="text-dark fw-bolder mb-3">Two Step Verification</h1>
                            <input wire:model="code" 
                                type="number" 
                                class="form-control bg-transparent"  
                                required autofocus />
                        </div>
                        <div class="flex items-center justify-end mt-4"> 
                            <button class="ml-3 btn btn-primary" type="submit">Submit</button>
                        </div>
                        <div class="flex items-center justify-end mt-4"> 
                            <a href="/logout">back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>