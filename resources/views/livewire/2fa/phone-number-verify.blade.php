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

                <div class="bg-gray-200 p-10">
                    <form wire:submit.prevent="verifyCode">
                        <!-- Enter Verification code-->
                        <div>
                            <h5>Two-Factor Authentication</h5>
                            <input wire:model="code" 
                                type="number" 
                                class="block mt-1 w-full"  
                                required autofocus />
                        </div>
                        <div class="flex items-center justify-end mt-4"> 
                            <button class="ml-3" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>