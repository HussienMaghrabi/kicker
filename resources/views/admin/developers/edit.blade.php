@extends('admin.index')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $title }}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{ url(adminPath().'/developers/'.$developer->id) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="put">
                <div class="form-group col-md-6 @if($errors->has('en_name')) has-error @endif">
                    <label>{{ trans('admin.en_name') }}</label>
                    <input type="text" name="en_name" class="form-control" value="{{ $developer->en_name }}" placeholder="{!! trans('admin.en_name') !!}">
                </div>
                <div class="form-group col-md-6 @if($errors->has('ar_name')) has-error @endif">
                    <label>{{ trans('admin.ar_name') }}</label>
                    <input type="text" name="ar_name" class="form-control" value="{{ $developer->ar_name  }}" placeholder="{!! trans('admin.ar_name') !!}">
                </div>
                <div class="form-group col-md-6 @if($errors->has('en_description')) has-error @endif">
                    <label> {{ trans('admin.en_description') }}</label>
                    <textarea  name="en_description" class="form-control" value="{{ $developer->en_description }}" placeholder="{!! trans('admin.en_description') !!}" rows="6">{{ $developer->en_description }}</textarea>
                </div>
                <div class="form-group col-md-6 @if($errors->has('ar_description')) has-error @endif">
                    <label> {{ trans('admin.ar_description') }}</label>
                    <textarea  name="ar_description" class="form-control" value="{{ $developer->ar_description }}" placeholder="{!! trans('admin.ar_description') !!}" rows="6">{{ $developer->ar_description }}</textarea>
                </div>
                <div class="form-group col-md-6 @if($errors->has('email')) has-error @endif col-md-11">
                    <label>{{ trans('admin.email') }}</label>
                    <input type="email" name="email" class="form-control" value="{{ $developer->email }}"
                           placeholder="{!! trans('admin.email') !!}">
                </div>
                <div class="form-group col-md-6 @if($errors->has('phone')) has-error @endif col-md-11">
                    <label>{{ trans('admin.phone') }}</label>
                    <input type="number" name="phone" class="form-control" value="{{ $developer->phone }}"
                           placeholder="{!! trans('admin.phone') !!}">
                </div>
                <div class="form-group col-md-9 @if($errors->has('phone')) has-error @endif">
                    <label>{{ trans('admin.facebook') }}</label>
                    <input type="text" name="facebook" class="form-control" value="{{ $developer->facebook }}"
                           placeholder="{!! trans('admin.facebook') !!}">
                </div>

                <div class="form-group @if($errors->has('payment_method')) has-error @endif col-md-3">
                    <br/>
                    <input type="hidden" name="featured" value="0">
                    <input type="checkbox" name="featured" class="switch-box" data-on-text="{{ __('admin.yes') }}"
                           data-off-text="{{ __('admin.no') }}" data-label-text="{{ __('admin.featured') }}" @if($developer->featured == 1) checked @endif value="1">
                </div>

                <div class="form-group col-md-6" style="z-index:999999">
                    <label>Cil Expire Date</label>
                    <input type="text" readonly="" name="cil_expire_date" class="form-control datepicker" id="cil_expire_date">
                </div>

                <div class="clearfix"></div>

                <div class="input-group image-preview col-md-12">
                    <label>{{ trans('admin.logo') }}</label>
                    <input type="text" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
                    <span class="input-group-btn">
                    <!-- image-preview-clear button -->
                    <button type="button" class="btn btn-default image-preview-clear" style="display:none; margin-top: 25px;">
                        <span class="glyphicon glyphicon-remove"></span> {{ trans('admin.clear') }}
                    </button>
                        <!-- image-preview-input -->
                    <div class="btn btn-default image-preview-input" style="margin-top: 25px;">
                        <span class="glyphicon glyphicon-folder-open"></span>
                        <span class="image-preview-input-title">{{ trans('admin.browse') }}</span>

                        <input type="file" id="imageInput" accept="image/png, image/jpeg, image/gif" name="image"/> <!-- rename it -->
                    </div>
                </span>

                </div><!-- /input-group image-preview [TO HERE]-->
                @if(isset($developer->website_cover))
                    <img src="{{ url('uploads/'.$developer->website_cover) }}" width="200px">
                @endif
                <div class="input-group image-preview col-md-12">
                    <label>{{ trans('admin.website_cover') }}</label><br>
                    <label>{{ trans('admin.best_image') }} 1900 * 536</label>
                    <input type="file" accept="image/png, image/jpeg, image/gif" name="website_cover"/> <!-- rename it -->
                    <input type="hidden" value="{{$developer->website_cover}}" name="old_website_cover">
                </div>
                <div class="popover fade bottom in" role="tooltip" id="oldImage" style="top: 480px; left: 532px; display: block;">
                    <div class="arrow" style="left: 50%;"></div>
                    <h3 class="popover-title">
                        <strong>Preview</strong>
                        <button type="button" id="close-preview" style="font-size: initial;" class="close pull-right">x</button>
                    </h3>
                    <div class="popover-content">
                        <img id="dynamic" src="{{ url('uploads/'.$developer->logo) }}" style="width: 250px; height: 200px;">
                    </div>
                </div>
                <div class="form-group @if($errors->has('xls')) has-error @endif">
                            <label for="validatedCustomFile">XSL Email Format File:</label><a href="{{url('uploads/'.$developer->xls_url)}}">Link Xsl</a>
                            <input type="file" name="xls" class="custom-file-input" id="validatedCustomFile" value="{{$developer->xls_url}}" >
                            @if($errors->has('xls'))<label class="invalid-feedback has-error">--invalid xls file ...</label>@endif
                </div>
                <br/>
                <div class="text-center">
                            <br>
                            <button type="button" class="btn btn-success btn-flat"
                                    id="addContact">{{ trans('admin.add_contact') }}</button>
                </div>
                <span id="contacts">
                @foreach($developer->contact as $k => $contact)
                <div class="well" style="height: 150px" id="removeContact{{$k}}">
                    <div class="form-group col-md-4"> 
                    <label>{{ trans("admin.name") }}</label> 
                    <input type="text" name="contact_name[]" class="form-control" value="{{$contact->name}}"> 
                    </div> 
                    <div class="form-group col-md-4"> 
                    <label>{{ trans("admin.phone") }}</label> 
                    <input type="number" name="contact_phone[]" class="form-control"  value="{{$contact->phone}}"> 
                    </div> 
                    <div class="form-group col-md-4"> 
                    <label>{{ trans("admin.email") }}</label> 
                    <input type="email" name="contact_email[]" class="form-control" value="{{$contact->email}}"> 
                    </div> 
                    <div class="text-center"> 
                    <button type="button" class="btn btn-danger btn-flat removeContact" contact="{{$contact->id}}" num="{{$k}}"> 
                    {{ trans("admin.remove") }}</button> 
                    </div> 
                </div>
                @endforeach
                </span>
                <textarea name="mail_temp" id="editor">
                               {{$developer->mail_temp}}
                </textarea>
                <button type="submit" class="btn btn-primary btn-flat">{{ trans('admin.submit') }}</button>
            </form>
        </div>
    </div>
@endsection
@section('js')
<script>
        CKEDITOR.plugins.add('strinsert',
    {
	requires : ['richcombo'],
	init : function( editor )
	{
		//  array of strings to choose from that'll be inserted into the editor
		var strings = [];
        strings.push([' $lead_first_name ', 'Lead First Name', 'Lead First Name']);
        strings.push([' $lead_last_name ', 'Lead Last Name', 'Lead Last Name']);
        strings.push([' $lead_creation_date ', 'Lead Creation Date', 'Lead Creation Date']);
        strings.push([' $lead_address ', 'Lead Address', 'Lead Address']);
        strings.push([' $lead_phone ', 'Lead Phone', 'Lead Phone']);
        strings.push([' $lead_email ', 'Lead Email', 'Lead Email']);
        strings.push([' $lead_agent ', 'Lead Agent', 'Lead Agent']);
        strings.push([' $developer_name ', 'Developer Name', 'Developer Name']);
        strings.push([' $developer_email ', 'Developer Email', 'Developer Email']);
        strings.push([' $developer_phone ', 'Developer Phone', 'Developer Phone']);
        strings.push([' $project_name ', 'Project Name', 'Project Name']);
        strings.push([' $project_address ', 'Project Address', 'Project Address']);
		// add the menu to the editor
		editor.ui.addRichCombo('strinsert',
		{
			label: 		'Insert Info',
			title: 		'Insert Info',
			voiceLabel: 'Insert Info',
			className: 	'cke_format',
			multiSelect:false,
			panel:
			{
				css: [ editor.config.contentsCss, CKEDITOR.skin.getPath('editor') ],
				voiceLabel: editor.lang.panelVoiceLabel
			},

			init: function()
			{
				this.startGroup( "Insert Content" );
				for (var i in strings)
				{
					this.add(strings[i][0], strings[i][1], strings[i][2]);
				}
			},

			onClick: function( value )
			{
				editor.focus();
				editor.fire( 'saveSnapshot' );
				editor.insertHtml(value);
				editor.fire( 'saveSnapshot' );
			}
		});
	}
});
        CKEDITOR.replace( 'editor', { extraPlugins: 'strinsert' } );
        $('#close-preview').on('click',function () {
            $('#oldImage').hide(200);
        })

        $('#imageInput').on('change',function () {
            $('#oldImage').hide(200);
        })
    </script>
        <script>
        var y = 1;
        $(document).on('click', '#addContact', function () {
            $('#contacts').append('<div class="well" style="height: 150px" id="removeContact'+y+'">' +
                '<div class="form-group col-md-4">' +
                '<label>{{ trans("admin.name") }}</label>' +
                '<input type="text" name="contact_name[]" class="form-control"' +
                'placeholder="{{ trans("admin.name") }}">' +
                '</div>' +
                '<div class="form-group col-md-4">' +
                '<label>{{ trans("admin.phone") }}</label>' +
                '<input type="number" name="contact_phone[]" class="form-control" value=""' +
                'placeholder="{!! trans("admin.phone") !!}">' +
                '</div>' +
                '<div class="form-group col-md-4">' +
                '<label>{{ trans("admin.email") }}</label>' +
                '<input type="email" name="contact_email[]" class="form-control"' +
                'placeholder="{!! trans("admin.email") !!}">' +
                '</div>' +
                '<div class="text-center">' +
                '<button type="button" class="btn btn-danger btn-flat removeContact" num="'+y+'">' +
                '{{ trans("admin.remove") }}</button>' +
                '</div>' +
                '</div>');
            x++
        });

        $(document).on('click', '.removeContact', function () {
            num = $(this).attr('num');
            $('#removeContact' + num).remove();
        })
    </script>
@endsection
