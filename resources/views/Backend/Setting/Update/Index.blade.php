
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
        <script src="/modules/core/Updater/assets/js/index.js?ver=0.13.0" type="text/javascript"></script>
        <h1><a href="/settingspage">Settings</a> / Update</h1>

        <div class="uk-margin-large-top" data-ng-controller="updater" ng-cloak>

            <div class="uk-text-center uk-width-medium-1-2 uk-container-center" ng-show="loading">

                <h2><i class="uk-icon-spinner uk-icon-spin"></i></h2>
                <p class="uk-text-large">
                    Getting information...        </p>

            </div>

            <div class="uk-text-center uk-width-medium-1-2 uk-container-center uk-animation-shake" ng-if="data && data.error">

                <h2><i class="uk-icon-bolt"></i></h2>
                <p class="uk-text-large">
                    {{ data.error }}
                </p>

            </div>


            <div ng-if="data && !data.error">

                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-medium-1-2">

                        <div class="app-panel">
                            <div class="uk-text-bold uk-text-muted">Local</div>
                            <div class="uk-h1 uk-text-muted">{{ data.local.version }}</div>

                            <div class="uk-text-bold uk-margin-top">Latest stable</div>
                            <div class="uk-h1">{{ data.stable.version }}</div>

                            <div class="uk-alert">
                                Don't forget to backup the cockpit folder before any update.                    </div>
                        </div>

                        <div class="uk-margin-top">
                            <button class="uk-button uk-button-primary" ng-click="install()">
                                <span class="tn" ng-if="(data.local.version==data.stable.version)"><i class="uk-icon-refresh"></i>&nbsp; Re-Install</span>
                                <span class="tn" ng-if="(data.local.version!=data.stable.version)"><i class="uk-icon-cloud-download"></i>&nbsp; Update</span>
                            </button>

                            or
                            <a ng-click="install('master')">Install latest development version</a> <span class="uk-badge app-badge">Danger</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<script charset="utf-8" src="/i18n-js"></script>


</body>
</html>
