{{-- @if (request('keyword'))
    <input type="hidden" name="keyword" value="{{ request('keyword') }}">
@endif
@if (request('category'))
    <input type="hidden" name="category" value="{{ request('category') }}">
@endif
@if (request('merk'))
    <input type="hidden" name="merk" value="{{ request('merk') }}">
@endif
@if (request('sortby'))
    <input type="hidden" name="sortby" value="{{ request('sortby') }}">
@endif --}}

@if (request('m') == '1')
    @if (request('keyword'))
        <input type="hidden" name="keyword" value="{{ request('keyword') }}">
    @endif
    @if (request('category'))
        <input type="hidden" name="category" value="{{ request('category') }}">
    @endif
    @if (request('sortby'))
        <input type="hidden" name="sortby" value="{{ request('sortby') }}">
    @endif
@endif

@if (request('c') == '1')
    @if (request('keyword'))
        <input type="hidden" name="keyword" value="{{ request('keyword') }}">
    @endif
    @if (request('merk'))
        <input type="hidden" name="merk" value="{{ request('merk') }}">
    @endif
    @if (request('sortby'))
        <input type="hidden" name="sortby" value="{{ request('sortby') }}">
    @endif
@endif
