
<!doctype html>
<html lang="en" data-base="/" data-route="/" data-version="0.13.0" data-locale="en">
<head>
    <meta charset="UTF-8">
    <title>Cockpit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <script src="/storage/cache/assets/app.base0.13.0.js?ver=0.13.0" type="text/javascript"></script>
    <link href="/storage/cache/assets/app.base0.13.0.css?ver=0.13.0" type="text/css" rel="stylesheet" />
    <script src="/storage/cache/assets/app.backend0.13.0.js?ver=0.13.0" type="text/javascript"></script>

    <script src="/assets/js/angular/cockpit.js?ver=0.13.0" type="text/javascript"></script>
    <script>
        window.COCKPIT_SITE_BASE_URL  = '/';
        window.COCKPIT_MEDIA_BASE_URL = '';
    </script>

</head>
<body>

<nav class="uk-navbar app-top-navbar">

    <div class="app-wrapper">

        <ul class="uk-navbar-nav">
            <li class="uk-parent" data-uk-dropdown>
                <a href="/dashboard"><i class="uk-icon-bars"></i><strong class="uk-hidden-small"> &nbsp;Cockpit</strong></a>
                <div class="uk-dropdown uk-dropdown-navbar">
                    <ul class="uk-nav uk-nav-navbar uk-nav-parent-icon">
                        <li>
                            <a href="/accounts/account" class="uk-clearfix">
                                <img class="uk-rounded uk-float-left uk-margin-right" src="//www.gravatar.com/avatar/f84d37ce99493155ee296c2b746191d0?d=mm&s=40" width="40" height="40" alt="avatar">
                                <div class="uk-text-truncate"><strong>admin</strong></div>
                                <div class="uk-text-small uk-text-truncate">test@test.de</div>
                            </a>
                        </li>
                        <li class="uk-nav-divider"></li>
                        <li><a href="/dashboard"><i class="uk-icon-dashboard icon-spacer"></i> Dashboard</a></li>

                        <li class="uk-nav-header uk-text-truncate">General</li>

                        <li><a href="/settingspage"><i class="uk-icon-cog icon-spacer"></i> Settings</a></li>
                        <li><a href="/settings/addons"><i class="uk-icon-code-fork icon-spacer"></i> Addons</a></li>
                        <li class="uk-nav-divider"></li>
                        <li><a href="/auth/logout"><i class="uk-icon-power-off icon-spacer"></i> Logout</a></li>
                    </ul>
                </div>
            </li>
        </ul>

        <div class="uk-navbar-content uk-hidden-small">
            <form id="frmCockpitSearch" class="uk-search" data-uk-search="{source:'/cockpit-globalsearch', msgMoreResults:false, msgResultsHeader: 'Search Results', msgNoResults: 'No results found'}" onsubmit="return false;">
                <input class="uk-search-field" type="search" placeholder="Search..." autocomplete="off">
            </form>
        </div>

        <div class="uk-navbar-flip">

            <ul class="uk-navbar-nav app-top-navbar-links">
                <li class="" >
                    <a href="/collections" title="Collections" data-uk-tooltip><i class="uk-icon-list"></i></a>
                </li>
                <li class="" >
                    <a href="/forms" title="Forms" data-uk-tooltip><i class="uk-icon-inbox"></i></a>
                </li>
                <li class="" >
                    <a href="/galleries" title="Galleries" data-uk-tooltip><i class="uk-icon-picture-o"></i></a>
                </li>
                <li class="" >
                    <a href="/regions" title="Regions" data-uk-tooltip><i class="uk-icon-th-large"></i></a>
                </li>
                <li class="" >
                    <a href="/mediamanager" title="Mediamanager" data-uk-tooltip><i class="uk-icon-cloud"></i></a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<div class="app-main">
    <div class="app-wrapper">
        <script src="/modules/core/Addons/assets/addons.js?ver=0.13.0" type="text/javascript"></script>
        <script src="/modules/core/Addons/assets/js/index.js?ver=0.13.0" type="text/javascript"></script>

        <h1><a href="/settingspage">Settings</a> / Addons</h1>

        <div data-ng-controller="addons" ng-cloak>

            <div class="uk-grid">

                <div class="uk-width-3-4">

                    <div class="app-panel">

                        <table class="uk-table" ng-show="addons.length">
                            <tbody>
                            <tr ng-repeat="addon in addons">
                                <td class="uk-text-bold">{{ addon.name }}</td>
                                <td>{{ addon.description }}</td>
                                <td>
                                    <div ng-if="addon.homepage"><a href="{{ addon.homepage }}" target="_blank">{{ addon.homepage }}</a></div>
                                </td>
                                <td style="width:5%;text-align:center;">
                                    <div ng-if="addon.repo"><a href="{{ addon.repo }}" target="_blank"><i class="uk-icon-github uk-icon-hover"></i></a></div>
                                </td>
                                <td style="width:10%;text-align:right;">{{ addon.version }}</td>
                            </tr>
                            </tbody>
                        </table>


                        <div class="uk-text-center" ng-show="!addons.length">
                            <h2><i class="uk-icon-code-fork"></i></h2>
                            <p class="uk-text-large">
                                No additional addons installed.                    </p>
                        </div>

                    </div>

                </div>

                <div class="uk-width-1-4">



                </div>

            </div>

        </div>


        <script>

            window.ADDONS = [];

        </script>
    </div>
</div>

<script charset="utf-8" src="/i18n-js"></script>


</body>
</html>
