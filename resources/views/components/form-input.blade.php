@props([
    'name',
    'type' => 'text',
    'value' => '',
    'size' => 6,
    'placeholder' => 'Enter '.ucfirst($name).' here',
    'label' => 'Input Field',
    'class' => 'form-control',
    'required' => false,
    'disabled' => false,
])

<div class="form-group col-md-{{$size}}">
    <label>{{ $label }}</label>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        class="{{ $class }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
    />
    @error($name)<p classs="text-danger">{{ $message  }}</p>@enderror
</div>
