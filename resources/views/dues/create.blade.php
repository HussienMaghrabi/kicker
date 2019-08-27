@extends('admin.index')

@section('content')
    <div class="box">
        <div class="box-body">
        <form method="POST" action="{{ url('/admin/dues') }}" >
            {{ csrf_field() }}
                <div class="form-group">
                    <label>Value</label>
                    <input type="number" name="value" style="width:100%;">
                </div>

                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" style="width:100%;">
                </div>

                <div class="form-group">
                    <label>Collected</label>
                    <select class="form-control" id="collected" name="collected">
                        <option></option>
                        <option value="collected">collected</option>
                        <option value="not collected" >not collected</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-flat">Submit</button>
                </div>
            </form>            
    </div>
@endsection
