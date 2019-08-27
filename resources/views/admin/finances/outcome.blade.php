<div class="form-group">
    {!! Form::label(trans("admin.safe")) !!}
    <select class="select2 form-control" name="safe_id" style="width: 100%" data-placeholder="{{ trans("admin.safe") }}">
    <option></option>
    @foreach(@App\Safe::all() as $safe)
    <option value="{{ $safe->id }}">{{ $safe->{app()->getLocale()."_name"} }}</option>
    @endforeach
    </select>
</div>




