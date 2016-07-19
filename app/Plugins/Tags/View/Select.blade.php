<select class="uk-width-1-1 uk-margin-bottom" name="{{ $label }}">
    @foreach( explode('|',$attach->options) as $key => $option )
        <option value="{{ $option }}" {{ $attach->default == $option ? 'selected="selected"' : null }}>{{ $option }}</option>
    @endforeach
</select>
