<!doctype html>
<html>
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


    <script src="/modules/core/Datastore/assets/datastore.js?ver=0.13.0" type="text/javascript"></script>
    <script src="/modules/core/Datastore/assets/js/index.js?ver=0.13.0" type="text/javascript"></script>
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

        <div data-ng-controller="datastore" ng-cloak>

            <nav class="uk-navbar uk-margin-large-bottom">
                <span class="uk-hidden-small uk-navbar-brand"><a href="/settingspage">Settings</a> / Datastore</span>
                <div class="uk-hidden-small uk-navbar-content" data-ng-show="tables && tables.length">
                    <form class="uk-form uk-margin-remove uk-display-inline-block">
                        <div class="uk-form-icon">
                            <i class="uk-icon-filter"></i>
                            <input type="text" placeholder="Filter by name..." data-ng-model="filter">
                        </div>
                    </form>
                </div>
                <ul class="uk-navbar-nav">
                    <li><a href="/datastore/table" title="Add table" data-uk-tooltip="{pos:'right'}"><i class="uk-icon-plus-circle"></i></a></li>
                </ul>
                <div class="uk-navbar-flip" data-ng-if="tables && tables.length">
                    <div class="uk-navbar-content">
                        <div class="uk-button-group">
                            <button class="uk-button" data-ng-class="mode=='list' ? 'uk-button-primary':''" data-ng-click="setListMode('list')" title="List mode" data-uk-tooltip="{pos:'bottom'}"><i class="uk-icon-th"></i></button>
                            <button class="uk-button" data-ng-class="mode=='table' ? 'uk-button-primary':''" data-ng-click="setListMode('table')" title="Table mode" data-uk-tooltip="{pos:'bottom'}"><i class="uk-icon-th-list"></i></button>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="uk-grid uk-grid-small" data-uk-grid-match data-ng-if="tables && tables.length && mode=='list'">
                <div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4 uk-grid-margin" data-ng-repeat="table in tables track by table._id" data-ng-show="matchName(table.name)">

                    <div class="app-panel">

                        <a class="uk-link-muted" href="/datastore/table/{{ table._id }}"><strong>{{ table.name }}</strong></a>

                        <div class="uk-margin">
                            <span class="uk-badge app-badge">{{ table.count }} Entries</span>
                        </div>

                        <div class="app-panel-box docked-bottom">

                            <div class="uk-link" data-uk-dropdown="{mode:'click'}">
                                <i class="uk-icon-bars"></i>
                                <div class="uk-dropdown">
                                    <ul class="uk-nav uk-nav-dropdown uk-nav-parent-icon">
                                        <li><a href="/datastore/table/{{ table._id }}"><i class="uk-icon-pencil"></i> Manage table</a></li>
                                        <li class="uk-danger"><a data-ng-click="remove($index, table)" href="#"><i class="uk-icon-minus-circle"></i> Delete table</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-panel" data-ng-if="tables && tables.length && mode=='table'">

                <table class="uk-table uk-table-striped" multiple-select="{model:tables}">
                    <thead>
                    <tr>
                        <th width="10"><input class="js-select-all" type="checkbox"></th>
                        <th width="60%">Table</th>
                        <th width="10%">Entries</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="js-multiple-select" data-ng-repeat="table in tables track by table._id" data-ng-show="matchName(table.name)">
                        <td><input class="js-select" type="checkbox"></td>
                        <td>
                            <a href="/datastore/table/{{ table._id }}">{{ table.name }}</a>
                        </td>
                        <td>{{ table.count }}</td>
                        <td>
                            <div class="uk-link uk-float-right" data-uk-dropdown>
                                <i class="uk-icon-bars"></i>
                                <div class="uk-dropdown">
                                    <ul class="uk-nav uk-nav-dropdown uk-nav-parent-icon">
                                        <li><a href="/datastore/table/{{ table._id }}"><i class="uk-icon-pencil"></i> Manage table</a></li>
                                        <li class="uk-danger"><a data-ng-click="remove($index, table)" href="#"><i class="uk-icon-minus-circle"></i> Delete table</a></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div class="uk-margin-top">
                    <button class="uk-button uk-button-danger" data-ng-click="removeSelected()" data-ng-show="selected"><i class="uk-icon-trash-o"></i> Delete</button>
                </div>

            </div>

            <div class="uk-text-center app-panel" data-ng-show="tables && !tables.length">
                <h2><i class="uk-icon-database"></i></h2>
                <p class="uk-text-large">
                    No tables yet.        </p>

                <a href="/datastore/table" class="uk-button uk-button-success uk-button-large">Create a table</a>
            </div>

        </div>        </div>
</div>

<script charset="utf-8" src="/i18n-js"></script>


</body>
</html>
