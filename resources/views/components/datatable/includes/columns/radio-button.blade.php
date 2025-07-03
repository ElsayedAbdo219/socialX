@props(['name', 'options' => [], 'selected' => null])

<div class="flex flex-col gap-2 items-start">
    @foreach ($options as $value => $label)
        <label class="inline-flex items-center space-x-2 cursor-pointer">
            <input type="radio" name="{{ $name }}" value="{{ $value }}" data-user-id="{{ $userId ?? '' }}"
                onchange="changeValVerification(this)" {{ $selected == $value ? 'checked' : '' }}
                class="text-blue-600 focus:ring-blue-500 border-gray-300">
            <span class="text-sm {{ $value == 1 ? 'text-green-600' : 'text-red-600' }}">
                {{ $label }}
            </span>

        </label>
    @endforeach
</div>
