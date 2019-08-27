<aside class="col-md-4 col-xs-12 ">
    <div class="property-query-area clearfix">
        <form class="callus" action="{{ url('search') }}" method="post" style="padding: 20px">
            {{ csrf_field() }}
            <h2 class="text-uppercase t_white bottom20 text-center">{{ __('admin.filter') }}</h2>
            <div class="row">
                <div class="col-sm-12">
                    <div class="single-query">
                        <input type="text" name="keyword" id="keyword" class="keyword-input" placeholder="{{ __('admin.Keyword (e.g. "office")') }}">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="single-query bottom15">
                        <select name="location" id="location" class="select2" data-placeholder="{{ trans('admin.select_location') }}">
                            <option></option>
                            @foreach($search['region'] as $location)
                                <option value="{{ $location['id'] }}">{{  $location['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


            </div>
            <div class="row">
                <input type="hidden" name="min_price" id="min_price" value="{{ $search['data']['project_personal_min_price'] }}">
                <input type="hidden" name="max_price" id="max_price" value="{{ $search['data']['project_personal_max_price'] }}">
                <input type="hidden" name="min_area" id="min_area" value="{{ $search['data']['project_personal_min_area'] }}">
                <input type="hidden" name="max_area" id="max_area" value="{{ $search['data']['project_personal_max_area'] }}">
                <div class="col-md-12 col-sm-12 col-xs-12 bottom15">
                    <div class="single-query-slider">
                        <div class="clearfix top20">
                            <label class="pull-left" id="price_lable">{{ trans('admin.price') }}</label>
                            <div class="price text-right">
                                (
                                <div class="leftLabel" id="mi_price"></div>
                                <span> {{ __('admin.egp') }}</span> )
                                <span>{{ __('admin.to') }} ( <div class="rightLabel" id="ma_price"></div> {{ __('admin.egp') }} )</span>

                            </div>
                        </div>
                        <div id="price_range" data-range_min="{{ $search['data']['project_personal_min_price'] }}"
                                data-range_max="{{ $search['data']['project_personal_max_price'] }}"
                                data-cur_min="{{ $search['data']['project_personal_min_price'] }}"
                                data-cur_max="{{ $search['data']['project_personal_max_price'] }}"
                                class="nstSlider">
                            <div class="bar"></div>
                            <div class="leftGrip"></div>
                            <div class="rightGrip"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 bottom15">
                    <div class="single-query-slider">
                        <div class="clearfix top20">
                            <label class="pull-left">{{ __('admin.area_range') }}</label>
                            <div class="price text-right"> (
                                <div class="leftLabel" id="mi_area"></div>
                                {!!  __('admin.m2') !!} ) </span>

                                <span>{{ __('admin.to') }} ( <div class="rightLabel" id="ma_area"></div> {!!  __('admin.m2') !!} )</span>
                            </div>
                        </div>
                        <div id="area_range" data-range_min="{{ $search['data']['project_personal_min_area'] }}"
                                data-range_max="{{ $search['data']['project_personal_max_area'] }}"
                                data-cur_min="{{ $search['data']['project_personal_min_area'] }}"
                                data-cur_max="{{ $search['data']['project_personal_max_area'] }}"
                                class="nstSlider">
                            <div class="bar"></div>
                            <div class="leftGrip"></div>
                            <div class="rightGrip"></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row" id="facility1">
                <div class="col-sm-12">
                    <div class="group-button-search">
                        <a data-toggle="collapse" href=".search-propertie-filters" class="more-filter">
                            <i class="fa fa-plus text-1" aria-hidden="true"></i><i class="fa fa-minus text-2 hide"
                                                                                    aria-hidden="true"></i>
                            <div class="text-1">{{ __('admin.Show more search options') }}</div>
                            <div class="text-2 hide">{{ __('admin.less more search options') }}</div>
                        </a>
                    </div>
                    <div class="search-propertie-filters collapse">
                        <div class="container-2">
                            <div class="row">
                                @foreach($search['facilities'] as $facility)
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="search-form-group white bottom10">
                                            <input type="checkbox" class="checkbox" value="{{ $facility['id'] }}"
                                                    name="check-box"/>
                                            <span>{{ $facility['name'] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @include('website.featured_projects',['featured',$featured])
</aside>
