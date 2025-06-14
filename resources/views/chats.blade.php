@extends('layouts.sharedlayout')

@section('title', 'Chats')

@section('content')
<div  class=" content-section flex mx-10 justify-center  min-h-full">
    <div  class="bg-gradient-to-r p-10 from-[#1F1E1E]/100 to-[#100E00]/80 border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px]  mt-32 w-[100%] mb-10 h-full backdrop-blur-sm flex flex-col">
            <div class="w-[100%] ">
                <div class="liquid-card border-[.5px] border-white shadow-lg shadow-[#000000]/40 rounded-[15px] p-6 h-full backdrop-blur-sm">
                    <!-- Title Section with Enhanced Cart Button -->
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-white" style="font-family: 'Kalam', cursive; text-shadow: -2px 1px 0px #047705;">Chat with Admin</h2>
                    </div>
                    <hr class="border-[.5px] border-white mb-6 -mx-6">
                </div>
            </div>
        </div>
    </div>
</div>
@include('uniforms.modals')


@endsection