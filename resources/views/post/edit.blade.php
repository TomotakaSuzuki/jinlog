<x-app-layout>
    <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                投稿の編集画面
            </h2>
            <x-validation-errors class="mb-4" :messages="$errors->all()"/>
            <x-message :message="session('message')" />
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <form method="post" action="{{route('post.update', $post)}}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="md:flex items-center mt-8">
                    <div class="w-full flex flex-col">
                    <label for="title" class="font-semibold leading-none mt-4">件名</label>
                    <input type="text" name="title" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="title" value="{{old('title', $post->title)}}" placeholder="タイトルを入力してください">
                    </div>
                </div>

                <div class="w-full flex flex-col">
                    <label for="body" class="font-semibold leading-none mt-4">本文</label>
                    <textarea name="body" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="body" cols="30" rows="10" placeholder='内容を書いてください'>{{old('body', $post->body)}}</textarea>
                </div>

                {{-- <div class="md:flex items-center mt-3">
                    <div class="w-full flex flex-col">
                    <label for="title" class="font-semibold leading-none mt-4">タグ</label>
                    <input type="text" name="tags" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="tags" value="
                        @if ($post->tags()->exists())
                        @foreach ($post->tags as $tag)
                            #{{ $tag->name }}
                        @endforeach
                        @endif
                    " placeholder="例. #登山 #海">
                    </div>
                </div> --}}

                <div class="w-full flex flex-col">
                    @if($post->image1)
                    <div>
                        (画像ファイル：{{$post->image1}})
                    </div>
                    <img src="{{ asset('storage/images/'.$post->image1)}}" class="mx-auto" style="height:300px;">
                    @endif
                    <label for="image1" class="font-semibold leading-none mt-4">画像(1MBまで)</label>
                    <div>
                    <input id="image1" type="file" name="image1">
                    </div>
                    @if($post->image2)
                    <div>
                        (画像ファイル：{{$post->image2}})
                    </div>
                    <img src="{{ asset('storage/images/'.$post->image2)}}" class="mx-auto" style="height:300px;">
                    @endif
                    <label for="image2" class="font-semibold leading-none mt-4">画像(1MBまで)</label>
                    <div>
                    <input id="image2" type="file" name="image2">
                    </div>
                    @if($post->image3)
                    <div>
                        (画像ファイル：{{$post->image3}})
                    </div>
                    <img src="{{ asset('storage/images/'.$post->image3)}}" class="mx-auto" style="height:300px;">
                    @endif
                    <label for="image3" class="font-semibold leading-none mt-4">画像(1MBまで)</label>
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