@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1 list-disc']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
        @if(empty($errors->first('image')))
        <li>画像ファイルがあれば、再度、選択してください。</li>
    @endif
    </ul>
@endif

