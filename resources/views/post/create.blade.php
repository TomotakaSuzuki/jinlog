<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            投稿の新規作成
        </h2>
        <x-validation-errors class="mb-4" :messages="$errors->all()"/>
        <x-message :message="session('message')" />
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <form method="post" action="{{route('post.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="md:flex items-center mt-8">
                    <div class="w-full flex flex-col">
                    <label for="title" class="font-semibold leading-none mt-4">タイトル</label>
                    <input type="text" name="title" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="title" value="{{old('title')}}" placeholder="タイトルを入力してください">
                    </div>
                </div>

                <div class="w-full flex flex-col">
                    <label for="body" class="font-semibold leading-none mt-4">内容</label>
                    <textarea name="body" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="body" cols="30" rows="10" placeholder='内容を書いてください #海 #山'>{{old('body')}}</textarea>
                </div>

                {{-- <div class="md:flex items-center mt-3">
                    <div class="w-full flex flex-col">
                    <label for="title" class="font-semibold leading-none mt-4">タグ</label>
                    <input type="text" name="tags" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="tags" value="{{old('tags')}}" placeholder="例. #登山 #海">
                    </div>
                </div> --}}

                <div class="w-full flex flex-col">
                    <label for="image1" class="font-semibold leading-none mt-4">画像 （1MBまで）</label>
                    <div>
                    <input id="image1" type="file" name="image1">
                    </div>
                    <label for="image2" class="font-semibold leading-none mt-4">画像 （1MBまで）</label>
                    <div>
                    <input id="image2" type="file" name="image2">
                    </div>
                    <label for="image3" class="font-semibold leading-none mt-4">画像 （1MBまで）</label>
                    <div>
                    <input id="image3" type="file" name="image3">
                    </div>
                </div>

                <x-primary-button class="mt-4">
                    送信する
                </x-primary-button>
                
            </form>
        </div>
    </div>
</x-app-layout>