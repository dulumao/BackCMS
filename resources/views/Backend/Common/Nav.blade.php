<nav class="uk-navbar app-top-navbar">
    <div class="app-wrapper">
        <ul class="uk-navbar-nav">
            <li class="uk-parent" data-uk-dropdown>
                <a href="{{ URL::action('Backend\DashboardController@getIndex') }}">
                    <i class="uk-icon-bars"></i>
                    <strong class="uk-hidden-small"> &nbsp;{{ $config['web_name'] }}</strong>
                </a>
                <div class="uk-dropdown uk-dropdown-navbar">
                    <ul class="uk-nav uk-nav-navbar uk-nav-parent-icon">
                        <li>
                            <a href="{{ Action('Backend\SettingController@getAdminEdit',Auth('admin')->user()->id) }}" class="uk-clearfix">
                                <img class="uk-rounded uk-float-left uk-margin-right"
                                     src="{{ Auth('admin')->user()->avatar }}"
                                     style="width: 40px;height: 40px" alt="avatar">
                                <div class="uk-text-truncate"><strong>{{ Auth('admin')->user()->username }}</strong>
                                </div>
                                <div class="uk-text-small uk-text-truncate">{{ Auth('admin')->user()->email }}</div>
                            </a>
                        </li>
                        <li class="uk-nav-divider"></li>
                        <li><a href="{{ Action('Backend\DashboardController@getIndex') }}"><i class="uk-icon-dashboard icon-spacer"></i> 控制中心</a></li>
                        <li class="uk-nav-header uk-text-truncate">管理</li>

                        <li><a href="{{ Action('Backend\SettingController@getIndex') }}"><i class="uk-icon-cog icon-spacer"></i> 设置</a></li>
                        {{--<li><a href="{{ Action('Backend\SettingController@getAddons') }}"><i class="uk-icon-code-fork icon-spacer"></i> 插件</a></li>--}}
                        <li class="uk-nav-divider"></li>
                        <li><a href="{{ Action('Backend\LoginController@getLogout') }}"><i class="uk-icon-power-off icon-spacer"></i> 退出</a></li>
                    </ul>
                </div>
            </li>
        </ul>

        <div class="uk-navbar-content uk-hidden-small">
            {{--<form id="frmCockpitSearch" class="uk-search"
                  data-uk-search="{source:'/cockpit-globalsearch', msgMoreResults:false, msgResultsHeader: 'Search Results', msgNoResults: 'No results found'}"
                  onsubmit="return false;">
                <input class="uk-search-field" type="search" placeholder="搜索..." autocomplete="off">
            </form>--}}
        </div>

        <div class="uk-navbar-flip">
            <ul class="uk-navbar-nav app-top-navbar-links">
                {{--<li class="">
                    <a href="/collections" title="Collections" data-uk-tooltip><i class="uk-icon-list"></i></a>
                </li>
                <li class="">
                    <a href="/forms" title="Forms" data-uk-tooltip><i class="uk-icon-inbox"></i></a>
                </li>
                <li class="">
                    <a href="/galleries" title="Galleries" data-uk-tooltip><i class="uk-icon-picture-o"></i></a>
                </li>
                <li class="">
                    <a href="/regions" title="Regions" data-uk-tooltip><i class="uk-icon-th-large"></i></a>
                </li>--}}
                @permission('Template.Index')
                <li class="">
                    <a href="{{ Action('Backend\TemplateController@getIndex') }}" title="模版" data-uk-tooltip><i class="uk-icon-pencil-square-o"></i></a>
                </li>
                @endpermission
                <li>
                    <a href="{{ Action('Backend\ManagerController@getIndex') }}" title="文件管理" data-uk-tooltip><i class="uk-icon-cloud"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>