<div class="row">
    <div class="col-md-12">
        <h3 class="bottom40 margin40 text-left">{{ __('admin.featured_projects') }}</h3>
    </div>
</div>
@foreach($featured as $project)
<div class="row bottom20">
    <div class="col-md-4 col-sm-4 col-xs-6 p-image">
        @if(Session::get('Newlang') == 'ar')
            <a href="{{ url('ar/project/'.slug($project->{app()->getLocale().'_title'}).'-'.$project->id) }}">
        @elseif(Session::get('Newlang') == 'en')
            <a href="{{ url('en/project/'.slug($project->{app()->getLocale().'_title'}).'-'.$project->id) }}">
        @endif
        <img src="{{ url('uploads/'.$project->cover) }}" alt="{{ $project->{app()->getLocale().'_name'} }}" style="width: 100px;"/>
        </a>
    </div>
    <div class="col-md-8 col-sm-8 col-xs-6">
        <div class="feature-p-text">
            <h4>{{ $project[app()->getLocale().'_name'] }}</h4>
            <p class="bottom15">{{ @App\Location::find($project->location_id)->{app()->getLocale().'_name'} }}</p>
            <a href="{{ url('project/'.slug($project->{app()->getLocale().'_title'}).'-'.$project->id) }}">{{ $project->meter_price }}  {{ __('admin.egp') }}</a>
        </div>
    </div>

</div>
@endforeach
