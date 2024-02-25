<label for="main_icon" class="form-label">{{ $label }} </label>
<select class="form-select" name="{{ $name }}" id="{{ $id }}">
    @if ($boolean == true)
        <option value="no" @selected($value == 'no')>No</option>
        <option value="yes" @selected($value == 'yes')>Yes</option>
    @else
        {!! $slot !!}
    @endif
</select>