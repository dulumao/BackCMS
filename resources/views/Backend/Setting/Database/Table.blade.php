
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


    <script src="/modules/core/Datastore/assets/datastore.js?ver=0.13.0" type="text/javascript"></script>
    <script src="/modules/core/Datastore/assets/js/table.js?ver=0.13.0" type="text/javascript"></script>
    <script src="/assets/vendor/codemirror/codemirror.js?ver=0.13.0" type="text/javascript"></script>
    <link href="/assets/vendor/codemirror/codemirror.css?ver=0.13.0" type="text/css" rel="stylesheet">
    <link href="/assets/vendor/codemirror/pastel-on-dark.css?ver=0.13.0" type="text/css" rel="stylesheet">
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

        <div data-ng-controller="table" data-id="" ng-cloak>


            <nav class="uk-navbar uk-margin-bottom">

        <span class="uk-navbar-brand">
            <a href="/datastore">Datastore</a> /
            <span class="uk-text-muted" ng-show="!table.name">Table</span>
            <span ng-show="table.name">{{ table.name }}</span>
        </span>

                <ul class="uk-navbar-nav" data-ng-show="table._id">
                    <li><a class="uk-text-danger" ng-click="emptytable()" title="Empty table" data-uk-tooltip="{pos:'bottom'}"><i class="uk-icon-trash-o"></i></a></li>
                    <li><a title="Add entry" data-uk-tooltip="{pos:'bottom'}" ng-click="edit({})"><i class="uk-icon-plus-circle"></i></a></li>
                </ul>

                <div class="uk-navbar-flip" data-ng-show="table._id">
                    <ul class="uk-navbar-nav">
                        <li>
                            <a href="/api/datastore/export/{{ table._id }}" download="{{ table.name }}.json" title="Export data" data-uk-tooltip="{pos:'bottom'}">
                                <i class="uk-icon-share-alt"></i>
                            </a>
                        </li>
                    </ul>
                </div>

            </nav>


            <div class="uk-form" data-ng-show="table">

                <div class="uk-grid">

                    <div class="uk-width-1-1">

                        <div class="app-panel">

                            <form data-ng-submit="save()">

                                <div class="uk-form-row">
                                    <input class="uk-width-1-1 uk-form-blank uk-form-large" type="text" placeholder="Name" data-ng-model="table.name" required>
                                </div>

                                <div class="uk-form-row">
                                    <input class="uk-width-1-1 uk-form-blank uk-form-large uk-text-muted" type="text" placeholder="Preview fields" data-ng-model="table.preview" ng-list>
                                </div>

                                <div class="uk-form-row">
                                    <button class="uk-button uk-button-primary">Save</button>
                                </div>
                            </form>

                            <div class="uk-margin-top uk-text-large uk-text-muted" data-ng-show="table._id && entries && !entries.length">
                                <hr>
                                No Entries                    </div>

                            <div class="uk-margin-top" data-ng-show="table._id && entries && entries.length">

                                <hr>

                                <div class="uk-form-row">
                                    <span class="uk-badge app-badge">Entries</span>
                                </div>

                                <table class="uk-table uk-table-striped" multiple-select="{model:entries}">
                                    <thead>
                                    <tr>
                                        <th width="10"><input class="js-select-all" type="checkbox"></th>
                                        <th>
                                            Data                                    </th>
                                        <th width="20%">Modified</th>
                                        <th width="5%">&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="js-multiple-select" data-ng-repeat="entry in entries track by entry._id">
                                        <td><input class="js-select" type="checkbox"></td>
                                        <td>

                                            <div class="uk-text-small" data-ng-repeat="field in table.preview" ng-if="table.preview && table.preview.length">
                                                <div><strong>{{ field }}:</strong></div>
                                                <div class="uk-margin-small-top uk-margin-small-bottom uk-text-muted">{{ entry[field] || 'n/a' }}</div>
                                            </div>

                                            <div class="uk-text-small" data-ng-repeat="(key, value) in entry" ng-if="!(table.preview && table.preview.length)">
                                                <div><strong>{{ key }}:</strong></div>
                                                <div class="uk-margin-small-top uk-margin-small-bottom uk-text-muted">{{ value }}</div>
                                            </div>
                                        </td>
                                        <td>{{ entry.modified | fmtdate:'d M, Y H:i' }}</td>
                                        <td class="uk-text-right">
                                            <div data-uk-dropdown>
                                                <i class="uk-icon-bars"></i>
                                                <div class="uk-dropdown uk-dropdown-flip uk-text-left">
                                                    <ul class="uk-nav uk-nav-dropdown uk-nav-parent-icon">
                                                        <li><a href="#" data-ng-click="edit(entry)"><i class="uk-icon-pencil"></i> Edit entry</a></li>
                                                        <li><a href="#" class="uk-text-danger" data-ng-click="remove($index, entry._id)"><i class="uk-icon-trash-o"></i> Delete entry</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="uk-margin-top">
                                    <button class="uk-button uk-button-primary" data-ng-click="loadmore()" data-ng-show="entries && !nomore">Load more...</button>
                                    <button class="uk-button uk-button-danger" data-ng-click="removeSelected()" data-ng-show="selected"><i class="uk-icon-trash-o"></i> Delete entries</button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div id="entry-editor">
            <nav class="uk-navbar">
                <div class="uk-navbar-content">
                    <i class="uk-icon-database"></i> &nbsp; <strong class="uk-text-small filename"></strong>
                </div>
                <ul class="uk-navbar-nav">
                    <li><a data-editor-action="save" title="Save entry" data-uk-tooltip="{pos:'right'}"><i class="uk-icon-save"></i></a></li>
                </ul>
                <div class="uk-navbar-flip">
                    <ul class="uk-navbar-nav">
                        <li><a data-editor-action="close" title="Close" data-uk-tooltip="{pos:'left'}"><i class="uk-icon-times"></i></a></li>
                    </ul>
                </div>
            </nav>
            <textarea></textarea>
        </div>

        <style>

            /* editor */

            #entry-editor {
                display: none;
                position: fixed;
                left: 0;
                top: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.3);
                border: 10px rgba(0,0,0,0.3) solid;
                z-index: 100;
            }

            #entry-editor .uk-navbar {
                background: #f7f7f7;
                border-radius: 3px 3px 0 0;
            }

            #entry-editor .CodeMirror {
                border: none;
                border-radius:  0 0 3px 3px;
            }

            #entry-editor a { cursor: pointer; }

        </style>
    </div>
</div>

<script charset="utf-8" src="/i18n-js"></script>


</body>
</html>
