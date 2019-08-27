@extends('admin.index')

@section('content')
    <div class="filter-icon"><i class="fa fa-filter"></i></div>
    <div class="filter">
        <div class="col-xs-12">
            <label>{{ __('admin.developer') }}</label>
            <select class="select2 form-control" data-placeholder="{{ __('admin.developer') }}" id="developer">
                <option></option>
                <option value="all">{{ __('admin.all') }}</option>
                @foreach(@\App\Developer::get() as $dev)
                    <option value="{{ $dev->id }}">{{ $dev->{app()->getLocale().'_name'} }}</option>
                @endforeach
            </select>
            <div class="row">
                <div class="col-xs-6">
                    <label>{{ __('admin.min_rooms') }}</label>
                    <input type="text" class="form-control" id="min-rooms">
                </div>
                <div class="col-xs-6">
                    <label>{{ __('admin.max_rooms') }}</label>
                     <input type="text" class="form-control" id="max-rooms">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <label>{{ __('admin.min_bathrooms') }}</label>
                    <input type="text" class="form-control" id="min-bathrooms">
                </div>
                <div class="col-xs-6">
                    <label>{{ __('admin.max_bathrooms') }}</label>
                     <input type="text" class="form-control" id="max-bathrooms">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <label>{{ __('admin.min_price') }}</label>
                    <input type="text" class="form-control" id="min-price">
                </div>
                <div class="col-xs-6">
                    <label>{{ __('admin.max_price') }}</label>
                     <input type="text" class="form-control" id="max-price">
                </div>
            </div>
            <div class="row">
                 <div class="col-xs-12">
                    <label>{{ __('admin.locations') }}</label>
                    <select class="select2 form-control" data-placeholder="{{ __('admin.locations') }}" id="location">
                        <option></option>
                        <option value="all">{{ __('admin.all') }}</option>
                        @foreach(@\App\Location::get() as $dev)
                            <option value="{{ $dev->id }}">{{ $dev->{app()->getLocale().'_name'} }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

         <div class="row">
                <div class="col-xs-12">
                    <label>{{ __('admin.delivery_date') }}</label>
                    <input type="text" class="form-control" id="delivery-date">
                </div>
        </div>
        </div>
        </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $title }}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link" id="me-tab" data-toggle="tab" href="#me" role="tab" aria-controls="me" aria-selected="true">Me</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="others-tab" data-toggle="tab" href="#others" role="tab" aria-controls="others" aria-selected="false">Others</a>
                </li>
            </ul>
                <div class="tab-content" id="myTabContent">
                    <!--Me data !-->
                    <div class="tab-pane active" id="me" role="tabpanel" aria-labelledby="me-tab">
                        <div class="box-body">
                            <a class="btn btn-success btn-flat @if(app()->getLocale() == 'en') pull-right @else pull-left @endif"
                            href="{{ url(adminPath().'/resale_units/create') }}">{{ trans('admin.add') }}</a>
                    <table class="table datatableOthers table-striped table-bordered  dt-responsive nowrap"style="width:100%">
                        <thead>
                        <tr>
                            <th>{{ trans('admin.id') }}</th>
                            <th>{{ trans('admin.property') }}</th>
                            <th>{{ trans('admin.title') }}</th>
                            <th>{{ trans('admin.status') }}</th>
                            <th>{{ trans('admin.location') }}</th>
                            <th>{{ trans('admin.price') }}</th>
                            <th>{{ trans('admin.rooms') }}</th>
                            <th>{{ trans('admin.rooms') }}</th>
                            <th>{{ trans('admin.bathrooms') }}</th>
                            <th>{{ trans('admin.area') }}</th>
                            <th>{{ trans('admin.delivery_date') }}</th>
                            <th>{{ trans('admin.privacy') }}</th>
                            <th>{{ trans('admin.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($meUnits as $unit)
                            <tr>
                                <td>{{$unit->id}}</td>
                                <td><img src="{{ url(''.$unit->image) }}" width="75 px"></td>
                                <td>{{ $unit->{app()->getLocale().'_title'} }}</td>
                                <td>{{ trans('admin.'.$unit->availability) }}</td>
                                <td>{{ @\App\Location::find($unit->location)->{app()->getLocale().'_name'} }}</td>
                                <td>{{ $unit->total }}</td>
                                <td>{{ $unit->rooms }}</td>
                                <td>{{ $unit->bathrooms }}</td>
                                <td>{{ $unit->area }}</td>
                                <td>{{ $unit->delivery_date }}</td>
                                <td>{{ $unit->privacy }}</td>
                                <td><a href="{{ url(adminPath().'/resale_units/'.$unit->id) }}"
                                    class="btn btn-primary btn-flat">{{ trans('admin.show') }}</a>
                                    <a href="{{ url(adminPath().'/resale_units/'.$unit->id.'/edit') }}"
                                    class="btn btn-warning btn-flat">{{ trans('admin.edit') }}</a>
                                    <a data-toggle="modal" data-target="#delete{{ $unit->id }}"
                                    class="btn btn-danger btn-flat">{{ trans('admin.delete') }}</a></td>
                            </tr>
                            <div id="delete{{ $unit->id }}" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">{{ trans('admin.delete') . ' ' . trans('admin.resale_unit') }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{ trans('admin.delete') . ' ' . $unit->name }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            {!! Form::open(['method'=>'DELETE','route'=>['resale_units.destroy',$unit->id]]) !!}
                                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">{{ trans('admin.close') }}</button>
                                            <button type="submit" class="btn btn-danger btn-flat">{{ trans('admin.delete') }}</button>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
                <!--Others data !-->
                <div class="tab-pane fade" id="others" role="tabpanel" aria-labelledby="others-tab">
                    <div class="tab-pane" id="me" role="tabpanel" aria-labelledby="me-tab">        <div class="box-body">
                        <a class="btn btn-success btn-flat @if(app()->getLocale() == 'en') pull-right @else pull-left @endif"
                        href="{{ url(adminPath().'/resale_units/create') }}">{{ trans('admin.add') }}</a>
                        <table class="table datatable datatableMe table-striped table-bordered  dt-responsive nowrap"style="width:100%">
                            <thead>
                            <tr>
                                <th>{{ trans('admin.id') }}</th>
                                <th>{{ trans('admin.property') }}</th>
                                <th>{{ trans('admin.title') }}</th>
                                <th>{{ trans('admin.status') }}</th>
                                <th>{{ trans('admin.location') }}</th>
                                <th>{{ trans('admin.price') }}</th>
                                <th>{{ trans('admin.rooms') }}</th>
                                <th>{{ trans('admin.bathrooms') }}</th>
                                <th>{{ trans('admin.area') }}</th>
                                <th>{{ trans('admin.delivery_date') }}</th>
                                <th>{{ trans('admin.agent') }}</th>
                                <th>{{ trans('admin.privacy') }}</th>
                                <th>{{ trans('admin.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($othersUnits as $unit)
                                <tr>
                                    <td>{{$unit->id}}</td>
                                    <td><img src="{{ url(''.$unit->image) }}" width="75 px"></td>
                                    <td>{{ $unit->{app()->getLocale().'_title'} }}</td>
                                    <td>{{ trans('admin.'.$unit->availability) }}</td>
                                    <td>{{ @\App\Location::find($unit->location)->{app()->getLocale().'_name'} }}</td>
                                    <td>{{ $unit->total }}</td>
                                    <td>{{ $unit->rooms }}</td>
                                    <td>{{ $unit->bathrooms }}</td>
                                    <td>{{ $unit->area }}</td>
                                    <td>{{ $unit->delivery_date }}</td>
                                    <td>{{ $unit->lead->agent->name }}</td>
                                    <td>{{ $unit->privacy }}</td>
                                    <td><a href="{{ url(adminPath().'/resale_units/'.$unit->id) }}"
                                        class="btn btn-primary btn-flat">{{ trans('admin.show') }}</a>
                                        <a href="{{ url(adminPath().'/resale_units/'.$unit->id.'/edit') }}"
                                        class="btn btn-warning btn-flat">{{ trans('admin.edit') }}</a>
                                        <a data-toggle="modal" data-target="#delete{{ $unit->id }}"
                                        class="btn btn-danger btn-flat">{{ trans('admin.delete') }}</a></td>
                                </tr>
                                <div id="delete{{ $unit->id }}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">{{ trans('admin.delete') . ' ' . trans('admin.resale_unit') }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ trans('admin.delete') . ' ' . $unit->name }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                {!! Form::open(['method'=>'DELETE','route'=>['resale_units.destroy',$unit->id]]) !!}
                                                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">{{ trans('admin.close') }}</button>
                                                <button type="submit" class="btn btn-danger btn-flat">{{ trans('admin.delete') }}</button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>

    </div>
@endsection

@section('js')
        <script>
        $(document).on('change , keyup', '#developer,#min_price,#max_price,#min_rooms,#max_rooms,,#min_bathrooms,#max_bathrooms,#delivery-date,#location', function () {
            var dev = $('#developer').val();
            var min_price = $('#min_price').val();
            var max_price = $('#max_price').val();
            var min_area = $('#min_area').val();
            var max_area = $('#max_area').val();
            var location = $('#location').val();
            var installment = $('#installment').val();
            var min_down_payment = $('#min_down_payment').val();
            var max_down_payment = $('#max_down_payment').val();
            var _token = '{{ csrf_token() }}';
            $.ajax({
                url: "{{ url(adminPath().'/get_developer_projects')}}",
                method: 'post',
                dataType: 'html',
                data: {dev: dev,min_price : min_price,installment:installment,min_down_payment:min_down_payment,max_down_payment:max_down_payment,max_price : max_price,max_area : max_area,min_area : min_area,location:location, _token: _token},
                success: function (data) {
                    $('#data').html(data);
                }
            })
        })
    </script>
    <script>
        $('.datatableMe').dataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            "order": [[ 0, "desc" ]],
            'autoWidth': true
        });
        var filter_show = 0;
        $('.filter-icon').on('click',function () {

            if (!filter_show){
                $('.filter').css('right',0);
                $('.filter-icon').css('right','500px');
                filter_show = 1;
            }else{
                $('.filter').css('right','-500px');
                $('.filter-icon').css('right','0');
                filter_show = 0;
            }

        });
        $('.datatableOthers').dataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            "order": [[ 0, "desc" ]],
            'autoWidth': true
        });
        var filter_show = 0;
        $('.filter-icon').on('click',function () {

            if (!filter_show){
                $('.filter').css('right',0);
                $('.filter-icon').css('right','500px');
                filter_show = 1;
            }else{
                $('.filter').css('right','-500px');
                $('.filter-icon').css('right','0');
                filter_show = 0;
            }

        });
    </script>
@stop

@section('script')
<script>
   Vue.component('data-table', {
  render: function (createElement) {
    return createElement(
      "table", null, []
      )
  },
  props: ['comments'],
  data() {
    return {
      headers: [
        { title: 'Name' },
        { title: 'Email' },
        { title: 'Body' },
        ],
      rows: [] ,
      dtHandle: null
    }
  },
  watch: {
    comments(val, oldVal) {
      let vm = this;
      vm.rows = [];
      val.forEach(function (item) {
        let row = [];
        row.push(item.name);
        row.push('<a href="mailto://' + item.email + '">' + item.email + '</a>');
        row.push(item.body);
        vm.rows.push(row);
      });
      vm.dtHandle.clear();
      vm.dtHandle.rows.add(vm.rows);
      vm.dtHandle.draw();
    }
  },
  mounted() {
    let vm = this;
    vm.dtHandle = $(this.$el).DataTable({
      columns: vm.headers,
      data: vm.rows,
      searching: true,
      paging: true,
      info: false
    });
  }
});

new Vue({
  el: '#tabledemo',
  data: {
    comments: [],
    search: ''
  },
  computed: {
    filteredComments: function () {
      let self = this
      let search = self.search.toLowerCase()
      return self.comments.filter(function (comments) {
        return  comments.name.toLowerCase().indexOf(search) !== -1 ||
          comments.email.toLowerCase().indexOf(search) !== -1 ||
          comments.body.toLowerCase().indexOf(search) !== -1
      })
    }
  },
  mounted() {
    let vm = this;
    $.ajax({
      url: 'https://jsonplaceholder.typicode.com/comments',
      success(res) {
        vm.comments = res;
      }
    });
  }
});

</script>
@endsection
