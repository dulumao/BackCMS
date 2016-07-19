@if ( isset( $attach->default ) )
<input class="uk-width-1-1" type="text" name="{{ $label }}" value="{{ $value or $attach->default }}">
@else
    <input class="uk-width-1-1" type="text" name="{{ $label }}" value="{{ $value or  null }}">
@endif
