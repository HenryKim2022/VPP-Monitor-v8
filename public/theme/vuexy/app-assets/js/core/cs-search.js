/*=========================================================================================
  File Name: app.js
  Description: Template related app JS.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/
window.colors = {
    solid: {
        primary: '#7367F0',
        secondary: '#82868b',
        success: '#28C76F',
        info: '#00cfe8',
        warning: '#FF9F43',
        danger: '#EA5455',
        dark: '#4b4b4b',
        black: '#000',
        white: '#fff',
        body: '#f8f8f8'
    },
    light: {
        primary: '#7367F01a',
        secondary: '#82868b1a',
        success: '#28C76F1a',
        info: '#00cfe81a',
        warning: '#FF9F431a',
        danger: '#EA54551a',
        dark: '#4b4b4b1a'
    }
};
(function (window, document, $) {
    'use strict';
    var $html = $('html');
    var $body = $('body');
    var $textcolor = '#4e5154';
    var assetPath = '../../../public/theme/vuexy/app-assets/';

    if ($('body').attr('data-framework') === 'laravel') {
        assetPath = $('body').attr('data-asset-path');
    }

    /********************* Bookmark & Search ***********************/
    // This variable is used for mouseenter and mouseleave events of search list
    var $filename = $('.search-input input').data('search'),
        bookmarkWrapper = $('.bookmark-wrapper'),
        bookmarkStar = $('.bookmark-wrapper .bookmark-star'),
        bookmarkInput = $('.bookmark-wrapper .bookmark-input'),
        navLinkSearch = $('.nav-link-search'),
        searchInput = $('.search-input'),
        searchInputInputfield = $('.search-input input'),
        searchList = $('.search-input .search-list'),
        appContent = $('.app-content'),
        bookmarkSearchList = $('.bookmark-input .search-list');

    // Bookmark icon click
    bookmarkStar.on('click', function (e) {
        e.stopPropagation();
        bookmarkInput.toggleClass('show');
        bookmarkInput.find('input').val('');
        bookmarkInput.find('input').blur();
        bookmarkInput.find('input').focus();
        bookmarkWrapper.find('.search-list').addClass('show');

        var arrList = $('ul.nav.navbar-nav.bookmark-icons li'),
            $arrList = '',
            $activeItemClass = '';

        $('ul.search-list li').remove();

        for (var i = 0; i < arrList.length; i++) {
            if (i === 0) {
                $activeItemClass = 'current_item';
            } else {
                $activeItemClass = '';
            }

            var iconName = '',
                className = '';
            if ($(arrList[i].firstChild.firstChild).hasClass('feather')) {
                var classString = arrList[i].firstChild.firstChild.getAttribute('class');
                iconName = classString.split('feather-')[1].split(' ')[0];
                className = classString.split('feather-')[1].split(' ')[1];
            }

            $arrList +=
                '<li class="auto-suggestion ' +
                $activeItemClass +
                '">' +
                '<a class="d-flex align-items-center justify-content-between w-100" href=' +
                arrList[i].firstChild.href +
                '>' +
                '<div class="d-flex justify-content-start align-items-center">' +
                feather.icons[iconName].toSvg({ class: 'mr-75 ' + className }) +
                '<span>' +
                arrList[i].firstChild.dataset.originalTitle +
                '</span>' +
                '</div>' +
                feather.icons['star'].toSvg({ class: 'text-warning bookmark-icon float-right' }) +
                '</a>' +
                '</li>';
        }
        $('ul.search-list').append($arrList);
    });

    // Navigation Search area Open
    navLinkSearch.on('click', function () {
        var $this = $(this);
        var searchInput = $(this).parent('.nav-search').find('.search-input');
        searchInput.addClass('open');
        searchInputInputfield.focus();
        searchList.find('li').remove();
        bookmarkInput.removeClass('show');
    });

    // Navigation Search area Close
    $('.search-input-close').on('click', function () {
        var $this = $(this),
            searchInput = $(this).closest('.search-input');
        if (searchInput.hasClass('open')) {
            searchInput.removeClass('open');
            searchInputInputfield.val('');
            searchInputInputfield.blur();
            searchList.removeClass('show');
            appContent.removeClass('show-overlay');
        }
    });

    // Filter
    if ($('.search-list-main').length) {
        var searchListMain = new PerfectScrollbar('.search-list-main', {
            wheelPropagation: false
        });
    }
    if ($('.search-list-bookmark').length) {
        var searchListBookmark = new PerfectScrollbar('.search-list-bookmark', {
            wheelPropagation: false
        });
    }
    // update Perfect Scrollbar on hover
    $('.search-list-main').mouseenter(function () {
        searchListMain.update();
    });

    searchInputInputfield.on('keyup', function (e) {
        $(this).closest('.search-list').addClass('show');
        if (e.keyCode !== 38 && e.keyCode !== 40 && e.keyCode !== 13) {
            if (e.keyCode == 27) {
                appContent.removeClass('show-overlay');
                bookmarkInput.find('input').val('');
                bookmarkInput.find('input').blur();
                searchInputInputfield.val('');
                searchInputInputfield.blur();
                searchInput.removeClass('open');
                if (searchInput.hasClass('show')) {
                    $(this).removeClass('show');
                    searchInput.removeClass('show');
                }
            }

            // Define variables
            var value = $(this).val().toLowerCase(), //get values of input on keyup
                activeClass = '',
                bookmark = false,
                liList = $('ul.search-list li'); // get all the list items of the search
            liList.remove();
            // To check if current is bookmark input
            if ($(this).parent().hasClass('bookmark-input')) {
                bookmark = true;
            }

            // If input value is blank
            if (value != '') {
                appContent.addClass('show-overlay');

                // condition for bookmark and search input click
                if (bookmarkInput.focus()) {
                    bookmarkSearchList.addClass('show');
                } else {
                    searchList.addClass('show');
                    bookmarkSearchList.removeClass('show');
                }
                if (bookmark === false) {
                    searchList.addClass('show');
                    bookmarkSearchList.removeClass('show');
                }

                var $startList = '',
                    $otherList = '',
                    $htmlList = '',
                    $bookmarkhtmlList = '',
                    $pageList =
                        '<li class="d-flex align-items-center">' +
                        '<a href="javascript:void(0)">' +
                        '<h6 class="section-label mt-75 mb-0">Pages</h6>' +
                        '</a>' +
                        '</li>',
                    $activeItemClass = '',
                    $bookmarkIcon = '',
                    $defaultList = '',
                    a = 0;

                // getting json data from file for search results
                $.getJSON(assetPath + 'data/' + $filename + '.json', function (data) {
                    for (var i = 0; i < data.listItems.length; i++) {
                        // if current is bookmark then give class to star icon
                        // for laravel
                        if ($('body').attr('data-framework') === 'laravel') {
                            data.listItems[i].url = assetPath + data.listItems[i].url;
                        }

                        if (bookmark === true) {
                            activeClass = ''; // resetting active bookmark class
                            var arrList = $('ul.nav.navbar-nav.bookmark-icons li'),
                                $arrList = '';
                            // Loop to check if current seach value match with the bookmarks already there in navbar
                            for (var j = 0; j < arrList.length; j++) {
                                if (data.listItems[i].name === arrList[j].firstChild.dataset.originalTitle) {
                                    activeClass = ' text-warning';
                                    break;
                                } else {
                                    activeClass = '';
                                }
                            }

                            $bookmarkIcon = feather.icons['star'].toSvg({ class: 'bookmark-icon float-right' + activeClass });
                        }
                        // Search list item start with entered letters and create list
                        if (data.listItems[i].name.toLowerCase().indexOf(value) == 0 && a < 5) {
                            if (a === 0) {
                                $activeItemClass = 'current_item';
                            } else {
                                $activeItemClass = '';
                            }
                            $startList +=
                                '<li class="auto-suggestion ' +
                                $activeItemClass +
                                '">' +
                                '<a class="d-flex align-items-center justify-content-between w-100" href=' +
                                data.listItems[i].url +
                                '>' +
                                '<div class="d-flex justify-content-start align-items-center">' +
                                feather.icons[data.listItems[i].icon].toSvg({ class: 'mr-75 ' }) +
                                '<span>' +
                                data.listItems[i].name +
                                '</span>' +
                                '</div>' +
                                $bookmarkIcon +
                                '</a>' +
                                '</li>';
                            a++;
                        }
                    }
                    for (var i = 0; i < data.listItems.length; i++) {
                        if (bookmark === true) {
                            activeClass = ''; // resetting active bookmark class
                            var arrList = $('ul.nav.navbar-nav.bookmark-icons li'),
                                $arrList = '';
                            // Loop to check if current search value match with the bookmarks already there in navbar
                            for (var j = 0; j < arrList.length; j++) {
                                if (data.listItems[i].name === arrList[j].firstChild.dataset.originalTitle) {
                                    activeClass = ' text-warning';
                                } else {
                                    activeClass = '';
                                }
                            }

                            $bookmarkIcon = feather.icons['star'].toSvg({ class: 'bookmark-icon float-right' + activeClass });
                        }
                        // Search list item not start with letters and create list
                        if (
                            !(data.listItems[i].name.toLowerCase().indexOf(value) == 0) &&
                            data.listItems[i].name.toLowerCase().indexOf(value) > -1 &&
                            a < 5
                        ) {
                            if (a === 0) {
                                $activeItemClass = 'current_item';
                            } else {
                                $activeItemClass = '';
                            }
                            $otherList +=
                                '<li class="auto-suggestion ' +
                                $activeItemClass +
                                '">' +
                                '<a class="d-flex align-items-center justify-content-between w-100" href=' +
                                data.listItems[i].url +
                                '>' +
                                '<div class="d-flex justify-content-start align-items-center">' +
                                feather.icons[data.listItems[i].icon].toSvg({ class: 'mr-75 ' }) +
                                '<span>' +
                                data.listItems[i].name +
                                '</span>' +
                                '</div>' +
                                $bookmarkIcon +
                                '</a>' +
                                '</li>';
                            a++;
                        }
                    }
                    $defaultList = $('.main-search-list-defaultlist').html();
                    if ($startList == '' && $otherList == '') {
                        $otherList = $('.main-search-list-defaultlist-other-list').html();
                    }
                    // concatinating startlist, otherlist, defalutlist with pagelist
                    $htmlList = $pageList.concat($startList, $otherList, $defaultList);
                    $('ul.search-list').html($htmlList);
                    // concatinating otherlist with startlist
                    $bookmarkhtmlList = $startList.concat($otherList);
                    $('ul.search-list-bookmark').html($bookmarkhtmlList);
                    // Feather Icons
                    // if (feather) {
                    //   featherSVG();
                    // }
                });
            } else {
                if (bookmark === true) {
                    var arrList = $('ul.nav.navbar-nav.bookmark-icons li'),
                        $arrList = '';
                    for (var i = 0; i < arrList.length; i++) {
                        if (i === 0) {
                            $activeItemClass = 'current_item';
                        } else {
                            $activeItemClass = '';
                        }

                        var iconName = '',
                            className = '';
                        if ($(arrList[i].firstChild.firstChild).hasClass('feather')) {
                            var classString = arrList[i].firstChild.firstChild.getAttribute('class');
                            iconName = classString.split('feather-')[1].split(' ')[0];
                            className = classString.split('feather-')[1].split(' ')[1];
                        }
                        $arrList +=
                            '<li class="auto-suggestion">' +
                            '<a class="d-flex align-items-center justify-content-between w-100" href=' +
                            arrList[i].firstChild.href +
                            '>' +
                            '<div class="d-flex justify-content-start align-items-center">' +
                            feather.icons[iconName].toSvg({ class: 'mr-75 ' }) +
                            '<span>' +
                            arrList[i].firstChild.dataset.originalTitle +
                            '</span>' +
                            '</div>' +
                            feather.icons['star'].toSvg({ class: 'text-warning bookmark-icon float-right' }) +
                            '</a>' +
                            '</li>';
                    }
                    $('ul.search-list').append($arrList);
                    // Feather Icons
                    // if (feather) {
                    //   featherSVG();
                    // }
                } else {
                    // if search input blank, hide overlay
                    if (appContent.hasClass('show-overlay')) {
                        appContent.removeClass('show-overlay');
                    }
                    // If filter box is empty
                    if (searchList.hasClass('show')) {
                        searchList.removeClass('show');
                    }
                }
            }
        }
    });

    // Add class on hover of the list
    $(document).on('mouseenter', '.search-list li', function (e) {
        $(this).siblings().removeClass('current_item');
        $(this).addClass('current_item');
    });
    $(document).on('click', '.search-list li', function (e) {
        e.stopPropagation();
    });

    $('html').on('click', function ($this) {
        if (!$($this.target).hasClass('bookmark-icon')) {
            if (bookmarkSearchList.hasClass('show')) {
                bookmarkSearchList.removeClass('show');
            }
            if (bookmarkInput.hasClass('show')) {
                bookmarkInput.removeClass('show');
                appContent.removeClass('show-overlay');
            }
        }
    });

    // Prevent closing bookmark dropdown on input textbox click
    $(document).on('click', '.bookmark-input input', function (e) {
        bookmarkInput.addClass('show');
        bookmarkSearchList.addClass('show');
    });

    // Favorite star click
    $(document).on('click', '.bookmark-input .search-list .bookmark-icon', function (e) {
        e.stopPropagation();
        if ($(this).hasClass('text-warning')) {
            $(this).removeClass('text-warning');
            var arrList = $('ul.nav.navbar-nav.bookmark-icons li');
            for (var i = 0; i < arrList.length; i++) {
                if (arrList[i].firstChild.dataset.originalTitle == $(this).parent()[0].innerText) {
                    arrList[i].remove();
                }
            }
            e.preventDefault();
        } else {
            var arrList = $('ul.nav.navbar-nav.bookmark-icons li');
            $(this).addClass('text-warning');
            e.preventDefault();
            var $url = $(this).parent()[0].href,
                $name = $(this).parent()[0].innerText,
                $listItem = '',
                $listItemDropdown = '',
                iconName = $(this).parent()[0].firstChild.firstChild.dataset.icon;
            if ($($(this).parent()[0].firstChild.firstChild).hasClass('feather')) {
                var classString = $(this).parent()[0].firstChild.firstChild.getAttribute('class');
                iconName = classString.split('feather-')[1].split(' ')[0];
            }
            $listItem =
                '<li class="nav-item d-none d-lg-block">' +
                '<a class="nav-link" href="' +
                $url +
                '" data-toggle="tooltip" data-placement="top" title="" data-original-title="' +
                $name +
                '">' +
                feather.icons[iconName].toSvg({ class: 'ficon' }) +
                '</a>' +
                '</li>';
            $('ul.nav.bookmark-icons').append($listItem);
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    // If we use up key(38) Down key (40) or Enter key(13)
    $(window).on('keydown', function (e) {
        var $current = $('.search-list li.current_item'),
            $next,
            $prev;
        if (e.keyCode === 40) {
            $next = $current.next();
            $current.removeClass('current_item');
            $current = $next.addClass('current_item');
        } else if (e.keyCode === 38) {
            $prev = $current.prev();
            $current.removeClass('current_item');
            $current = $prev.addClass('current_item');
        }

        if (e.keyCode === 13 && $('.search-list li.current_item').length > 0) {
            var selected_item = $('.search-list li.current_item a');
            window.location = selected_item.attr('href');
            $(selected_item).trigger('click');
        }
    });

    // Waves Effect
    Waves.init();
    Waves.attach(
        ".btn:not([class*='btn-relief-']):not([class*='btn-gradient-']):not([class*='btn-outline-']):not([class*='btn-flat-'])",
        ['waves-float', 'waves-light']
    );
    Waves.attach("[class*='btn-outline-']");
    Waves.attach("[class*='btn-flat-']");


})(window, document, jQuery);

